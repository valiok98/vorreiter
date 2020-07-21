<?php
require_once dirname(__FILE__) . '/definitions.php';

// Initialize the session
session_start();

$title = 'Vorreiter - New horizons for a digital world';

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if (isset($_SESSION["usertype"]) && $_SESSION["usertype"] === 'admin') {
        header("location:" . URL . "admin_content/welcome.php");
    } else if (isset($_SESSION["usertype"]) && $_SESSION["usertype"] === 'user') {
        header("location:" . URL . "user_content/welcome.php");
    }
    die;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap start -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <!-- Bootstrap end -->

    <!-- Fonts start -->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
    <!-- Fonts end -->

    <!-- Eigenes CSS start -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Eigenes CSS end -->

    <!-- Eigenes JS start -->
    <script src="js/script.js"></script>
    <!-- Eigenes JS start -->

    <title>
        <?= $title ?>
    </title>

</head>

<body>
    <div class="container main-container">
        <div class="row mh-100">
            <div class="col-sm-3">
                <!-- Empty column. Do not delete. -->
            </div>
            <div class="col-sm-6">
                <div>
                    <div id="div_vorreiter-logo">
                        <img src="images/index/vorreiter_logo.png" alt="vorreiter">
                        <!-- <a href="http://www.weiter-germany.com">
                            <small style="font-size:8px;color:#ffffff">Impressum</small>
                        </a> -->
                    </div>
                    <div id="div_main-content">
                        <div id="div_zug-logo">
                            <img src="images/index/zug_logo.png" alt="zug">
                        </div>
                        <div id="div_login-form">
                            <h1><b>Login</b></h1>
                            <p>Sie sind registrierter Benutzer der neuesten Generation<br>
                                von optimierter Logistik und Service eines neuen Levels?
                                <br>
                                <br>
                                Herzlich Willkommen und Loggen Sie sich ein: <br>
                            </p>
                            <div>
                                <form id="login-form" action="login.php" method="POST">
                                    <div class="container">
                                        <div class="form-group row">
                                            <div class="col-sm-4">
                                                <label for="loginEmailOrUsername">E-Mail/Benutzer:</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="loginEmailOrUsername" name="loginEmailOrUsername" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-4">
                                                <label for="loginPassword">Passwort:</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input type="password" class="form-control" id="loginPassword" name="loginPassword" placeholder="Passwort">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <!-- Empty column. Do not delete. -->
                                            </div>
                                            <div class="form-check col-sm-5 div_erinnere-dich">
                                                <input type="checkbox" class="form-check-input" id="erinnereDich" name="erinnereDich">
                                                <label class="form-check-label" for="erinnereDich">Erinnere dich</label>
                                            </div>
                                            <div class="col-sm-5 div_pass-vergessen">
                                                <p>Passwort vergessen?</p>
                                            </div>
                                        </div>
                                    </div>
                                    <button id="button_submit" type="submit" class="btn btn-primary">LOGIN</button>
                                    <br>
                                </form>
                            </div>
                        </div>

                        <div class="overlay">
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <!-- Empty column. Do not delete. -->
            </div>
        </div>
    </div>
</body>

</html>