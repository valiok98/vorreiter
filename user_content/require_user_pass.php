<?php
require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../definitions.php';

session_start();

$title = '';
$username = '';
$id = '';
$first_update = false;

if (isset($_SESSION['username'])) {
    $title = 'Welcome, ' . $_SESSION['username'] . '!';
    $username = $_SESSION['username'];
} else {
    header('location: ' . URL . 'logout.php');
    die;
}
// Get the user information.

$sql = "SELECT id, first_update FROM kunden WHERE username = ?";

if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("s", $username);
    if ($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $first_update);
            $stmt->fetch();
            $stmt->free_result();
        }
    } else {
        echo "Something went wrong with MySQL.";
    }

    if ($first_update) {
        header('location: ' . URL . 'user_content/welcome.php');
        die;
    }

    $stmt->close();
    $mysqli->close();
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
    <style>
        #div-rip-form {
            min-width: 30vw;
            min-height: 30vh;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            margin-bottom: 25px;
        }
    </style>


    <script>
        jQuery(document).ready(function($) {
            $('.toast').toast({
                delay: 2500
            });

            $('form#rup-form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '<?= URL . 'user_content/check_user_data.php' ?>',
                    type: "post",
                    dataType: "json",
                    data: $(this).serialize(),
                    success: function(data) {
                        // If we are successful we directly redirect from PHP, not here.
                        if (data['success']) {
                            window.location = '<?= URL . 'user_content/welcome.php' ?>';
                        } else {
                            $('.toast .toast-body').html(data['msg']);
                            $('.toast').toast('show');
                        }
                        $('form#rup-form').trigger('reset');
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

    <div id="div-rip-form">
        <h5 class="text-muted heading">Sie loggen Sich zum ersten Mal hier.<br>Bitte geben Sie Ihre neuen Benutzernamen und Passwort.</b></h5>
        <form id="rup-form" method="POST">
            <div class="form-group">
                <input value=<?= $id ?> readonly type="hidden" class="form-control" id="rup_kundenid" name="rup_kundenid">
            </div>
            <div class="form-group">
                <label for="rup_benutzername">Benutzername</label>
                <input type="text" class="form-control" id="rup_benutzername" name="rup_benutzername" placeholder="Benutzername">
            </div>
            <div class="form-group">
                <label for="rup_passwort">Passwort</label>
                <input type="password" class="form-control" id="rup_passwort" name="rup_passwort" placeholder="Passwort">
            </div>
            <button type="submit" class="btn btn-primary">Updaten</button>
            <button class="btn btn-link"><a href="<?= URL . 'logout.php' ?>">Logout</a></button>
        </form>
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