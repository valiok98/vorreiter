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
    </script>
    <script src="js/script.js"></script>
    <!-- Eigenes JS end -->
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
                                <div class="row div_table-header">
                                    <h3>Anfragen</h3>
                                    <div>
                                        <img src="../images/an_auf_table/eye.png" alt="">
                                        <img class="img_anfrage-erstellen" src="../images/an_auf_table/anfrage_erstellen.png" alt="">
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
                                <div class="row div_table-header">
                                    <h3>Aufträge</h3>
                                    <div>
                                        <img src="../images/an_auf_table/eye.png" alt="">
                                        <img class="img_auftrag-erstellen" src="../images/an_auf_table/auftrag_erstellen.png" alt="">
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
    <!-- Anfrage Dialog 1 -->
    <div id="dialog_anfrage-erstellen-1" title="Anfrage erstellen">
        <form id="form_suche-anfrage-kunden" class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Suche Kunden..." aria-label="Search">
        </form>
        <div id="div_suche-anfrage-ergebnisse"></div>
    </div>
    <!-- Anfrage Dialog 2 -->
    <div id="dialog_anfrage-erstellen-2" title="Anfrage erstellen">
        <div id="div_anfrage-erstellen-content" class="container-fluid">
            <div class="row">
                <div class="col-sm-6 container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5>Auftraggeber</h5>
                            <span><b>Firmenname</b></span><br>
                            <span id="span_anfrage-firmenname"></span><br>
                            <span><b>Ansprechpartner</b></span><br>
                            <span id="span_anfrage-ansprechpartner"></span>
                        </div>
                        <div class="col-sm-6">
                            <br>
                            <span><b>Kundennummer</b></span><br>
                            <span id="span_anfrage-kundennummer"></span><br>
                            <span><b>Telefon</b></span><br>
                            <span id="span_anfrage-telefon"></span><br>
                            <span><b>E-Mail-Adresse</b></span><br>
                            <span id="span_anfrage-email"></span>
                        </div>
                    </div>
                </div>
                <div id="div_anfrage-versandrechner" class="col-sm-6 div_versandrechner-wrapper">
                    <?php
                    get_versandrechner('anfrage');
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Auftrag Dialog 1 - Search for clients. -->
    <div id="dialog_auftrag-erstellen-1" title="Auftrag erstellen">
        <form id="form_suche-auftrag-kunden" class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Suche Kunden..." aria-label="Search">
        </form>
        <div id="div_suche-auftrag-ergebnisse"></div>
    </div>
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
</body>

</html>
<?php
$mysqli->close();
?>