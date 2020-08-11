// Global function to delete an accordion item.
function delete_accordion_item(index) {

}

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

});
/**
 * Loads the calender and sets its event handlers.
 */