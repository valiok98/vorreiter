<?php
require_once dirname(__FILE__) . '/../../../definitions.php';

$title = 'Erneuern Sie Ihr Passwort';
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


    <script src="https://use.fontawesome.com/b9bdbd120a.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script type="text/javascript" src="js/pwstrength-bootstrap.min.js"></script>


    <title>
        <?= $title ?>
    </title>

    <script>
        $(document).ready(function() {
            let pass1 = '';
            let pass2 = '';

            $('input[aria-describedby="helpNewPass"]').on('input', function(e) {
                $(".inputHiddenPass")[0].value = e.target.value;
                $($(".inputHiddenPass")[0]).pwstrength("forceUpdate");
                pass1 = e.target.value;
                enable_disable_submit(pass1, pass2);
            });

            $('input[aria-describedby="helpNewPassAgain"]').on('input', function(e) {
                $(".inputHiddenPass")[1].value = e.target.value;
                $($(".inputHiddenPass")[1]).pwstrength("forceUpdate");
                pass2 = e.target.value;
                enable_disable_submit(pass1, pass2);
            });

            $('.inputHiddenPass').pwstrength();

            $('i.fa').on('click', function() {
                $(this).toggleClass('fa-eye-slash');
                $(this).toggleClass('fa-eye');
                if ($(this).hasClass('fa-eye')) {
                    $(this).parent().parent().parent().find('input').attr("type", "text");
                } else {
                    $(this).parent().parent().parent().find('input').attr("type", "password");
                }
            });


            $('form').on('submit', function(e) {
                e.preventDefault();
                let data = $(this).serializeArray();
                $.ajax({
                    type: "POST",
                    url: "<?= URL ?>admin_content/ajax/create_admin/create_perm_admin.php",
                    data: data,
                    success: function(data) {
                        data = JSON.parse(data);
                        if (data.success) {
                            $('.toast-body').text("Passwort erfolgreich erneuert.");
                            $('.toast').toast('show');
                        } else {
                            $('.toast-body').text(data.msg);
                            $('.toast').toast('show');
                        }
                        console.log(data);
                    },
                    error: function() {

                    }
                })
            });

            $('.toast').toast({
                delay: 3000
            });

            function enable_disable_submit(pass1, pass2) {
                if (pass1 === pass2 && pass1) {
                    $('button[type="submit"]').removeAttr("disabled");
                    $('.pIncorrectPass').hide();
                } else {
                    $('button[type="submit"]').attr("disabled", true);
                    $('.pIncorrectPass').show();
                }
            }

        });
    </script>

    <style>
        .main-part {
            margin: 0 auto;
            min-width: 40%;
            width: 50%;
        }

        .input-group-append {
            cursor: pointer;
        }
    </style>

</head>

<body>
    <!-- Empty column. Do not delete. -->
    <div class="main-part">
        <h5>Sie haben sich über
            <a href="https://weiter-entwickelt.de/clients/lst-siegen/">LST-Siegen</a>
            registriert ?
            <br>
            Hier können Sie Ihr vorläufiges Passwort ändern.
        </h5>
        <form>
            <div class="form-group">
                <label for="inputEmail">E-Mail Adresse</label>
                <input type="email" name="inputEmail" class="form-control" id="inputEmail" aria-describedby="emailHelp" placeholder="E-Mail Adresse ...">
                <small id="emailHelp" class="form-text text-muted">Die bei der Registrierung eingegebene E-Mail Adresse</small>
            </div>
            <div class="form-group">
                <label for="inputTempPass">Vorläufiges Passwort</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="inputTempPass" id="inputTempPass" minlength="6" placeholder="Vorläufiges Passwort ...">
                    <div class="input-group-addon">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Benutzername</label>
                <div class="input-group mb-3">
                    <input type="text" name="inputUsername" class="form-control" placeholder="Benutzername ..." aria-label="Benutzername" aria-describedby="helpUsername">
                </div>
            </div>
            <div class="form-group">
                <label>Neues Passwort</label>
                <div class="input-group mb-3">
                    <input type="password" name="inputNewPass" class="form-control" placeholder="Neues Passwort ..." aria-label="Neues Passwort" aria-describedby="helpNewPass">
                    <div class="input-group-append">
                        <span class="input-group-text" id="helpNewPass">
                            <i class="fa fa-eye-slash" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
                <input type="hidden" class="inputHiddenPass" id="inputHiddenNewPass">
            </div>
            <div class="form-group">
                <label>Neues Passwort(wiederholt)</label>
                <div class="input-group mb-3">
                    <input type="password" name="inputNewPassAgain" class="form-control" placeholder="Neues Passwort ..." aria-label="Neues Passwort(wiederholt)" aria-describedby="helpNewPassAgain">
                    <div class="input-group-append">
                        <span class="input-group-text" id="helpNewPassAgain">
                            <i class="fa fa-eye-slash" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
                <input type="hidden" class="inputHiddenPass" id="inputHiddenNewPassAgain">
            </div>
            <p class="pIncorrectPass">Die Passwörter stimmen nicht überein.</p>
            <button type="submit" class="btn btn-primary" disabled>Absenden</button>
        </form>
    </div>
    <div class="toast" aria-live="assertive" aria-atomic="true" style="position: absolute; top: 0; right: 0;">
        <div class="toast-body">
        </div>
    </div>
</body>


</html>