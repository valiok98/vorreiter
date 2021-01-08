<?php
require_once dirname(__FILE__) . '/../../definitions.php';

$renewPassURL = filter_input(INPUT_GET, "renew_pass_url", FILTER_SANITIZE_STRING);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passwort ändern</title>

    <!-- Google captcha start -->
    <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer></script>
    <!-- Google captcha end -->

    <script>
        var mainUrl = '<?= URL ?>';
    </script>
    <script src="../../dist/index.js" defer></script>

</head>

<body>
    <div id="index" class="div_main container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <br>
                <a href="<?= URL ?>">
                    <img src="../img/vorreiter_logo.png" alt="Vorreiter Logo" style="background-color: black; border-radius: 2%;">
                </a>
            </div>
            <div class="col-lg-4">
                <script>
                    localStorage.setItem("renewPassUrl", "<?= $renewPassURL ?>");
                </script>
                <change_password></change_password>
            </div>
            <div class="col-lg-4"></div>
        </div>
    </div>
</body>

</html>