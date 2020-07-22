jQuery(document).ready(function($) {
    // Editable component for inline editing.
    $.fn.editable.defaults.mode = 'inline';

    $.fn.editableform.buttons = '<button type="submit" class="btn btn-primary btn-sm editable-submit">OK</button><button type="button" class="btn btn-default btn-sm editable-cancel">X</button>';

    $('#edit_firmenname').editable();
    // Toast component.
    $('.toast').toast({
        delay: 3500
    });
    // DataTable components.
    $('#anfragen_table').DataTable({
        pageLength: 10,
        lengthMenu: [10, 50, 100],
        language: {
            lengthMenu: "_MENU_ Einträge anzeigen"
        },
        order: [
            [0, "desc"]
        ],
        info: false,
        pagingType: "first_last_numbers",
        language: {
            paginate: {
                first: "Erste",
                last: "Letzte"
            },
            emptyTable: "Es gibt keine Daten in der Tabelle."
        }
    });
    $('#auftraege_table').DataTable({
        pageLength: 10,
        lengthMenu: [10, 50, 100],
        language: {
            lengthMenu: "_MENU_ Einträge anzeigen"
        },
        order: [
            [0, "desc"]
        ],
        info: false,
        pagingType: "first_last_numbers",
        language: {
            paginate: {
                first: "Erste",
                last: "Letzte"
            },
            emptyTable: "Es gibt keine Daten in der Tabelle."
        }
    });
    // Initialize the create "Anfrage" dialog.
    $('#dialog_anfrage-erstellen').dialog({
        autoOpen: false,
        modal: true,
        width: 800,
        height: 600
    });
    // Initialize the create "Auftrag" dialog.
    $('#dialog_auftrag-erstellen').dialog({
        autoOpen: false,
        modal: true,
        width: 800,
        height: 600
    });
    // Create an "Anfrage".
    $('.img_anfrage-erstellen').on('click', function() {
        console.log('Anfrage erstellen.');
        $('#dialog_anfrage-erstellen').dialog('open');
    });
    // Create an "Auftrag".
    $('.img_auftrag-erstellen').on('click', function() {
        console.log('Auftrag erstellen.');
        $('#dialog_auftrag-erstellen').dialog('open');
    });


    $('#kunden_table_1').DataTable({
        pageLength: 10,
        lengthMenu: [10, 50, 100],
        language: {
            lengthMenu: "_MENU_ Einträge anzeigen"
        }
    });

    $('#kunden_table_2').DataTable({
        pageLength: 10,
        lengthMenu: [10, 50, 100],
        language: {
            lengthMenu: "_MENU_ Einträge anzeigen"
        }
    });

    // Verification of hausnummer number.
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


    // Show/hide the abholadresse field.

    $('#ae_abholadresse').hide();
    $('label[for="ae_abholadresse"]').hide();
    $('#ae_dg_abholadresse').hide();
    $('label[for="ae_dg_abholadresse"]').hide();

    $('#chk_ae_abholadresse').on('change', function() {
        if (this.checked) {
            $('#ae_abholadresse').show();
            $('label[for="ae_abholadresse"]').show();
            $('#ae_abholadresse').prop('required', true);
        } else {
            $('#ae_abholadresse').hide();
            $('label[for="ae_abholadresse"]').hide();
            $('#ae_abholadresse').removeAttr('required');
        }
    });

    $('#chk_ae_dg_abholadresse').on('change', function() {
        if (this.checked) {
            $('#ae_dg_abholadresse').show();
            $('label[for="ae_dg_abholadresse"]').show();
            $('#ae_dg_abholadresse').prop('required', true);
        } else {
            $('#ae_dg_abholadresse').hide();
            $('label[for="ae_dg_abholadresse"]').hide();
            $('#ae_dg_abholadresse').removeAttr('required');
        }
    });
    // Activate the tooltip component for kunden table.
    $('[data-toggle="tooltip"]').tooltip();

    // Toggle the side navbar images on click.
    let images_id = [
        "img_kunden",
        "img_an-auf",
        "img_tracking",
        "img_flotte",
        "img_support",
        "img_stats",
        "img_settings"
    ];
    let b_w_images = [
        "kunden_b_w.png",
        "an_auf_b_w.png",
        "tracking_b_w.png",
        "flotte_b_w.png",
        "support_b_w.png",
        "stats_b_w.png",
        "settings_b_w.png",
    ];
    let color_images = [
        "kunden_color.png",
        "an_auf_color.png",
        "tracking_color.png",
        "flotte_color.png",
        "support_color.png",
        "stats_color.png",
        "settings_color.png",
    ];
    // Switch between the black&white and the colored images.
    images_id.forEach(function(img_id, index) {
        $("#" + img_id).on('click', function() {
            let img_name = $(this).prop("src").split("/").slice(-1).pop().trim();
            if (img_name === b_w_images[index]) {
                unselect_all_sidenav_items();
                $(this).prop("src", "../images/navbar/" + color_images[index]);
            } else {
                $(this).prop("src", "../images/navbar/" + b_w_images[index]);
            }
        });
    });

    // Disable when the vorreiter(home) image is clicked.
    $("#vorreiter_img").on('click', unselect_all_sidenav_items);

    function unselect_all_sidenav_items() {
        images_id.forEach(function(img_id, index) {
            $("#" + img_id).prop("src", "../images/navbar/" + b_w_images[index]);
        });
    }
});