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



    <section class="canvas-wrap">
        <div class="canvas-content">
            <div>
                <img src="vorreiter/images/vorreiter_logo.png"><br>
                <a href="http://www.weiter-germany.com">
                    <small style="font-size:8px;color:#ffffff">Impressum</small>
                </a>
            </div>
            <div>

                <main>
                    <br>
                    <ul class="nav nav-pills" data-tabs="tabs">
                        <li class="nav-item"><a class="nav-link active" href="#div-login-form" data-toggle="tab">Login</a></li>
                    </ul>
                    <br>

                    <div id="my-tab-content" class="tab-content">
                        <div class="tab-pane active" id="div-login-form">
                            <form id="login-form" action="login.php" method="POST">
                                <div class="form-group">
                                    <label for="loginEmailOrUsername">Email address/Username</label>
                                    <input type="text" class="form-control" id="loginEmailOrUsername" name="loginEmailOrUsername" placeholder="Enter email or username">
                                </div>
                                <div class="form-group">
                                    <label for="loginPassword">Password</label>
                                    <input type="password" class="form-control" id="loginPassword" name="loginPassword" placeholder="Password">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div id="canvas" class="gradient"></div>

    </section>

    <!-- <script src="vorreiter/js/three.min.js"></script>

    <script src="vorreiter/js/projector.js"></script>
    <script src="vorreiter/js/canvas-renderer.js"></script>

    <script src="vorreiter/js/3d-lines-animation.js"></script>

    <script src="vorreiter/js/color.js"></script> -->


</body>

</html>