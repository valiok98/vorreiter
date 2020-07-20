<?php
require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../definitions.php';
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
    <style>
        .nav {
            width: 100vw;
            font-weight: 900;
        }

        .nav li:last-of-type {
            position: absolute;
            right: 0;
        }

        #benutzerverwaltung .heading {
            margin-left: 50px;
        }

        #create_benutzer {
            position: relative;
            top: 50px;
            left: 50px;
            display: flex;
            flex-flow: row nowrap;
            align-items: center;
        }

        #create_benutzer>div {
            margin-right: 25px;
        }
    </style>


    <script>
        jQuery(document).ready(function($) {
            $('.toast').toast({
                delay: 2500
            });

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
                            $('.toast .toast-body').html('Ein Fehler is aufgetretten.');
                            $('.toast').toast('show');
                        }
                        $('form#create_benutzer').trigger('reset');
                    },
                    error: function(data) {
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
            <a class="nav-link active" href="#anfragen" data-toggle="tab">Anfragen & Kunden</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#benutzerverwaltung" data-toggle="tab">Benutzerverwaltung</a>
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
            <a class="nav-link" href="<?= URL . 'logout.php' ?>">Logout</a>
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
                        <th scope="col">Maße</th>
                        <th scope="col">Gewicht</th>
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
                    <tr>
                        <!-- <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td> -->
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="tab-pane" id="benutzerverwaltung">
            <br>
            <h5 class="text-muted heading">Hier können Sie einen neuen Benutzer anlegen.</b></h5>
            <form id="create_benutzer" method="POST">
                <div>
                    <div class="form-group">
                        <input required type="text" class="form-control" id="bv_firmenname" name="bv_firmenname" placeholder="Firmenname ...">
                    </div>
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
                        <input required type="text" class="form-control" id="bv_ansprechpartner" name="bv_ansprechpartner" placeholder="Ansprechpartner ...">
                    </div>

                    <div class="form-group">
                        <input required type="email" class="form-control" id="bv_email" name="bv_email" placeholder="Email Adresse ...">
                    </div>

                    <div class="form-group">
                        <input required type="tel" class="form-control" id="bv_telefon" name="bv_telefon" placeholder="Telefon ...">
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <input required type="text" class="form-control" id="bv_strasse" name="bv_strasse" placeholder="Straße ...">
                    </div>
                    <div class="form-group">
                        <input required type="number" class="form-control" id="bv_hausnummer" name="bv_hausnummer" placeholder="Hausnummer ...">
                    </div>
                    <div class="form-group">
                        <input required type="number" class="form-control" id="bv_plz" name="bv_plz" placeholder="PLZ ...">
                    </div>
                    <div class="form-group">
                        <input required type="text" class="form-control" id="bv_ort" name="bv_ort" placeholder="Ort ...">
                    </div>
                    <div class="form-group">
                        <input required type="text" class="form-control" id="bv_land" name="bv_land" placeholder="Land ...">
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <input required type="tel" class="form-control" id="bv_ztelefon" name="bv_ztelefon" placeholder="Zentrale Telefonnummer ...">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="bv_freitext" name="bv_freitext" rows="6" placeholder="Freitext ..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

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