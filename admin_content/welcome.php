<?php
require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../definitions.php';
require_once dirname(__FILE__) . '/templates/versandrechner.tmp.php';

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
    <link rel="stylesheet" href="css/versandrechner.css">
    <!-- Eigenes CSS end -->

    <!-- Eigenes JS start -->
    <script>
        var mainUrl = '<?= URL ?>';
        var username = '<?= $_SESSION['username'] ?>';
    </script>
    <script src="js/script.js"></script>
    <script src="../dist/app.js" defer></script>

    <!-- Eigenes JS end -->
</head>

<body>
    <div id="app">

        <div class="container-fluid">
            <div class="row">
                <!-- sidenav component. -->
                <sidenav></sidenav>
                <div id="div_main-content" class="col-sm-11">
                    <!-- mainnav component. -->
                    <mainnav></mainnav>

                    <div class="tab-content">
                        <div class="tab-pane" id="kunden">
                            <table id="kunden_table" class="compact">
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
                                    $sql = "SELECT * FROM kunden";

                                    if ($stmt = $mysqli->prepare($sql)) {
                                        if ($stmt->execute()) {
                                            $result = $stmt->get_result();
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
                        </div>
                        <div class="tab-pane active container-fluid" id="vorreiter">
                            <div class="row">
                                <div class="col-sm-6 container-fluid">
                                    <!-- inquiry_theader component. -->
                                    <inquiry_theader></inquiry_theader>
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
                                                        while ($row = $result->fetch_assoc()) {
                                                            if ($row["service_leistung"] == '{}') {
                                                                $row["service_leistung"] = '';
                                                            }
                                                            // Initialize the dialog.
                                                            require_once dirname(__FILE__) . '/templates/welcome.tmp.php';
                                                            echo anfragen_table($row);
                                                        }
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-6 container-fluid">
                                    <!-- order_theader component. -->
                                    <order_theader></order_theader>
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
                                                        while ($row = $result->fetch_assoc()) {
                                                            if ($row["service_leistung"] == '{}') {
                                                                $row["service_leistung"] = '';
                                                            }
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

                        </div>
                        <div class="tab-pane table-responsive" id="an_auf_data" data-tabs="tabs">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#anfragen" data-toggle="tab">
                                        <h4>Anfragen</h4>
                                        <span>&nbsp;&nbsp;</span>
                                        <img class="img_anfrage-erstellen" src="../images/an_auf_table/anfrage_erstellen.png" alt="">
                                    </a>
                                </li>
                                <span class="span_white-space">&nbsp;</span>
                                <li class="nav-item">
                                    <a class="nav-link" href="#auftraege" data-toggle="tab">
                                        <h4>Aufträge</h4>
                                        <span>&nbsp;&nbsp;</span>
                                        <img class="img_auftrag-erstellen" src="../images/an_auf_table/auftrag_erstellen.png" alt="">
                                    </a>
                                </li>
                                <li class="nav-item">
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="anfragen" class="tab-pane active">
                                    <table id="anfragen_table_full" class="compact">
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
                                                    while ($row = $result->fetch_assoc()) {
                                                        if ($row["service_leistung"] == '{}') {
                                                            $row["service_leistung"] = '';
                                                        }
                                                        // Initialize the dialog.
                                                        require_once dirname(__FILE__) . '/templates/welcome.tmp.php';
                                                        echo anfragen_table($row);
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="auftraege" class="tab-pane">
                                    <table id="auftraege_table_full" class="compact">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nummer</th>
                                                <th scope="col">Kunde</th>
                                                <th scope="col">Ansprechpartner</th>
                                                <th scope="col">Telefon</th>
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
                                                    while ($row = $result->fetch_assoc()) {
                                                        if ($row["service_leistung"] == '{}') {
                                                            $row["service_leistung"] = '';
                                                        }
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

                        <div class="tab-pane" id="settings">
                            <!-- settings component. -->
                            <settings></settings>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- toast component. -->
        <toast></toast>

       
        <!-- Auftrag Dialog 2 - Create 'auftrag' to an existing client. -->
        <div id="dialog_auftrag-erstellen-2" title="Auftrag erstellen">
            <div id="div_auftrag-erstellen-content" class="container-fluid">
                <div class="row">
                    <div class="col-sm-6 container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <h5>Auftraggeber</h5>
                                <span><b>Firmenname</b></span><br>
                                <span id="span_auftrag-firmenname"></span><br>
                                <span><b>Ansprechpartner</b></span><br>
                                <span id="span_auftrag-ansprechpartner"></span>
                            </div>
                            <div class="col-sm-6">
                                <br>
                                <span><b>Kundennummer</b></span><br>
                                <span id="span_auftrag-kundennummer"></span><br>
                                <span><b>Telefon</b></span><br>
                                <span id="span_auftrag-telefon"></span><br>
                                <span><b>E-Mail-Adresse</b></span><br>
                                <span id="span_auftrag-email"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <img id="img_auftrag-anlegen" src="../images/auftrag/auftrag_anlegen.png" alt="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <h5><b>Abholadresse</b></h5>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="auf_firmenname">Firmenname</label>
                                    <input required type="text" class="form-control" id="auf_firmenname" name="auf_firmenname" placeholder="Firmenname ...">
                                </div>
                                <div class="col-sm-6"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 container-fluid">
                                    <div class="row">
                                        <h6>Ansprechpartner</h6>
                                        <div class="col-sm-6 form-group">
                                            <label for="auf_anrede">Anrede</label>
                                            <input required type="text" class="form-control" id="auf_anrede" name="auf_anrede">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label for="auf_titel">Titel</label>
                                            <input required type="text" class="form-control" id="auf_titel" name="auf_titel">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="auf_vorname">Vorname</label>
                                    <input required type="text" class="form-control" id="auf_vorname" name="auf_vorname" placeholder="Vorname ...">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="auf_nachname">Nachname</label>
                                    <input required type="text" class="form-control" id="auf_nachname" name="auf_nachname" placeholder="Nachname ...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="auf_telefon">Telefon</label>
                                    <input required type="text" class="form-control" id="auf_telefon" name="auf_telefon" placeholder="Telefon ...">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="auf_email">E-Mail-Adresse</label>
                                    <input required type="text" class="form-control" id="auf_email" name="auf_email" placeholder="Email ...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="auf_strasse">Straße</label>
                                    <input required type="text" class="form-control" id="auf_strasse" name="auf_strasse" placeholder="Straße ...">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="auf_hausnummer">Hausnummer</label>
                                    <input required type="text" class="form-control" id="auf_hausnummer" name="auf_hausnummer" placeholder="Hausnummer ...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="auf_plz">PLZ</label>
                                    <input required type="text" class="form-control" id="auf_plz" name="auf_plz" placeholder="PLZ ...">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="auf_ort">Ort</label>
                                    <input required type="text" class="form-control" id="auf_ort" name="auf_ort" placeholder="Ort ...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="auf_land">Land</label>
                                    <input required type="text" class="form-control" id="auf_land" name="auf_land" placeholder="Land ...">
                                </div>
                                <div class="col-sm-6"></div>
                            </div>
                            <div class="row">
                                <h5><b>Lieferadresse</b></h5>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="lif_firmenname">Firmenname</label>
                                    <input required type="text" class="form-control" id="lif_firmenname" name="lif_firmenname" placeholder="Firmenname ...">
                                </div>
                                <div class="col-sm-6"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 container-fluid">
                                    <div class="row">
                                        <h6>Ansprechpartner</h6>
                                        <div class="col-sm-6 form-group">
                                            <label for="lif_anrede">Anrede</label>
                                            <input required type="text" class="form-control" id="lif_anrede" name="lif_anrede">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label for="lif_titel">Titel</label>
                                            <input required type="text" class="form-control" id="lif_titel" name="lif_titel">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="lif_vorname">Vorname</label>
                                    <input required type="text" class="form-control" id="lif_vorname" name="lif_vorname" placeholder="Vorname ...">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="lif_nachname">Nachname</label>
                                    <input required type="text" class="form-control" id="lif_nachname" name="lif_nachname" placeholder="Nachname ...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="lif_telefon">Telefon</label>
                                    <input required type="text" class="form-control" id="lif_telefon" name="lif_telefon" placeholder="Telefon ...">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="lif_email">E-Mail-Adresse</label>
                                    <input required type="text" class="form-control" id="lif_email" name="lif_email" placeholder="Email ...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="lif_strasse">Straße</label>
                                    <input required type="text" class="form-control" id="lif_strasse" name="lif_strasse" placeholder="Straße ...">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="lif_hausnummer">Hausnummer</label>
                                    <input required type="text" class="form-control" id="lif_hausnummer" name="lif_hausnummer" placeholder="Hausnummer ...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="lif_plz">PLZ</label>
                                    <input required type="text" class="form-control" id="lif_plz" name="lif_plz" placeholder="PLZ ...">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="lif_ort">Ort</label>
                                    <input required type="text" class="form-control" id="lif_ort" name="lif_ort" placeholder="Ort ...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="lif_land">Land</label>
                                    <input required type="text" class="form-control" id="lif_land" name="lif_land" placeholder="Land ...">
                                </div>
                                <div class="col-sm-6"></div>
                            </div>
                        </div>
                    </div>
                    <div id="div_auftrag-versandrechner" class="col-sm-6">
                        <?php
                        get_versandrechner('auftrag');
                        ?>;
                    </div>
                </div>
            </div>
        </div>
        <!-- Kunden Dialog - Create a client.  -->
        <div id="dialog_kunden-erstellen" title="Kunden erstellen">
            <h5 class="text-muted heading">Legen Sie den Kunden zum Auftrag an.</b></h5>
            <form id="kunden_anlegen" method="POST">
                <div>
                    <div class="kunden_input form-group">
                        <label for="bv_firmenname">Firmenname</label>
                        <input required type="text" class="form-control" id="bv_firmenname" name="bv_firmenname" placeholder="Firmenname ...">
                    </div>
                    <div class="kunden_input form-group input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="bv_anrede">Anrede</label>
                        </div>
                        <select class="custom-select" id="bv_anrede" name="bv_anrede">
                            <option value="Herr">Herr</option>
                            <option value="Frau">Frau</option>
                        </select>
                    </div>
                    <div class="kunden_input form-group">
                        <label for="bv_freitext">Freitext</label>
                        <textarea class="form-control" id="bv_freitext" name="bv_freitext" rows="10" placeholder="Freitext ..."></textarea>
                    </div>
                    <div class="kunden_input form-group">
                        <label for="bv_email">Email</label>
                        <input required type="email" class="form-control" id="bv_email" name="bv_email" placeholder="Email Adresse ...">
                    </div>
                    <div class="kunden_input form-group">
                        <label for="bv_telefon">Telefon</label>
                        <input required type="tel" class="form-control" id="bv_telefon" name="bv_telefon" placeholder="Telefon ...">
                    </div>
                    <div class="kunden_input form-group">
                        <label for="bv_ort">Ort</label>
                        <input required type="text" class="form-control" id="bv_ort" name="bv_ort" placeholder="Ort ...">
                    </div>
                    <div class="kunden_input form-group">
                        <label for="bv_hausnummer">Hausnummer</label>
                        <input required type="text" class="form-control" id="bv_hausnummer" name="bv_hausnummer" placeholder="Hausnummer ...">
                    </div>
                    <div class="kunden_input form-group">
                        <label for="bv_plz">PLZ</label>
                        <input required type="number" class="form-control" id="bv_plz" name="bv_plz" placeholder="PLZ ...">
                    </div>
                    <div class="kunden_input form-group">
                        <label for="bv_land">Land</label>
                        <input required type="text" class="form-control" id="bv_land" name="bv_land" placeholder="Land ...">
                    </div>
                    <div class="kunden_input form-group">
                        <label for="bv_ztelefon">Zentrale Telefonnummer</label>
                        <input required type="tel" class="form-control" id="bv_ztelefon" name="bv_ztelefon" placeholder="Zentrale Telefonnummer ...">
                    </div>
                    <div class="kunden_input form-group">
                        <label for="bv_ansprechpartner">Ansprechpartner</label>
                        <input required type="text" class="form-control" id="bv_ansprechpartner" name="bv_ansprechpartner" placeholder="Ansprechpartner ...">
                    </div>
                    <div class="kunden_input form-group">
                        <label for="bv_strasse">Straße</label>
                        <input required type="text" class="form-control" id="bv_strasse" name="bv_strasse" placeholder="Straße ...">
                    </div>
                    <div class="kunden_input form-check">
                        <input type="checkbox" class="form-check-input" name="bv_kunden_informieren" id="bv_kunden_informieren">
                        <label class="form-check-label" for="bv_kunden_informieren">Kunden über Accounterstellung via E-Mail informieren</label>
                    </div>
                    <div class="kunden_input">
                        <button type="submit" class="btn btn-primary">Anlegen</button>
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