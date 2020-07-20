<?php
require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../definitions.php';

session_start();

$title = '';
$username = '';
$id = '';
$firmenname = '';
$anrede = '';
$ansprechpartner = '';
$email = '';
$telefon = '';
$strasse = '';
$hausnummer = '';
$plz = '';
$ort = '';
$land = '';
$z_telefon = '';
$freitext = '';
$first_update = false;

if (isset($_SESSION['username'])) {
    $title = 'Welcome, ' . $_SESSION['username'] . '!';
    $username = $_SESSION['username'];
} else {
    header('location: ' . URL . 'logout.php');
    die;
}

// Get the user information.

$sql = "SELECT id, firmenname, anrede, ansprechpartner, email, telefon, strasse, hausnummer, plz, ort, land, telefon_zentrale, freitext, first_update FROM kunden WHERE username = ?";

if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("s", $username);
    if ($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $firmenname, $anrede, $ansprechpartner, $email, $telefon, $strasse, $hausnummer, $plz, $ort, $land, $z_telefon, $freitext, $first_update);
            $stmt->fetch();
            $stmt->free_result();
        }
    } else {
        die("Something went wrong with MySQL.");
    }

    $stmt->close();
}

// Set the completed value of the anfrage to true.
if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['anfrage_id']) && !empty($_POST['anfrage_id'])) {
    $anfrage_id = $_POST['anfrage_id'];
    $sql = "UPDATE anfragen SET completed = 1 WHERE id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $anfrage_id);
        // Attempt to execute the prepared statement
        if (!$stmt->execute()) {
            die('MySQL Fehler.');
        }
        // Close statement
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <!-- Bootstrap start -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <!-- Bootstrap end -->

    <!-- Data tables start -->

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <!-- Data tables end -->

    <style>
        .nav {
            width: 100vw;
            font-weight: 900;
        }

        .nav li:last-of-type {
            position: absolute;
            right: 0;
            z-index: 200;
        }

        .heading {
            text-align: center;
        }

        .update_passwort_div {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dataTables_filter,
        .dataTables_length {
            text-align: center !important;
        }
    </style>

    <script>
        jQuery(document).ready(function($) {

            $('.toast').toast({
                delay: 3500
            });

            $('#kunden_table').DataTable({
                pageLength: 50,
                lengthMenu: [50, 100],
                language: {
                    lengthMenu: "_MENU_ Einträge anzeigen"
                }
            });


            $('#bv_hausnummer').on('keyup', function(e) {
                let numReg = new RegExp("\d+");
                let inputVal = e.target.value;
                let matchObj = inputVal.match(/\d+/);
                if (!matchObj) {
                    e.target.value = '';
                } else if (matchObj && matchObj[0] !== inputVal) {
                    e.target.value = matchObj[0];
                }
            });

            // Handle the update of the regular user information.
            $('form#update_benutzer').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '<?= URL . 'user_content/update_client.php' ?>',
                    type: "post",
                    dataType: "json",
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data['success']) {
                            $('.toast .toast-body').html('Die Daten wurden erneuert.');
                            $('.toast').toast('show');
                        } else {
                            $('.toast .toast-body').html(data['msg']);
                            $('.toast').toast('show');
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        $('.toast .toast-body').html('Ein Fehler is aufgetretten.');
                        $('.toast').toast('show');
                    }
                });
            });
            // Handle the update of the user password.
            $('form#update_passwort').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '<?= URL . 'user_content/update_client.php' ?>',
                    type: "post",
                    dataType: "json",
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data['success']) {
                            $('.toast .toast-body').html('Das Passwort wurde erneuert.');
                            $('.toast').toast('show');
                        } else {
                            $('.toast .toast-body').html(data['msg']);
                            $('.toast').toast('show');
                        }
                        $('form#update_passwort').trigger('reset');
                    },
                    error: function(data) {
                        console.log(data);
                        $('.toast .toast-body').html('Ein Fehler is aufgetretten.');
                        $('.toast').toast('show');
                    }
                });
            });
        });
    </script>
</head>

<body>

    <ul class="nav nav-tabs" data-tabs="tabs">
        <li class="nav-item">
            <a class="nav-link active" href="#anfragen" data-toggle="tab">Meine Anfragen</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#mein_profil" data-toggle="tab">Mein Profil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#auftraege" data-toggle="tab">Meine Aufträge</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#kunden" data-toggle="tab">Kunden</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Sprache</a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Deutsch</a>
                <a class="dropdown-item" href="#">Englisch</a>
                <a class="dropdown-item" href="#">Spanisch</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= URL . 'logout.php' ?>">Ausloggen</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="anfragen">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Anfragezeit</th>
                        <th scope="col">PLZ Start</th>
                        <th scope="col">PLZ Ziel</th>
                        <th scope="col">Zeitfenster</th>
                        <th scope="col">Zustelltag</th>
                        <th scope="col">Volumengewicht</th>
                        <th scope="col">Gewünschte Serviceleistungen</th>
                        <th scope="col">Name</th>
                        <th scope="col">E-Mail</th>
                        <th scope="col">Telefon</th>
                        <th scope="col">Kontaktwunsch</th>
                        <th scope="col">X</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Get the user package requests.
                    $sql = "SELECT id, zeit, plz_start, plz_ziel, zeit_fenster,
                                zustelltag, volumengewicht, service_leistung, kunden_name,
                                email , telefon, kontakt_wunsch, aktionen, completed
                                FROM anfragen WHERE kunden_id = ?";

                    if ($stmt = $mysqli->prepare($sql)) {
                        $stmt->bind_param("i", $id);
                        if ($stmt->execute()) {
                            $result = $stmt->get_result();
                            $zeit = '';
                            while ($row = $result->fetch_assoc()) {
                                if ($row["service_leistung"] == '{}') {
                                    $row["service_leistung"] = '';
                                }
                                $eye_img_url = '';
                                if ($row['completed']) {
                                    $eye_img_url = URL . 'images/orange_eye.gif';
                                } else {
                                    $eye_img_url = URL . 'images/grey_eye.gif';
                                }
                                echo
                                    '<tr>
                                    <td>' . $row['zeit'] . '</td>
                                    <td>' . $row['plz_start'] . '</td>
                                    <td>' . $row['plz_ziel'] . '</td>
                                    <td>' . $row['zeit_fenster'] . '</td>
                                    <td>' . $row['zustelltag'] . '</td>
                                    <td>' . $row['volumengewicht'] . '</td>
                                    <td>' . $row['service_leistung'] . '</td>
                                    <td>' . $row['kunden_name'] . '</td>
                                    <td>' . $row['email'] . '</td>
                                    <td>' . $row['telefon'] . '</td>
                                    <td>' . $row['kontakt_wunsch'] . '</td>
                                    <td>
                                        <img id="eye_nr_' . $row['id'] . '" style="cursor: pointer;" src="' . $eye_img_url . '">
                                    </td>

                                    <script>
                                    jQuery(document).ready(function(){
                                        jQuery("#eye_nr_' . $row['id'] . '").on("click", function() {
                                            jQuery(this).prop("src","' . URL . "images/orange_eye.gif\"" . ');
                                            jQuery.ajax({
                                                type: "post",
                                                data: {anfrage_id: ' . $row['id'] . '},
                                                dataType: "json",
                                                success: function() {
                                                    console.log(123);
                                                }

                                            });
                                        });
                                    });
                                    </script>
                                </tr>';
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="tab-pane" id="auftraege">

        </div>
        <div class="tab-pane" id="mein_profil">
            <div class="container-fluid">
                <div class="row">
                    <h5 style="margin: 25px 0 0 25px;">Ihre KundenID:<span style="margin-left: 5px; padding: 0 5px 0 5px; background-color: #eff0f1; border: 1px solid #b1b3b1;"><?= $id ?></span></h5>
                </div>
                <div class="row">
                    <div class="col">
                        <br>
                        <h5 class="text-muted heading">Hier können Sie Ihr Profil anpassen.</b></h5>
                        <br>
                        <form id="update_benutzer" method="POST">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input value="<?= $id ?>" required readonly type="hidden" class="form-control" id="bv_kundenid1" name="bv_kundenid">
                                        </div>
                                        <div class="form-group">
                                            <label for="bv_firmenname">Firmenname</label>
                                            <input value="<?= $firmenname ?>" required type="text" class="form-control" id="bv_firmenname" name="bv_firmenname" placeholder="Firmenname ...">
                                        </div>
                                        <div class="form-group input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="bv_anrede">Anrede</label>
                                            </div>
                                            <select class="custom-select" id="bv_anrede" name="bv_anrede">
                                                <option <?= $anrede === 'Herr' ? 'selected' : '' ?> value="Herr">Herr</option>
                                                <option <?= $anrede === 'Frau' ? 'selected' : '' ?> value="Frau">Frau</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="bv_ansprechpartner">Ansprechpartner</label>
                                            <input value="<?= $ansprechpartner ?>" required type="text" class="form-control" id="bv_ansprechpartner" name="bv_ansprechpartner" placeholder="Ansprechpartner ...">
                                        </div>

                                        <div class="form-group">
                                            <label for="bv_email">Email</label>
                                            <input value="<?= $email ?>" required type="email" class="form-control" id="bv_email" name="bv_email" placeholder="Email Adresse ...">
                                        </div>

                                        <div class="form-group">
                                            <label for="bv_telefon">Telefon</label>
                                            <input value="<?= $telefon ?>" required type="tel" class="form-control" id="bv_telefon" name="bv_telefon" placeholder="Telefon ...">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="bv_strasse">Straße</label>
                                            <input value="<?= $strasse ?>" required type="text" class="form-control" id="bv_strasse" name="bv_strasse" placeholder="Straße ...">
                                        </div>
                                        <div class="form-group">
                                            <label for="bv_hausnummer">Hausnummer</label>
                                            <input value="<?= $hausnummer ?>" required type="text" class="form-control" id="bv_hausnummer" name="bv_hausnummer" placeholder="Hausnummer ...">
                                        </div>
                                        <div class="form-group">
                                            <label for="bv_plz">PLZ</label>
                                            <input value="<?= $plz ?>" required type="number" class="form-control" id="bv_plz" name="bv_plz" placeholder="PLZ ...">
                                        </div>
                                        <div class="form-group">
                                            <label for="bv_ort">Ort</label>
                                            <input value="<?= $ort ?>" required type="text" class="form-control" id="bv_ort" name="bv_ort" placeholder="Ort ...">
                                        </div>
                                        <div class="form-group">
                                            <label for="bv_land">Land</label>
                                            <input value="<?= $land ?>" required type="text" class="form-control" id="bv_land" name="bv_land" placeholder="Land ...">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="bv_ztelefon">Zentrale Telefonnummer</label>
                                            <input value="<?= $z_telefon ?>" required type="tel" class="form-control" id="bv_ztelefon" name="bv_ztelefon" placeholder="Zentrale Telefonnummer ...">
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" id="bv_freitext" name="bv_freitext" rows="11" placeholder="Freitext ..."><?= $freitext ?></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Angaben speichern</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col">
                        <br>
                        <h5 class="text-muted heading">Hier können Sie Ihr Passwort ändern.</h5>
                        <br>
                        <div class="update_passwort_div">
                            <form method="POST" id="update_passwort">
                                <div class="form-group">
                                    <input value="<?= $id ?>" required readonly type="hidden" class="form-control" id="bv_kundenid2" name="bv_kundenid">
                                </div>

                                <div class="form-group">
                                    <label for="bv_benutzername">Benutzername</label>
                                    <input required type="text" class="form-control" id="bv_benutzername" name="bv_benutzername" placeholder="Benutzername ...">
                                </div>
                                <div class="form-group">
                                    <label for="bv_alt_passwort">Altes Passwort</label>
                                    <input required type="password" class="form-control" id="bv_alt_passwort" name="bv_alt_passwort" placeholder="Altes Passwort ...">
                                </div>
                                <div class="form-group">
                                    <label for="bv_neu1_passwort">Neues Passwort</label>
                                    <input required type="password" class="form-control" id="bv_neu1_passwort" name="bv_neu1_passwort" placeholder="Neues Passwort ...">
                                </div>
                                <div class="form-group">
                                    <label for="bv_neu2_passwort">Neues Passwort wiederholen</label>
                                    <input required type="password" class="form-control" id="bv_neu2_passwort" name="bv_neu2_passwort" placeholder="Neues Passwort ...">
                                </div>
                                <button type="submit" class="btn btn-primary">Passwort ändern</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="kunden">
            <br>
            <h5 class="text-muted heading">Hier können Sie die Kunden durchsuchen.</h5>
            <br><br>
            <div class="table-responsive">
                <table id="kunden_table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Firmenname</th>
                            <th scope="col">Anrede</th>
                            <th scope="col">Ansprechpartner</th>
                            <th scope="col">Email</th>
                            <th scope="col">Telefon</th>
                            <th scope="col">Straße</th>
                            <th scope="col">Hausnummer</th>
                            <th scope="col">PLZ</th>
                            <th scope="col">Ort</th>
                            <th scope="col">Land</th>
                            <th scope="col">Telefon(Zentrale)</th>
                            <th scope="col">Notizen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Get the user package requests.
                        $sql = "SELECT id, firmenname, anrede, ansprechpartner, email, telefon, strasse,
                        hausnummer, plz, ort, land, telefon_zentrale, freitext
                     FROM kunden";

                        if ($stmt = $mysqli->prepare($sql)) {
                            if ($stmt->execute()) {
                                $result = $stmt->get_result();
                                $zeit = '';
                                while ($row = $result->fetch_assoc()) {
                                    echo
                                        '<tr>
                                    <td>' . $row['firmenname'] . '</td>
                                    <td>' . $row['anrede'] . '</td>
                                    <td>' . $row['ansprechpartner'] . '</td>
                                    <td>' . $row['email'] . '</td>
                                    <td>' . $row['telefon'] . '</td>
                                    <td>' . $row['strasse'] . '</td>
                                    <td>' . $row['hausnummer'] . '</td>
                                    <td>' . $row['plz'] . '</td>
                                    <td>' . $row['ort'] . '</td>
                                    <td>' . $row['land'] . '</td>
                                    <td>' . $row['telefon_zentrale'] . '</td>
                                    <td>' . $row['freitext'] . '</td>
                                    </tr>';
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <br>
            </div>

        </div>
    </div>

    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; top: 15px; right: 15px;">
        <div class="toast-header">
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body"></div>
    </div>

</body>

</html>
<?php
$mysqli->close();
?>