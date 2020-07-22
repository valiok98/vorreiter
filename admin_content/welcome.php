<?php
require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../definitions.php';

session_start();

$title = '';

if (isset($_SESSION['username'])) {
    $title = 'Welcome, ' . $_SESSION['username'] . '!';
    $username = $_SESSION['username'];
} else {
    header('location: ' . URL . 'logout.php');
    die;
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

    <!-- jQuery UI start -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

    <!-- jQuery UI end -->

    <!-- Editable start -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <!-- Editable end -->

    <!-- Moment.js start -->
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <!-- Moment.js end -->

    <!-- Eigenes CSS start -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Eigenes CSS end -->

    <!-- Eigenes JS start -->
    <script src="js/script.js"></script>
    <!-- Eigenes JS end -->

    <script>
        jQuery(document).ready(function($) {

            $('form#create_benutzer').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '<?= URL . 'admin_content/create_client.php' ?>',
                    type: "post",
                    dataType: "json",
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data['success']) {
                            $('.toast .toast-body').html('Benutzer erfolgreich angelegt.');
                            $('.toast').toast('show');
                        } else {
                            $('.toast .toast-body').html(data['message']);
                            $('.toast').toast('show');
                        }
                        $('form#create_benutzer').trigger('reset');
                    },
                    error: function(data) {
                        console.log(data);
                        $('.toast .toast-body').html('Ein Fehler is aufgetretten.');
                        $('.toast').toast('show');
                    }
                });
            });

            $('form#auftrag_erstellen2').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '<?= URL . 'admin_content/create_auftrag.php' ?>',
                    type: "post",
                    dataType: "json",
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data['success']) {
                            $('.toast .toast-body').html('Auftrag erfolgreich angelegt.');
                            $('.toast').toast('show');
                        } else {
                            $('.toast .toast-body').html(data['message']);
                            $('.toast').toast('show');
                        }
                        $('form#auftrag_erstellen2').trigger('reset');
                        $('#ae_abholadresse').hide();
                        $('label[for="ae_abholadresse"]').hide();
                        $('#ae_abholadresse').removeAttr('required');

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

    <div class="container-fluid">
        <div class="row">
            <div id="div_sidenav" class="col-sm-1">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#div_sidenav-collapsed" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div id="div_sidenav-collapsed" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav mr-auto flex-column" data-tabs="tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#vorreiter" data-toggle="tab">
                                    <img id="vorreiter_img" src="../images/navbar/vorreiter_logo.png" alt="vorreiter">
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#kunden" data-toggle="tab">
                                    <img id="img_kunden" src="../images/navbar/kunden_b_w.png" alt="kunden">
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#an_auf_data" data-toggle="tab">
                                    <img id="img_an-auf" src="../images/navbar/an_auf_b_w.png" alt="anfragen&aufträge">
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tracking" data-toggle="tab">
                                    <img id="img_tracking" src="../images/navbar/tracking_b_w.png" alt="tracking">
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#flotte" data-toggle="tab">
                                    <img id="img_flotte" src="../images/navbar/flotte_b_w.png" alt="flotte">
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#support" data-toggle="tab">
                                    <img id="img_support" src="../images/navbar/support_b_w.png" alt="support">
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#stats" data-toggle="tab">
                                    <img id="img_stats" src="../images/navbar/stats_b_w.png" alt="stats">
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#settings" data-toggle="tab">
                                    <img id="img_settings" src="../images/navbar/settings_b_w.png" alt="settings">
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div id="div_main-content" class="col-sm-11">
                <nav class="navbar navbar-expand-lg navbar-light main-nav">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <form class="form-inline">
                            <input class="form-control mr-sm-2" type="search" placeholder="Suche..." aria-label="Search">
                            <img id="img_suchen" src="../images/navbar/suchen.png" alt="suchen">
                        </form>
                        <ul class="navbar-nav mr-auto">
                            <li id="li_angemeldet-als" class="nav-item">
                                <a href="#" class="nav-link">
                                    <span>Angemeldet als:&nbsp;
                                        <?= $_SESSION["username"] ?>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <img src="../images/navbar/notifications.png" alt="notifications">
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= URL . 'logout.php' ?>">
                                    <img src="../images/navbar/logout.png" alt="logout">
                                    <span id="span_logout">Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <div class="tab-content">
                    <div id="kunden" class="tab-pane">
                        <h1>kunden</h1>
                    </div>
                    <div class="tab-pane active container-fluid" id="vorreiter">
                        <div class="row">
                            <div class="col-sm-6 container-fluid">
                                <div class="row div_table-header">
                                    <h3>Anfragen</h3>
                                    <div>
                                        <img src="../images/an_auf_table/eye.png" alt="">
                                        <img src="../images/an_auf_table/anfrage_erstellen.png" alt="">
                                    </div>
                                </div>
                                <div class="row div_an-auf-table-data">
                                    <table id="anfragen_table" class="compact">
                                        <thead>
                                            <tr>
                                                <th scope="col">Kunde</th>
                                                <th scope="col">Eingegangen</th>
                                                <th scope="col">Von</th>
                                                <th scope="col">Nach</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Aktionen</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Get the user package requests.
                                            $sql = "SELECT * FROM anfragen";

                                            if ($stmt = $mysqli->prepare($sql)) {
                                                if ($stmt->execute()) {
                                                    $result = $stmt->get_result();
                                                    $zeit = '';
                                                    while ($row = $result->fetch_assoc()) {
                                                        if ($row["service_leistung"] == '{}') {
                                                            $row["service_leistung"] = '';
                                                        }
                                                        $eye_img_url = '';

                                                        $action_img_auftrag = URL . 'images/customer_profile.gif';
                                                        $action_span_auftrag = 'Daten zur Anfrage anzeigen';
                                                        $action_img_nonauftrag = URL . 'images/customer_request.gif';
                                                        $action_span_nonauftrag = 'In Kunde und Auftrag umwandeln';

                                                        $action_img_url = '';
                                                        $action_span_text = '';

                                                        if ($row['completed']) {
                                                            $eye_img_url = URL . 'images/orange_eye.gif';
                                                        } else {
                                                            $eye_img_url = URL . 'images/grey_eye.gif';
                                                        }

                                                        if ($row['ist_auftrag']) {
                                                            $action_img_url = URL . 'images/customer_profile.gif';
                                                            $action_span_text = 'Daten zur Anfrage anzeigen';
                                                        } else {
                                                            $action_img_url = URL . 'images/customer_request.gif';
                                                            $action_span_text = 'In Auftrag umwandeln';
                                                        }
                                                        // Initialize the dialog.
                                                        require_once dirname(__FILE__) . '/templates/welcome.tmp.php';
                                                        echo anfragen_table(
                                                            $row,
                                                            $action_img_url,
                                                            $action_span_text,
                                                            $eye_img_url,
                                                            $action_img_auftrag,
                                                            $action_span_auftrag
                                                        );
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-6 container-fluid">
                                <div class="row div_table-header">
                                    <h3>Aufträge</h3>
                                    <div>
                                        <img src="../images/an_auf_table/eye.png" alt="">
                                        <img src="../images/an_auf_table/auftrag_erstellen.png" alt="">
                                    </div>
                                </div>
                                <div class="row div_an-auf-table-data">
                                    <table id="auftraege_table" class="compact">
                                        <thead>
                                            <tr>
                                                <th scope="col">Kunde</th>
                                                <th scope="col">Eingegangen</th>
                                                <th scope="col">Von</th>
                                                <th scope="col">Nach</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Aktionen</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Get the user package requests.
                                            $sql = "SELECT * FROM auftraege";

                                            if ($stmt = $mysqli->prepare($sql)) {
                                                if ($stmt->execute()) {
                                                    $result = $stmt->get_result();
                                                    $zeit = '';
                                                    while ($row = $result->fetch_assoc()) {
                                                        if ($row["service_leistung"] == '{}') {
                                                            $row["service_leistung"] = '';
                                                        }
                                                        $eye_img_url = '';

                                                        $action_img_auftrag = URL . 'images/customer_profile.gif';
                                                        $action_span_auftrag = 'Daten zur Anfrage anzeigen';
                                                        $action_img_nonauftrag = URL . 'images/customer_request.gif';
                                                        $action_span_nonauftrag = 'In Kunde und Auftrag umwandeln';

                                                        $action_img_url = '';
                                                        $action_span_text = '';

                                                        if ($row['completed']) {
                                                            $eye_img_url = URL . 'images/orange_eye.gif';
                                                        } else {
                                                            $eye_img_url = URL . 'images/grey_eye.gif';
                                                        }

                                                        if ($row['ist_auftrag']) {
                                                            $action_img_url = URL . 'images/customer_profile.gif';
                                                            $action_span_text = 'Daten zur Anfrage anzeigen';
                                                        } else {
                                                            $action_img_url = URL . 'images/customer_request.gif';
                                                            $action_span_text = 'In Auftrag umwandeln';
                                                        }
                                                        // Initialize the dialog.
                                                        require_once dirname(__FILE__) . '/templates/welcome.tmp.php';
                                                        echo anfragen_table(
                                                            $row,
                                                            $action_img_url,
                                                            $action_span_text,
                                                            $eye_img_url,
                                                            $action_img_auftrag,
                                                            $action_span_auftrag
                                                        );
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane table-responsive" id="an_auf_data">
                        <br><br>
                        <table id="anfragen_table1" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">KundenID</th>
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
                                    <th scope="col">Aktionen</th>
                                    <th scope="col">X</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Get the user package requests.
                                $sql = "SELECT id, zeit, plz_start, plz_ziel, zeit_fenster,
                                zustelltag, volumengewicht, service_leistung, kunden_name,
                                email , telefon, kontakt_wunsch, aktionen, completed, ist_auftrag, kunden_id
                                FROM anfragen";

                                if ($stmt = $mysqli->prepare($sql)) {
                                    if ($stmt->execute()) {
                                        $result = $stmt->get_result();
                                        $zeit = '';
                                        while ($row = $result->fetch_assoc()) {
                                            if ($row["service_leistung"] == '{}') {
                                                $row["service_leistung"] = '';
                                            }
                                            $eye_img_url = '';

                                            $action_img_auftrag = URL . 'images/customer_profile.gif';
                                            $action_span_auftrag = 'Daten zur Anfrage anzeigen';
                                            $action_img_nonauftrag = URL . 'images/customer_request.gif';
                                            $action_span_nonauftrag = 'In Kunde und Auftrag umwandeln';

                                            $action_img_url = '';
                                            $action_span_text = '';

                                            if ($row['completed']) {
                                                $eye_img_url = URL . 'images/orange_eye.gif';
                                            } else {
                                                $eye_img_url = URL . 'images/grey_eye.gif';
                                            }

                                            if ($row['ist_auftrag']) {
                                                $action_img_url = URL . 'images/customer_profile.gif';
                                                $action_span_text = 'Daten zur Anfrage anzeigen';
                                            } else {
                                                $action_img_url = URL . 'images/customer_request.gif';
                                                $action_span_text = 'In Auftrag umwandeln';
                                            }
                                            // Initialize the dialog.
                                            require_once dirname(__FILE__) . '/templates/welcome.tmp.php';
                                            echo anfragen_table(
                                                $row,
                                                $action_img_url,
                                                $action_span_text,
                                                $eye_img_url,
                                                $action_img_auftrag,
                                                $action_span_auftrag
                                            );
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane" id="benutzerverwaltung">
                        <br>
                        <h5 class="text-muted heading">Hier können Sie einen neuen Benutzer anlegen.</b></h5>
                        <br>
                        <form id="create_benutzer" method="POST">
                            <div>
                                <div class="form-group">
                                    <label for="bv_firmenname">Firmenname</label>
                                    <input required type="text" class="form-control" id="bv_firmenname" name="bv_firmenname" placeholder="Firmenname ...">
                                </div>
                                <br>
                                <div class="form-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="bv_anrede">Anrede</label>
                                    </div>
                                    <select class="custom-select" id="bv_anrede" name="bv_anrede">
                                        <option value="Herr">Herr</option>
                                        <option value="Frau">Frau</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="bv_ansprechpartner">Ansprechpartner</label>
                                    <input required type="text" class="form-control" id="bv_ansprechpartner" name="bv_ansprechpartner" placeholder="Ansprechpartner ...">
                                </div>

                                <div class="form-group">
                                    <label for="bv_email">Email</label>
                                    <input required type="email" class="form-control" id="bv_email" name="bv_email" placeholder="Email Adresse ...">
                                </div>

                                <div class="form-group">
                                    <label for="bv_telefon">Telefon</label>
                                    <input required type="tel" class="form-control" id="bv_telefon" name="bv_telefon" placeholder="Telefon ...">
                                </div>
                            </div>
                            <div>
                                <div class="form-group">
                                    <label for="bv_strasse">Straße</label>
                                    <input required type="text" class="form-control" id="bv_strasse" name="bv_strasse" placeholder="Straße ...">
                                </div>
                                <div class="form-group">
                                    <label for="bv_hausnummer">Hausnummer</label>
                                    <input required type="text" class="form-control" id="bv_hausnummer" name="bv_hausnummer" placeholder="Hausnummer ...">
                                </div>
                                <div class="form-group">
                                    <label for="bv_plz">PLZ</label>
                                    <input required type="number" class="form-control" id="bv_plz" name="bv_plz" placeholder="PLZ ...">
                                </div>
                                <div class="form-group">
                                    <label for="bv_ort">Ort</label>
                                    <input required type="text" class="form-control" id="bv_ort" name="bv_ort" placeholder="Ort ...">
                                </div>
                                <div class="form-group">
                                    <label for="bv_land">Land</label>
                                    <input required type="text" class="form-control" id="bv_land" name="bv_land" placeholder="Land ...">
                                </div>
                            </div>
                            <div>
                                <div class="form-group">
                                    <label for="bv_ztelefon">Zentrale Telefonnummer</label>
                                    <input required type="tel" class="form-control" id="bv_ztelefon" name="bv_ztelefon" placeholder="Zentrale Telefonnummer ...">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" id="bv_freitext" name="bv_freitext" rows="10" placeholder="Freitext ..."></textarea>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="bv_kunden_informieren" id="bv_kunden_informieren">
                                    <label class="form-check-label" for="bv_kunden_informieren">Kunden über Accounterstellung via E-Mail informieren</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Anlegen</button>
                            </div>
                        </form>
                        <!-- Tabelle mit den Nutzern -->
                        <br>
                        <br>
                        <div class="tab-pane" id="kunden">
                            <br>
                            <h5 class="text-muted heading">Hier können Sie die Kunden durchsuchen.</h5>
                            <h5 class="text-muted heading">Sie können auch direkt einen Auftrag erstellen.</h5>
                            <br><br>
                            <div class="table-responsive">
                                <table id="kunden_table_1" class="table table-bordered">
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
                                                    echo '<tr>
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
                    <div class="tab-pane" id="auftraege">
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#auftraege_erstellen" data-toggle="tab">Auftrag erstellen</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#auftraege_durchsuchen" data-toggle="tab">Durchsuchen</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="auftraege_erstellen">
                                <br>
                                <h5 class="text-muted heading">Hier können Sie die Kunden durchsuchen.</h5>
                                <h5 class="text-muted heading">Sie können auch direkt einen Auftrag erstellen.</h5>
                                <br><br>
                                <div class="table-responsive">
                                    <table id="kunden_table_2" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Auftrag</th>
                                                <th scope="col">KundenID</th>
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
                                    <td>
                                        <img id="client_nr_' . $row['id'] . '" style="cursor: pointer;" src="' . URL . 'images/customer_request.gif">
                                    </td>
                                    <td>' . $row['id'] . '</td>
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
                                    
                                    <script>
                                        jQuery("#client_nr_' . $row['id'] . '").on("click", function() {
                                            jQuery("form#auftrag_erstellen2").show();
                                            jQuery("input[name=\"ae_kundenid\"]").val(' . $row['id'] . ');
                                        });
                                    </script>
                                    </tr>
                                    ';
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <br>
                                    <div class="auftrag_erstellen_div">
                                        <form class="auftrag_erstellen" id="auftrag_erstellen2" method="POST">
                                            <div>
                                                <div class="form-group">
                                                    <input value="" required type="hidden" class="form-control" id="ae_kundenid" name="ae_kundenid">
                                                </div>
                                                <div class="form-group">
                                                    <label for="ae_firmenname">Firmenname</label>
                                                    <input required type="text" class="form-control" id="ae_firmenname" name="ae_firmenname" placeholder="Firmenname ...">
                                                </div>
                                                <br>
                                                <div class="form-group input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="ae_anrede">Anrede</label>
                                                    </div>
                                                    <select class="custom-select" id="ae_anrede" name="ae_anrede">
                                                        <option value="Herr">Herr</option>
                                                        <option value="Frau">Frau</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ae_ansprechpartner">Ansprechpartner</label>
                                                    <input required type="text" class="form-control" id="ae_ansprechpartner" name="ae_ansprechpartner" placeholder="Ansprechpartner ...">
                                                </div>

                                                <div class="form-group">
                                                    <label for="ae_email">Email</label>
                                                    <input required type="email" class="form-control" id="ae_email" name="ae_email" placeholder="Email Adresse ...">
                                                </div>

                                                <div class="form-group">
                                                    <label for="ae_telefon">Telefon</label>
                                                    <input required type="tel" class="form-control" id="ae_telefon" name="ae_telefon" placeholder="Telefon ...">
                                                </div>
                                            </div>
                                            <div>
                                                <div class="form-group">
                                                    <label for="ae_strasse">Straße</label>
                                                    <input required type="text" class="form-control" id="ae_strasse" name="ae_strasse" placeholder="Straße ...">
                                                </div>
                                                <div class="form-group">
                                                    <label for="ae_hausnummer">Hausnummer</label>
                                                    <input required type="text" class="form-control" id="ae_hausnummer" name="ae_hausnummer" placeholder="Hausnummer ...">
                                                </div>
                                                <div class="form-group">
                                                    <label for="ae_plz">PLZ</label>
                                                    <input required type="number" class="form-control" id="ae_plz" name="ae_plz" placeholder="PLZ ...">
                                                </div>
                                                <div class="form-group">
                                                    <label for="ae_ort">Ort</label>
                                                    <input required type="text" class="form-control" id="ae_ort" name="ae_ort" placeholder="Ort ...">
                                                </div>
                                                <div class="form-group">
                                                    <label for="ae_land">Land</label>
                                                    <input required type="text" class="form-control" id="ae_land" name="ae_land" placeholder="Land ...">
                                                </div>
                                            </div>
                                            <div>
                                                <div class="form-group">
                                                    <label for="ae_ztelefon">Zentrale Telefonnummer</label>
                                                    <input required type="tel" class="form-control" id="ae_ztelefon" name="ae_ztelefon" placeholder="Zentrale Telefonnummer ...">
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" id="ae_freitext" name="ae_freitext" rows="10" placeholder="Freitext ..."></textarea>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="chk_ae_abholadresse" id="chk_ae_abholadresse">
                                                    <label class="form-check-label" for="chk_ae_abholadresse">Die Adresse der Abholung unterscheidet sich von der des Auttraggebers</label>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ae_abholadresse">Abholadresse</label>
                                                    <input type="text" class="form-control" id="ae_abholadresse" name="ae_abholadresse" placeholder="Abholadresse ...">
                                                </div>
                                                <br>
                                                <button type="submit" class="btn btn-primary">Auftrag erstellen</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="auftraege_durchsuchen">
                                <table id="auftraege_table" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Status</th>
                                            <th scope="col">KundenID</th>
                                            <th scope="col">Firmenname</th>
                                            <th scope="col">Anrede</th>
                                            <th scope="col">Ansprechpartner</th>
                                            <th scope="col">E-Mail</th>
                                            <th scope="col">Telefon</th>
                                            <th scope="col">Strasse</th>
                                            <th scope="col">Hausnummer</th>
                                            <th scope="col">PLZ</th>
                                            <th scope="col">Ort</th>
                                            <th scope="col">Land</th>
                                            <th scope="col">Telfon zentrale</th>
                                            <th scope="col">Freitext</th>
                                            <th scope="col">Abholadresse</th>
                                            <th scope="col">Trackingnummer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Get the user package requests.
                                        $sql = "SELECT * FROM auftraege";
                                        if ($stmt = $mysqli->prepare($sql)) {
                                            if ($stmt->execute()) {
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {
                                                    // Initialize the dialog.
                                                    require_once dirname(__FILE__) . '/templates/welcome.tmp.php';
                                                    echo auftraege_table($row);
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="systemeinstellung">
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#sysestlg_rechnung" data-toggle="tab">Rechnungslayout</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#sysestlg_steuersatz" data-toggle="tab">Steuersatz</a>
                            </li>
                        </ul>
                        <br>
                        <div class="tab-content">
                            <div class="tab-pane active" id="sysestlg_rechnung">
                                <form id="rechnungslayout" action="create_rechnung.php" method="POST" enctype="multipart/form-data">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="rl_logo" id="rl_logo" accept="image/*">
                                        <label class="custom-file-label" for="rl_logo">Logo wählen</label>
                                    </div>
                                    <br>
                                    <br>
                                    <div>
                                        <label for="edit_firmenname">Firmenname: </label>
                                        <a href="#" id="edit_firmenname" data-type="text" data-pk="1" data-title="Firmenname">Firmenname</a>
                                    </div>
                                    <br>
                                    <button disabled type="submit" class="btn btn-primary">Angaben speichern</button>
                                </form>
                            </div>
                            <div class="tab-pane" id="sysestlg_steuersatz">
                                <h5 class="text-muted heading">Hier kommt der Steuersatz.</b></h5>
                            </div>
                        </div>
                    </div>
                </div>
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

    <div id="dialog_auftrag" title="Erstellung vom Auftrag">
        <p>Machen Sie die Anfrage zu einem Auftrag.</p>
        <div class="auftrag_erstellen_div">
            <form class="auftrag_erstellen" id="dg_auftrag_erstellen" method="POST">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <input value="" required type="hidden" class="form-control" id="ae_dg_kundenid" name="ae_dg_kundenid">
                            </div>
                            <div class="form-group">
                                <label for="ae_dg_firmenname">Firmenname</label>
                                <input required type="text" class="form-control" id="ae_dg_firmenname" name="ae_dg_firmenname" placeholder="Firmenname ...">
                            </div>
                            <br>
                            <div class="form-group input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="ae_dg_anrede">Anrede</label>
                                </div>
                                <select class="custom-select" id="ae_dg_anrede" name="ae_dg_anrede">
                                    <option value="Herr">Herr</option>
                                    <option value="Frau">Frau</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ae_dg_ansprechpartner">Ansprechpartner</label>
                                <input required type="text" class="form-control" id="ae_dg_ansprechpartner" name="ae_dg_ansprechpartner" placeholder="Ansprechpartner ...">
                            </div>

                            <div class="form-group">
                                <label for="ae_dg_email">Email</label>
                                <input required type="email" class="form-control" id="ae_dg_email" name="ae_dg_email" placeholder="Email Adresse ...">
                            </div>

                            <div class="form-group">
                                <label for="ae_dg_telefon">Telefon</label>
                                <input required type="tel" class="form-control" id="ae_dg_telefon" name="ae_dg_telefon" placeholder="Telefon ...">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="ae_dg_strasse">Straße</label>
                                <input required type="text" class="form-control" id="ae_dg_strasse" name="ae_dg_strasse" placeholder="Straße ...">
                            </div>
                            <div class="form-group">
                                <label for="ae_dg_hausnummer">Hausnummer</label>
                                <input required type="text" class="form-control" id="ae_dg_hausnummer" name="ae_dg_hausnummer" placeholder="Hausnummer ...">
                            </div>
                            <div class="form-group">
                                <label for="ae_dg_plz">PLZ</label>
                                <input required type="number" class="form-control" id="ae_dg_plz" name="ae_dg_plz" placeholder="PLZ ...">
                            </div>
                            <div class="form-group">
                                <label for="ae_dg_ort">Ort</label>
                                <input required type="text" class="form-control" id="ae_dg_ort" name="ae_dg_ort" placeholder="Ort ...">
                            </div>
                            <div class="form-group">
                                <label for="ae_dg_land">Land</label>
                                <input required type="text" class="form-control" id="ae_dg_land" name="ae_dg_land" placeholder="Land ...">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="ae_dg_ztelefon">Zentrale Telefonnummer</label>
                                <input required type="tel" class="form-control" id="ae_dg_ztelefon" name="ae_dg_ztelefon" placeholder="Zentrale Telefonnummer ...">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" id="ae_dg_freitext" name="ae_dg_freitext" rows="10" placeholder="Freitext ..."></textarea>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="chk_ae_dg_abholadresse" id="chk_ae_dg_abholadresse">
                                <label class="form-check-label" for="chk_ae_dg_abholadresse">Die Adresse der Abholung unterscheidet sich von der des Auttraggebers</label>
                            </div>
                            <div class="form-group">
                                <label for="ae_dg_abholadresse">Abholadresse</label>
                                <input type="text" class="form-control" id="ae_dg_abholadresse" name="ae_dg_abholadresse" placeholder="Abholadresse ...">
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
<?php
$mysqli->close();
?>