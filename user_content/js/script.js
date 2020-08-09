        jQuery(document).ready(function($) {

            $('.toast').toast({
                delay: 3500
            });

            $('#kunden_table').DataTable({
                pageLength: 50,
                lengthMenu: [50, 100],
                language: {
                    lengthMenu: "_MENU_ Einträge anzeigen"
                }
            });


            $('#bv_hausnummer').on('keyup', function(e) {
                let numReg = new RegExp("\d+");
                let inputVal = e.target.value;
                let matchObj = inputVal.match(/\d+/);
                if (!matchObj) {
                    e.target.value = '';
                } else if (matchObj && matchObj[0] !== inputVal) {
                    e.target.value = matchObj[0];
                }
            });

            // Handle the update of the regular user information.
            $('form#update_benutzer').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: mainUrl + 'user_content/update_client.php',
                    type: "post",
                    dataType: "json",
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data['success']) {
                            $('.toast .toast-body').html('Die Daten wurden erneuert.');
                            $('.toast').toast('show');
                        } else {
                            $('.toast .toast-body').html(data['msg']);
                            $('.toast').toast('show');
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        $('.toast .toast-body').html('Ein Fehler is aufgetretten.');
                        $('.toast').toast('show');
                    }
                });
            });
            // Handle the update of the user password.
            $('form#update_passwort').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: mainUrl + 'user_content/update_client.php',
                    type: "post",
                    dataType: "json",
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data['success']) {
                            $('.toast .toast-body').html('Das Passwort wurde erneuert.');
                            $('.toast').toast('show');
                        } else {
                            $('.toast .toast-body').html(data['msg']);
                            $('.toast').toast('show');
                        }
                        $('form#update_passwort').trigger('reset');
                    },
                    error: function(data) {
                        console.log(data);
                        $('.toast .toast-body').html('Ein Fehler is aufgetretten.');
                        $('.toast').toast('show');
                    }
                });
            });
        });