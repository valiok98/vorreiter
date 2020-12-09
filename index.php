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

    <!-- Fonts start -->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
    <!-- Fonts end -->

    <!-- Eigenes CSS start -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Eigenes CSS end -->


    <title>
        <?= $title ?>
    </title>


    <script>
        var mainUrl = "<?= URL ?>";
    </script>


    <script src="dist/index.js" defer></script>


</head>

<body>
    <div id="index" class="container main-container">
        <div class="row mh-100">
            <div class="col-lg-3">
                <!-- Empty column. Do not delete. -->
            </div>
            <div class="col-lg-6">
                <div>
                    <div id="div_vorreiter-logo">
                        <img src="images/index/vorreiter_logo.png" alt="vorreiter">
                    </div>
                    <div id="div_main_content">
                        <div id="div_zug_logo">
                            <img src="images/index/zug_logo.png" alt="zug">
                        </div>
                        <div id="div_login_form">
                            <h1><b>Login</b></h1>
                            <p>Sie sind registrierter Benutzer der neuesten Generation<br>
                                von optimierter Logistik und Service eines neuen Levels?
                                <br>
                                <br>
                                Herzlich Willkommen und Loggen Sie sich ein: <br>
                            </p>
                            <div>
                                <main_login_form></main_login_form>
                            </div>
                        </div>

                        <div class="overlay">
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <!-- Empty column. Do not delete. -->
            </div>
        </div>
    </div>
</body>

</html>