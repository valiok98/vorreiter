$(document).ready(function() {
    var pass1 = '';
    var pass2 = '';

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
        var data = $(this).serializeArray();
        $.ajax({
            type: "POST",
            url: mainUrl + "admin_content/ajax/create_admin/create_perm_admin.php",
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