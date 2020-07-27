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
    <link rel="stylesheet" href="css/versandrechner.css">
    <!-- Eigenes CSS end -->

    <!-- Eigenes JS start -->
    <script>
        var main_url = '<?= URL ?>';
    </script>
    <script src="js/script.js"></script>
    <script src="js/versandrechner.js"></script>
    <!-- Eigenes JS end -->

    <script>
        jQuery(document).ready(function($) {



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

            // Ajax for searching the "kunden".
            $('#form_suche-auftrag-kunden input').on('keyup', function(e) {
                let input = $(this).val().trim();
                // Empty the table if the input is empty.
                if (!input) {
                    $('#div_suche-auftrag-ergebnisse').empty();
                } else {
                    $.ajax({
                        url: '<?= URL . 'admin_content/find_client.php' ?>',
                        type: "post",
                        dataType: "json",
                        data: {
                            "client_data": input
                        },
                        success: function(data) {
                            if (data['success']) {
                                let clientData = data['client_data'];
                                $('#div_suche-auftrag-ergebnisse').empty();
                                // Only display the results if theere is client data.

                                if (clientData.length) {
                                    $('#div_suche-auftrag-ergebnisse').append('<div class="div_kunden-ergebnis"><input readonly type="hidden" value="-1"><span>Neukunden erstellen</span><img style="float: right" src="../images/auftrag/auftrag_arrow.png" alt=""></div>');

                                    clientData.forEach(function(client) {
                                        $('#div_suche-auftrag-ergebnisse').append('<div class="div_kunden-ergebnis"><input readonly type="hidden" value="' + client["id"] + '"><span>' +
                                            client["firmenname"] + '&nbsp;[' +
                                            client["plz"] + '&nbsp;-&nbsp;' +
                                            client["ort"] + ']</span><img style="float: right" src="../images/auftrag/auftrag_arrow.png" alt=""></div>');
                                    });

                                    $('.div_kunden-ergebnis').on('click', function() {
                                        let clientID = parseInt($(this).find('input').val().trim());
                                        // Create a new client.
                                        if (clientID === -1) {
                                            create_client();
                                        } else {
                                            // Load data for an existing client.
                                            create_auftrag(clientID = clientID);
                                        }
                                    });
                                }
                            }
                        },
                        error: function(data) {
                            $('.toast .toast-body').html('Ein Fehler is aufgetretten.');
                            $('.toast').toast('show');
                        }
                    });
                }
            });

            $('#form_suche-anfrage-kunden input').on('keyup', function(e) {
                let input = $(this).val().trim();
                // Empty the table if the input is empty.
                if (!input) {
                    $('#div_suche-anfrage-ergebnisse').empty();
                } else {
                    $.ajax({
                        url: '<?= URL . 'admin_content/find_client.php' ?>',
                        type: "post",
                        dataType: "json",
                        data: {
                            "client_data": input
                        },
                        success: function(data) {
                            if (data['success']) {
                                let clientData = data['client_data'];
                                $('#div_suche-anfrage-ergebnisse').empty();
                                // Only display the results if theere is client data.

                                if (clientData.length) {
                                    $('#div_suche-anfrage-ergebnisse').append('<div class="div_kunden-ergebnis"><input readonly type="hidden" value="-1"><span>Neukunden erstellen</span><img style="float: right" src="../images/auftrag/auftrag_arrow.png" alt=""></div>');

                                    clientData.forEach(function(client) {
                                        $('#div_suche-auftrag-ergebnisse').append('<div class="div_kunden-ergebnis"><input readonly type="hidden" value="' + client["id"] + '"><span>' +
                                            client["firmenname"] + '&nbsp;[' +
                                            client["plz"] + '&nbsp;-&nbsp;' +
                                            client["ort"] + ']</span><img style="float: right" src="../images/anfrage/anfrage_arrow.png" alt=""></div>');
                                    });

                                    $('.div_kunden-ergebnis').on('click', function() {
                                        let clientID = parseInt($(this).find('input').val().trim());
                                        // Create a new client.
                                        if (clientID === -1) {
                                            create_client();
                                        } else {
                                            // Load data for an existing client.
                                            create_anfrage(clientID = clientID);
                                        }
                                    });
                                }
                            }
                        },
                        error: function(data) {
                            $('.toast .toast-body').html('Ein Fehler is aufgetretten.');
                            $('.toast').toast('show');
                        }
                    });
                }
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
    </div>
    <!-- Auftrag Dialog 1 - Search for clients. -->
    <div id="dialog_auftrag-erstellen-1" title="Auftrag erstellen">
        <form id="form_suche-auftrag-kunden" class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Suche Kunden..." aria-label="Search">
        </form>
        <div id="div_suche-auftrag-ergebnisse">

        </div>
    </div>
    <!-- Auftrag Dialog 2 - Create a client.  -->
    <div id="dialog_auftrag-erstellen-2" title="Kunden erstellen">
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
    <!-- Auftrag Dialog 3 - Create 'auftrag' to an existing client. -->
    <div id="dialog_auftrag-erstellen-3" title="Auftrag erstellen">
        <div id="div_auftrag-erstellen-content" class="container-fluid">
            <div class="row">
                <div class="col-sm-6 container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5>Auftraggeber</h5>
                            <span><b>Firmenname</b></span><br>
                            <span id="span_firmenname"></span><br>
                            <span><b>Ansprechpartner</b></span><br>
                            <span id="span_ansprechpartner"></span>
                        </div>
                        <div class="col-sm-6">
                            <br>
                            <span><b>Kundennummer</b></span><br>
                            <span id="span_kundennummer"></span><br>
                            <span><b>Telefon</b></span><br>
                            <span id="span_telefon"></span><br>
                            <span><b>E-Mail-Adresse</b></span><br>
                            <span id="span_email"></span>
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
                <div class="col-sm-6">
                    <h5>Sendungsdetails</h5>
                    <h4>Wann dürfen wir für Sie zustellen?</h4>
                    <div class="container-fluid">
                        <form id="versandrechner" method="post" class="m-form">
                            <div class="row">
                                <div class="col-sm-5 smaller">
                                    Zustellfenster:
                                </div>
                                <div class="col-sm-7 form-group smaller">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="zeitfenster" id="zeit1" value="2" required />
                                        <label class="form-check-label" for="zeit1">
                                            07:30 – 08:00 Uhr
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="zeitfenster" id="zeit2" value="3" />
                                        <label class="form-check-label" for="zeit2">
                                            08:00 – 09:00 Uhr
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="zeitfenster" id="zeit3" value="5" />
                                        <label class="form-check-label" for="zeit3">
                                            08:00 – 10:00 Uhr
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="zeitfenster" id="zeit4" value="6" />
                                        <label class="form-check-label" for="zeit4">
                                            08:00 – 12:00 Uhr
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="zeitfenster" id="zeit5" value="7" />
                                        <label class="form-check-label" for="zeit5">
                                            09:00 – 17:00 Uhr
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="zeitfenster" id="zeitfensterfix" value="-1" />
                                        <label class="form-check-label" for="zeitfensterfix">
                                            Fixtermin
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-5 smaller">
                                    Zustellung am:
                                </div>
                                <div class="col-sm-7 form-group smaller">

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="zustelltag" id="zustelltagmofr" value="1" required />
                                        <label class="form-check-label" for="zustelltagmofr">
                                            Mo. – Fr. (am folgenen Werktag)
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="zustelltag" id="zustelltagsa" value="2" />
                                        <label class="form-check-label" for="zustelltagsa">
                                            Samstag
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="zustelltag" id="zustelltagso" value="3" />
                                        <label class="form-check-label" for="zustelltagso">
                                            Sonn-/Feiertag
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <h4>
                                    Maße und Gewicht Ihrer Sendung:
                                </h4>
                                <div class="form-group form-inline">
                                    <input type="text" name="groesse-x" id="groesse-x" minlength="1" maxlength="6" size="1" pattern="[0-9]+" class="form-control grge" placeholder="Länge" required />
                                    <span>&nbsp;x&nbsp;</span>
                                    <input type="text" name="groesse-y" id="groesse-y" minlength="1" maxlength="6" size="1" pattern="[0-9]+" class="form-control grge" placeholder="Breite" required />
                                    <span>&nbsp;x&nbsp;</span>
                                    <input type="text" name="groesse-z" id="groesse-z" minlength="1" maxlength="6" size="1" pattern="[0-9]+" class="form-control grge" placeholder="Höhe" required />
                                    <span>&nbsp;cm&nbsp;</span>
                                    <br />
                                    <span class="spaced smaller">
                                        <label for="volumengewicht">Resultierendes Volumengewicht:</label>
                                        <input type="text" name="volumengewicht" id="volumengewicht" size="1" pattern="[0-9]+" class="form-control" value="0" disabled />&nbsp;kg
                                    </span>
                                    <br />
                                    <!-- <label for="volumengewicht">Resultierendes Volumengewicht:</label> -->
                                    <span id="span_gewicht">
                                        <input type="text" name="gewicht" id="gewicht" placeholder="Gewicht" minlength="1" maxlength="6" size="1" pattern="[0-9]+" class="form-control grge" required />
                                        <span>kg</span>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <button id="neworder" type="submit">
                                        <img id="neworder_img" alt="Weitere Sendung hinzufügen">
                                        <h4 id="neworder_headline">
                                            <b>Eine weitere Sendung hinzufügen</b>
                                        </h4>
                                    </button>
                                </div>

                                <div class="form-group">
                                    <h4 id="serviceheadline">Zusätzliche Serviceleistungen<br />
                                        <small>[Nachname, Empfangsbestätigung, ...] <br /><span id="servicelink">Bitte klicken</span></small></h4>
                                    <div id="serviceauswahl">
                                        <div class="btn-close" id="serviceclose">
                                            <div class="btn-close-x"></div>
                                            <div class="btn-close-x"></div>

                                        </div>
                                        <div class="tbl">
                                            <div class="tblrow">
                                                <div class="tblcell">Fixe Zustellung</div>
                                                <div class="tblcell">zzgl.</div>
                                                <div class="tblcell">50,00&nbsp;€</div>
                                                <div class="tblcell">
                                                    <input type="checkbox" id="service1" name="service" value="Fixe Zustellung" />
                                                    <label for="service1"></label>
                                                </div>
                                            </div>

                                            <div class="tblrow">
                                                <div class="tblcell">Bereichszustellung</div>
                                                <div class="tblcell">zzgl.</div>
                                                <div class="tblcell">5,00&nbsp;€</div>
                                                <div class="tblcell">
                                                    <input type="checkbox" id="service2" name="service" value="Bereichszustellung" />
                                                    <label for="service2"></label></div>
                                            </div>

                                            <div class="tblrow">
                                                <div class="tblcell">Empfangsbestätigung</div>
                                                <div class="tblcell">zzgl.</div>
                                                <div class="tblcell">4,00&nbsp;€</div>
                                                <div class="tblcell"><input type="checkbox" id="service3" name="service" value="Empfangsbestaetigung" />
                                                    <label for="service3"></label></div>
                                            </div>

                                            <div class="tblrow">
                                                <div class="tblcell">Empfangsbestätigung (telefonisch)</div>
                                                <div class="tblcell">zzgl.</div>
                                                <div class="tblcell">2,00&nbsp;€</div>
                                                <div class="tblcell">
                                                    <input type="checkbox" id="service4" name="service" value="Empfangsbestaetigung telefonisch">
                                                    <label for="service4"></label></div>
                                            </div>

                                            <div class="tblrow">
                                                <div class="tblcell">Höherhaftung bis 2.500&nbsp;€ pro Sendung</div>
                                                <div class="tblcell">zzgl.</div>
                                                <div class="tblcell">3,50&nbsp;€</div>
                                                <div class="tblcell">
                                                    <input type="checkbox" id="service5" name="service" value="Hoeherhaftung">
                                                    <label for="service5"></label>
                                                </div>
                                            </div>

                                            <div class="tblrow">
                                                <div class="tblcell">Indet-Zustellung mit Vertragsservice</div>
                                                <div class="tblcell">zzgl.</div>
                                                <div class="tblcell">7,00&nbsp;€</div>
                                                <div class="tblcell">
                                                    <input type="checkbox" id="service6" name="service" value="Indet-Zustellung Vertragsservice" />
                                                    <label for="service6"></label>
                                                </div>
                                            </div>

                                            <div class="tblrow">
                                                <div class="tblcell">Insel-Zustellung</div>
                                                <div class="tblcell">zzgl.</div>
                                                <div class="tblcell">30,00&nbsp;€</div>
                                                <div class="tblcell">
                                                    <input type="checkbox" id="service7" name="service" value="Insel-Zustellung" />
                                                    <label for="service7"></label>
                                                </div>
                                            </div>

                                            <div class="tblrow">
                                                <div class="tblcell">Lagerung nicht zugestellter Sendung je Tag</div>
                                                <div class="tblcell">zzgl.</div>
                                                <div class="tblcell">1,00&nbsp;€</div>
                                                <div class="tblcell">
                                                    <input type="checkbox" id="service8" name="service" value="Lagerung" />
                                                    <label for="service8"></label>
                                                </div>
                                            </div>

                                            <div class="tblrow">
                                                <div class="tblcell">Messeservice</div>
                                                <div class="tblcell">zzgl.</div>
                                                <div class="tblcell">10,00&nbsp;€</div>
                                                <div class="tblcell">
                                                    <input type="checkbox" id="service9" name="service" value="Messeservice" />
                                                    <label for="service9"></label>
                                                </div>
                                            </div>

                                            <div class="tblrow">
                                                <div class="tblcell">Nachnahme</div>
                                                <div class="tblcell">zzgl.</div>
                                                <div class="tblcell">8,00&nbsp;€</div>
                                                <div class="tblcell">
                                                    <input type="checkbox" id="service11" name="service" value="Nachnahme" />
                                                    <label for="service11"></label>
                                                </div>
                                            </div>

                                            <div class="tblrow">
                                                <div class="tblcell">Persönliche Zustellung mit Dokumentation</div>
                                                <div class="tblcell">zzgl.</div>
                                                <div class="tblcell">5,00&nbsp;€</div>
                                                <div class="tblcell">
                                                    <input type="checkbox" id="service12" name="service" value="Persoenliche Zustellung" />
                                                    <label for="service12"></label>
                                                </div>
                                            </div>

                                            <div class="tblrow">
                                                <div class="tblcell">Samstagszustellung</div>
                                                <div class="tblcell">zzgl.</div>
                                                <div class="tblcell">2,00&nbsp;€</div>
                                                <div class="tblcell">
                                                    <input type="checkbox" id="service13" name="service" value="Samstagszustellung">
                                                    <label for="service13"></label>
                                                </div>
                                            </div>

                                            <div class="tblrow">
                                                <div class="tblcell">SmartPic</div>
                                                <div class="tblcell">zzgl.</div>
                                                <div class="tblcell">46,00&nbsp;€</div>
                                                <div class="tblcell">
                                                    <input type="checkbox" id="service14" name="service" value="SmartPic">
                                                    <label for="service14"></label>
                                                </div>
                                            </div>

                                            <div class="tblrow">
                                                <div class="tblcell">SmartPic+</div>
                                                <div class="tblcell">zzgl.</div>
                                                <div class="tblcell">50,00&nbsp;€</div>
                                                <div class="tblcell">
                                                    <input type="checkbox" id="service15" name="service" value="SmartPic+">
                                                    <label for="service15"></label>
                                                </div>
                                            </div>
                                            <div class="tblrow">
                                                <div class="tblcell">Sonn- und Feiertagszustellung</div>
                                                <div class="tblcell">zzgl.</div>
                                                <div class="tblcell">40,00&nbsp;€</div>
                                                <div class="tblcell"><input type="checkbox" id="service16" name="service" value="Sonntagszustellung" />
                                                    <label for="service16"></label>
                                                </div>
                                            </div>

                                            <div class="tblrow">
                                                <div class="tblcell">Verpackungsrückführung</div>
                                                <div class="tblcell">zzgl.</div>
                                                <div class="tblcell">2,00&nbsp;€</div>
                                                <div class="tblcell">
                                                    <input type="checkbox" id="service17" name="service" value="Verpackungsrueckführung" />
                                                    <label for="service17"></label>
                                                </div>
                                            </div>

                                            <div class="tblrow">
                                                <div class="tblcell">X-Change</div>
                                                <div class="tblcell">zzgl.</div>
                                                <div class="tblcell">2,00&nbsp;€</div>
                                                <div class="tblcell">
                                                    <input type="checkbox" id="service18" name="service" value="X-Change" />
                                                    <label for="service18"></label>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>



                                <div class="col-12 form-group" id="feedbackcol">
                                    <h4>Ihr Preis:</h4>
                                    <div id="preis">
                                        <span id="warnung">
                                            Bitte vervollständigen Sie Ihre Eingaben.<br />
                                            <strong>Alle Felder</strong> sind Pflichtfelder.
                                        </span>
                                        <span id="ergebnis">
                                            <span id="netto"> </span><br />
                                            <span id="brutto"> </span><br />
                                            <br />
                                            <small>
                                                <span class="tbl">
                                                    <span class="tblrow" id="mwst">
                                                        <span class="tblcell">zzgl. MwSt (19%):</span>
                                                        <span class="tblcell" id="steuer"></span>
                                                    </span>
                                                </span>
                                            </small>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-12 form-group" id="versandrechnerkontakt">
                                    <h4 class="lstblau">Sie möchten dieses Angebot via E-Mail erhalten?<br /> Tragen Sie einfach Ihre E-Mail-Adresse ein:</h4>
                                    <div class="form-group">
                                        <label for="email">Ihre E-Mail-Adresse <span class="error">– Bitte ausfüllen!</span></label>

                                        <br />
                                        <input type="email" id="email" name="email" class="form-control" size="12">
                                        <button type="button" name="kontaktwunsch" value="email" class="btn btn-primary versandrechnerbtn" id="btnversandrechner_mail">Abschicken</button>
                                    </div>

                                    <h4 class="">Sollen wir Sie kontaktieren? <br />
                                        <small>Hinterlassen Sie uns Ihre Rufnummer oder E-Mail-Adresse. Wir melden uns umgehend:</small></h4>
                                    <div class="form-group">
                                        <label for="kundennr">Ihre Kundennummer (falls vorhanden)</label><br />
                                        <input type="text" id="kundennr" name="kundennr" class="form-control" size="12">
                                        <br />
                                        <label for="name">Ihr Name<span class="error"> – Bitte ausfüllen!</span></label><br />
                                        <input type="text" id="name" name="name" class="form-control" size="12">

                                        <br />
                                        <label for="telefon">Ihre Rufnummer<span class="error"> – Bitte ausfüllen!</span></label><br />
                                        <input type="text" id="telefon" name="telefon" class="form-control" size="12">


                                        <button type="button" name="kontaktwunsch" value="phone" class="btn btn-primary versandrechnerbtn" id="btnversandrechner_phone">Abschicken</button>
                                    </div>



                                </div>

                                <div class="col-12 form-group" id="shipmentscol">
                                    <h4>Ihre Sendungen:</h4>
                                    <div id="shipmentslist">
                                    </div>
                                    <h4 id="gesamtpreis">Gesamtpreis:
                                        <span id="gesamtpreisvalue"></span>
                                    </h4>
                                    <h4 id="gesamtvolumengewicht">Gesamtvolumengewicht:
                                        <span id="gesamtvolumengewichtvalue"></span>
                                    </h4>
                                </div>


                                <div class="col-12 " id="ajaxerror">
                                    <h4>Ein Fehler ist aufgetreten.</h4>
                                    <span id="" class="text"></span>
                                </div>

                                <div class="col-12 " id="ajaxdone">
                                    <h4>Vielen Dank!</h4>
                                    <br />
                                    <span class="text"></span>
                                </div>

                            </div>
                            <div class="row form-group">
                                <button type="submit" name="sb" value="calc" id="btnversandrechner_calc" class="btn btn-primary">Berechnen</button>
                            </div>
                            <div class="row">
                                <input type="hidden" id="token" name="token" value="$$TOKEN$$" />
                                <input type="hidden" id="summe" name="summe" value="" />
                                <input type="text" name="username" id="username" value="" />
                            </div>
                        </form>
                        <div id="dialog_delete_shipment" title="Sind Sie sich sicher ?">
                            <p>Die gewünschte Sendung wird unwiderruflich gelöscht.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>
<?php
$mysqli->close();
?>