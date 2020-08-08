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
    // Initialize the create "Anfrage 1" dialog.
    $('#dialog_anfrage-erstellen-1').dialog({
        autoOpen: false,
        modal: true,
        width: 800,
        height: 600,
        close: function() {
            $('#div_suche-anfrage-ergebnisse').empty();
            $('#form_suche-anfrage-kunden input').val("");
        }
    });
    // Initialize the create "Anfrage 2" dialog.
    $('#dialog_anfrage-erstellen-2').dialog({
        autoOpen: false,
        modal: true,
        width: 1000,
        height: 800,
        close: function() {
            $('#an_shipmentslist').empty();
            $('#an_plz-start').val('');
            $('#an_plz-ziel').val('');
            sessionStorage.removeItem('numshipments');
        }
    });
    // Initialize the create "Auftrag 1" dialog.
    $('#dialog_auftrag-erstellen-1').dialog({
        autoOpen: false,
        modal: true,
        width: 800,
        height: 600,
        close: function() {
            $('#div_suche-auftrag-ergebnisse').empty();
            $('#form_suche-auftrag-kunden input').val("");
        }
    });
    // Initialize the create "Auftrag 2" dialog.
    $('#dialog_auftrag-erstellen-2').dialog({
        autoOpen: false,
        modal: true,
        width: 1000,
        height: 800,
        close: function() {
            $('#auf_shipmentslist').empty();
            sessionStorage.removeItem('numshipments');
        }
    });
    // Initialize the create client dialog.
    $('#dialog_kunden-erstellen').dialog({
        autoOpen: false,
        modal: true,
        width: 800,
        height: 600
    });
    // Create an "Anfrage".
    $('.img_anfrage-erstellen').on('click', function() {
        $('#dialog_anfrage-erstellen-1').dialog('open');
    });
    // Create an "Auftrag".
    $('.img_auftrag-erstellen').on('click', function() {
        $('#dialog_auftrag-erstellen-1').dialog('open');
    });

    // Ajax for searching the "kunden".
    $('#form_suche-auftrag-kunden input').on('keyup', function(e) {
        let input = $(this).val().trim();
        // Empty the table if the input is empty.
        if (!input) {
            $('#div_suche-auftrag-ergebnisse').empty();
        } else {
            $.ajax({
                url: mainUrl + 'admin_content/find_client.php',
                type: "post",
                dataType: "json",
                data: {
                    "client_data": input
                },
                success: function(data) {
                    if (data['success']) {
                        let clientData = data['client_data'];
                        $('#div_suche-auftrag-ergebnisse').empty();
                        // Only display the results if theere is client data.

                        if (clientData.length) {
                            $('#div_suche-auftrag-ergebnisse').append('<div class="div_auftrag-kunden-ergebnis"><input readonly type="hidden" value="-1"><span>Neukunden erstellen</span><img style="float: right" src="../images/auftrag/auftrag_arrow.png" alt=""></div>');

                            clientData.forEach(function(client) {
                                $('#div_suche-auftrag-ergebnisse').append('<div class="div_auftrag-kunden-ergebnis"><input readonly type="hidden" value="' + client["id"] + '"><span>' +
                                    client["firmenname"] + '&nbsp;[' +
                                    client["plz"] + '&nbsp;-&nbsp;' +
                                    client["ort"] + ']</span><img style="float: right" src="../images/auftrag/auftrag_arrow.png" alt=""></div>');
                            });

                            $('.div_auftrag-kunden-ergebnis').on('click', function() {
                                let clientID = parseInt($(this).find('input').val().trim());
                                // Create a new client.
                                if (clientID === -1) {
                                    create_client(mainUrl, 'auftrag');
                                } else {
                                    // Load data for an existing client.
                                    create_auftrag(mainUrl, clientID);
                                }
                            });
                        }
                    }
                },
                error: function(data) {
                    $('.toast .toast-body').html('Ein Fehler is aufgetretten.');
                    $('.toast').toast('show');
                }
            });
        }
    });

    $('#form_suche-anfrage-kunden input').on('keyup', function(e) {
        let input = $(this).val().trim();
        // Empty the table if the input is empty.
        if (!input) {
            $('#div_suche-anfrage-ergebnisse').empty();
        } else {
            $.ajax({
                url: mainUrl + 'admin_content/find_client.php',
                type: "post",
                dataType: "json",
                data: {
                    "client_data": input
                },
                success: function(data) {
                    if (data['success']) {
                        let clientData = data['client_data'];
                        $('#div_suche-anfrage-ergebnisse').empty();
                        // Only display the results if theere is client data.

                        if (clientData.length) {
                            $('#div_suche-anfrage-ergebnisse').append('<div class="div_anfrage-kunden-ergebnis"><input readonly type="hidden" value="-1"><span>Neukunden erstellen</span><img style="float: right" src="../images/auftrag/auftrag_arrow.png" alt=""></div>');

                            clientData.forEach(function(client) {
                                $('#div_suche-anfrage-ergebnisse').append('<div class="div_anfrage-kunden-ergebnis"><input readonly type="hidden" value="' + client["id"] + '"><span>' +
                                    client["firmenname"] + '&nbsp;[' +
                                    client["plz"] + '&nbsp;-&nbsp;' +
                                    client["ort"] + ']</span><img style="float: right" src="../images/anfrage/anfrage_arrow.png" alt=""></div>');
                            });

                            $('.div_anfrage-kunden-ergebnis').on('click', function() {
                                let clientID = parseInt($(this).find('input').val().trim());
                                // Create a new client.
                                if (clientID === -1) {
                                    create_client(mainUrl, 'anfrage');
                                } else {
                                    // Load data for an existing client.
                                    create_anfrage(mainUrl, clientID);
                                }
                            });
                        }
                    }
                },
                error: function(data) {
                    $('.toast .toast-body').html('Ein Fehler is aufgetretten.');
                    $('.toast').toast('show');
                }
            });
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

function create_client(mainUrl, anAuf) {
    let url = mainUrl + 'admin_content/create_client.php';
    $('#dialog_kunden-erstellen').dialog('open');
    if (anAuf === 'anfrage') {
        $('#dialog_anfrage-erstellen-1').dialog('close');
    } else if (anAuf === 'auftrag') {
        $('#dialog_auftrag-erstellen-1').dialog('close');
    }

    $('#kunden_anlegen').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: $(this).serialize(),
            success: function(data) {
                if (data['success']) {
                    $('.toast .toast-body').html('Benutzer erfolgreich angelegt.');
                    $('.toast').toast('show');
                    // Close the Kunden dialog.
                    $('#dialog_kunden-erstellen').dialog('close');
                    // Store the data retrieved from the client.
                    let kunden_daten = data['client_data'].pop();
                    let firmenname = kunden_daten['firmenname'];
                    let ansprechpartner = kunden_daten['ansprechpartner'];
                    let kundennummer = kunden_daten['kundennummer'];
                    let telefon = kunden_daten['telefon'];
                    let email = kunden_daten['email'];

                    if (anAuf === 'anfrage') {
                        $('#dialog_anfrage-erstellen-2').dialog('open');
                    } else if (anAuf === 'auftrag') {
                        $('#dialog_auftrag-erstellen-2').dialog('open');
                        $('#span_auftrag-firmenname').html(firmenname);
                        $('#span_auftrag-ansprechpartner').html(ansprechpartner);
                        $('#span_auftrag-kundennummer').html(kundennummer);
                        $('#span_auftrag-telefon').html(telefon);
                        $('#span_auftrag-email').html(email);
                    }

                    console.log(data);

                } else {
                    $('.toast .toast-body').html(data['message']);
                    $('.toast').toast('show');
                }
                $('form#create_benutzer').trigger('reset');
            },
            error: function(data) {
                console.log(data);
                $('.toast .toast-body').html('Ein Fehler is aufgetretten.');
                $('.toast').toast('show');
            }
        });
    });

}

function create_auftrag(mainUrl, client_id) {
    $('#dialog_auftrag-erstellen-1').dialog('close');
    $('#dialog_auftrag-erstellen-2').dialog('open');
    load_calender(mainUrl, 'auftrag', client_id);


    let url = mainUrl + 'admin_content/find_client.php';
    $.ajax({
        url: url,
        type: "post",
        dataType: "json",
        data: { 'client_id': client_id },
        success: function(data) {
            if (data['success']) {
                // Store the data retrieved from the client.
                let kunden_daten = data['client_data'].pop();
                let firmenname = kunden_daten['firmenname'];
                let ansprechpartner = kunden_daten['ansprechpartner'];
                let kundennummer = kunden_daten['kundennummer'];
                let telefon = kunden_daten['telefon'];
                let email = kunden_daten['email'];

                $('#span_auftrag-firmenname').html(firmenname);
                $('#span_auftrag-ansprechpartner').html(ansprechpartner);
                $('#span_auftrag-kundennummer').html(kundennummer);
                $('#span_auftrag-telefon').html(telefon);
                $('#span_auftrag-email').html(email);
            } else {
                $('.toast .toast-body').html(data['message']);
                $('.toast').toast('show');
            }
        },
        error: function(data) {
            console.log(data);
            $('.toast .toast-body').html('Ein Fehler is aufgetretten.');
            $('.toast').toast('show');
        }
    });

}

function create_anfrage(mainUrl, client_id) {
    $('#dialog_anfrage-erstellen-1').dialog('close');
    $('#dialog_anfrage-erstellen-2').dialog('open');
    load_calender(mainUrl, 'anfrage', client_id);
    let url = mainUrl + 'admin_content/find_client.php';
    $.ajax({
        url: url,
        type: "post",
        dataType: "json",
        data: { 'client_id': client_id },
        success: function(data) {
            if (data['success']) {
                // Store the data retrieved from the client.
                let kunden_daten = data['client_data'].pop();
                let firmenname = kunden_daten['firmenname'];
                let ansprechpartner = kunden_daten['ansprechpartner'];
                let kundennummer = kunden_daten['kundennummer'];
                let telefon = kunden_daten['telefon'];
                let email = kunden_daten['email'];

                $('#span_anfrage-firmenname').html(firmenname);
                $('#span_anfrage-ansprechpartner').html(ansprechpartner);
                $('#span_anfrage-kundennummer').html(kundennummer);
                $('#span_anfrage-telefon').html(telefon);
                $('#span_anfrage-email').html(email);

                console.log(data);

            } else {
                $('.toast .toast-body').html(data['message']);
                $('.toast').toast('show');
            }
            $('form#create_benutzer').trigger('reset');
        },
        error: function(data) {
            console.log(data);
            $('.toast .toast-body').html('Ein Fehler is aufgetretten.');
            $('.toast').toast('show');
        }
    });
}
/**
 * Loads the calender and sets its event handlers.
 */
function load_calender(mainUrl, type, client_id) {
    let prefix = '';
    if (type === 'anfrage') {
        prefix = 'an';
    } else if (type === 'auftrag') {
        prefix = 'auf';
    }
    // Get the ajax URL for the requests.
    var apiUrl = mainUrl + 'admin_content/ajax/api.php';
    // var api_url = versandrechner.apiUrl + "/ajax/api.php?action=versandrechner"; // über wp
    // Zustimmung fuer die Loeschung. 
    let dialogDeleteShipment = $('#' + prefix + '_dialog_delete_shipment').dialog({
        resizable: false,
        autoOpen: false,
        height: "auto",
        width: 400,
        buttons: {
            "Ja": function() {
                // Delete from DOM.
                let orderIndex = $(this).data('orderIndex');
                let contentID = $('#' + prefix + '_new_shipment' + orderIndex).attr('aria-controls');
                $('#' + prefix + '_new_shipment' + orderIndex).remove();
                $('#' + contentID).remove();
                $('#' + prefix + '_shipmentslist').accordion('option', 'disabled', false);

                // Disable the send button if there are no packages.
                if (!$('#' + prefix + '_shipmentslist .new_shipment').length) {
                    $('#' + prefix + '_btnversandrechner_abs').prop('disabled', true);
                }

                rechne_gesamt_preis();
                rechne_gesamt_volumengewicht();

                $(this).dialog("close");
            },
            "Abbrechen": function() {
                $('#' + prefix + '_shipmentslist').accordion('option', 'disabled', false);
                $(this).dialog("close");
            }
        }
    });

    if ($('#versandrechner_' + type).length) {
        $('#' + prefix + '_btnversandrechner_abs').on('click', function(ev) {
            ev.preventDefault();
            // Calculate the total volume weight.
            rechne_volumengewicht();
            // Calculate the total price.
            rechne_preis({}, prefix, type);



            sende_kontaktwunsch(apiUrl, prefix, type, client_id);
        });

        // Event listener for a new package.
        $('button#' + prefix + '_neworder').on('click', function() {
            // Check if all inputs are non-empty.
            if (prefix === 'an') {
                let plzStart = parseInt($('#an_plz-start').val());
                let plzZiel = parseInt($('#an_plz-ziel').val());
                if (!plzStart || !plzZiel) {
                    $('.toast .toast-body').html('Bitte PLZ Felder ausfüllen.');
                    $('.toast').toast('show');
                    return;
                }
            }

            let formData = $('form#versandrechner_anfrage').serializeArray();
            let timeSlot, daySlot, sizeX, sizeY, sizeZ, weight, volumeWeight;
            formData.forEach(function(input) {
                switch (input['name']) {
                    case prefix + '_zeitfenster':
                        timeSlot = input['value'];
                        break;
                    case prefix + '_zustelltag':
                        daySlot = input['value'];
                        break;
                    case prefix + '_groesse-x':
                        sizeX = input['value'];
                        break;
                    case prefix + '_groesse-y':
                        sizeY = input['value'];
                        break;
                    case prefix + '_groesse-z':
                        sizeZ = input['value'];
                        break;
                    case prefix + '_gewicht':
                        weight = input['value'];
                        break;
                    case prefix + '_volumengewicht':
                        volumeWeight = input['value'];
                        break;
                }
            });

            // In case some fields are missing, then issue an error message.
            if (!timeSlot || !daySlot || !sizeZ || !sizeY || !sizeZ || !weight || !volumeWeight) {
                $('.toast .toast-body').html('Bitte alle Felder ausfüllen.');
                $('.toast').toast('show');
            }

            // Add a new package only if there are currently less than 10 packages.
            if ($('form#versandrechner_' + type + ' .new_shipment').length < 10) {
                add_new_order_item(prefix, type);
                // Enable the send button.
                $('#' + prefix + '_btnversandrechner_abs').removeAttr('disabled');
            }
        });

        // Accordion fuer alle Sendungen.
        $('#' + prefix + '_shipmentslist').accordion({
            collapsible: true,
            active: false,
            icons: {
                header: "ui-icon-arrowthick-1-e",
                activeHeader: "ui-icon-arrowthick-1-s"
            }
        });

        $('.grge').change(rechne_volumengewicht);
        $('#' + prefix + '_servicelink').click(function() {
            $('#' + prefix + '_serviceauswahl').show();
            $('#' + prefix + '_servicelink').hide();
        });
        $('#' + prefix + '_serviceclose').click(function() {
            $('#' + prefix + '_serviceauswahl').hide();
            $('#' + prefix + '_servicelink').show();
        });
        $('#' + prefix + '_zeitfenster').change(function() { $('#' + prefix + '_service1').prop('checked', ($('#' + prefix + '_zeitfenster').val() == "-1")); });

        $('#' + prefix + '_groesse-x').val(getUrlParameterByName('l'));
        $('#' + prefix + '_groesse-y').val(getUrlParameterByName('b'));
        $('#' + prefix + '_groesse-z').val(getUrlParameterByName('h'));
        $('#' + prefix + '_gewicht').val(getUrlParameterByName('g'));
        rechne_volumengewicht();
    }


    function add_new_order_item(prefix, type) {
        let shipmentscol = $('#' + prefix + '_shipmentscol'),
            shipments = shipmentscol.find('#' + prefix + '_shipmentslist');


        shipmentscol.show();

        // In case the list with the packets is empty. Create a new one.
        if (!sessionStorage.getItem('numshipments')) {
            sessionStorage.setItem('numshipments', '0');
        }

        let plzStartVal = '';
        let plzZielVal = '';

        if (prefix === 'an') {
            plzStartVal = $('input[name="' + prefix + '_plz-start"]').val();
            plzZielVal = $('input[name="' + prefix + '_plz-ziel"]').val();
        }

        let zeitFenster = $('#versandrechner_' + type + ' input[name="' + prefix + '_zeitfenster"]:checked');
        let zeitFensterLabel = $('#versandrechner_' + type + ' label[for="' + zeitFenster.attr('id') + '"]');
        let zustellTag = $('#versandrechner_' + type + ' input[name="' + prefix + '_zustelltag"]:checked');
        let zustellTagLabel = $('#versandrechner_' + type + ' label[for="' + zustellTag.attr('id') + '"]');
        let groesseX = $('#versandrechner_' + type + ' input[name="' + prefix + '_groesse-x"]');
        let groesseY = $('#versandrechner_' + type + ' input[name="' + prefix + '_groesse-y"]');
        let groesseZ = $('#versandrechner_' + type + ' input[name="' + prefix + '_groesse-z"]');
        let volumenGewicht = $('#versandrechner_' + type + ' input[name="' + prefix + '_volumengewicht"]');
        let gewicht = $('#versandrechner_' + type + ' input[name="' + prefix + '_gewicht"]');

        let orderIndex = JSON.parse(sessionStorage.getItem('numshipments'));

        sessionStorage.setItem('numshipments', JSON.stringify(orderIndex + 1));

        shipments.append('<h3 class="new_shipment" id="' + prefix + '_new_shipment' + orderIndex + '"><div><span>Paket: ' + (orderIndex + 1) + '</span><span class="delete_shipment"><b>X</b></span></div></h3>' +
            '<div>' +
            '<ul>' +
            '<li>Sendungsnummer: ' + (orderIndex + 1) + '</li>' +
            '<li>PLZ Start: ' + plzStartVal + '</li>' +
            '<li>PLZ Ziel: ' + plzZielVal + '</li>' +
            '<li>Zeitfenster: ' + zeitFensterLabel.text().trim() + '</li>' +
            '<li>Zustelltag: ' + zustellTagLabel.text().trim() + '</li>' +
            '<li>Größe-X: ' + groesseX.val() + '</li>' +
            '<li>Größe-Y: ' + groesseY.val() + '</li>' +
            '<li>Größe-Z: ' + groesseZ.val() + '</li>' +
            '<li>Volumengewicht: ' + volumenGewicht.val() + '</li>' +
            '<li>Gewicht: ' + gewicht.val() + '</li>' +
            '<li>Preis: ' + parseFloat(rechne_preis({ returnPreis: true }, prefix, type)).toFixed(2) + '</li>' +
            '<input type="hidden" class="shipment_length" value=' + groesseX.val() + '>' +
            '<input type="hidden" class="shipment_width" value=' + groesseY.val() + '>' +
            '<input type="hidden" class="shipment_height" value=' + groesseZ.val() + '>' +
            '<input type="hidden" class="shipment_weight" value=' + gewicht.val() + '>' +
            '<input type="hidden" class="shipment_volumeweight" value=' + volumenGewicht.val() + '>' +
            '<input type="hidden" class="shipment_price" value=' + rechne_preis({ returnPreis: true }, prefix, type) + '>' +
            '</ul>' +
            '</div>');

        // Refresh the accordion.
        shipments.accordion("refresh");

        rechne_gesamt_preis();
        rechne_gesamt_volumengewicht();

        // Clear all the needed fields.
        groesseX.val('');
        groesseY.val('');
        groesseZ.val('');
        gewicht.val('');


        // Event listener in case the user deletes a package.
        $('#' + prefix + '_new_shipment' + orderIndex + ' .delete_shipment').on('click', function() {
            $('#' + prefix + '_shipmentslist').accordion('option', 'disabled', true);
            dialogDeleteShipment.data('orderIndex', orderIndex).dialog('open');
        });
    }

    function sende_kontaktwunsch(apiUrl, prefix, type, clientID) {
        $('#' + prefix + '_versandrechner  .error').hide();
        $('#' + prefix + '_ajaxerror').hide();
        $('#' + prefix + '_ajaxdone').hide();

        let data_array = {};
        let zeitFenster = $('#versandrechner_' + type + ' input[name="' + prefix + '_zeitfenster"]:checked');
        let zeitFensterLabel = $('#versandrechner_' + type + ' label[for="' + zeitFenster.attr('id') + '"]');
        let zustellTag = $('#versandrechner_' + type + ' input[name="' + prefix + 'zustelltag"]:checked');
        let zustellTagLabel = $('#versandrechner_' + type + ' label[for="' + zustellTag.attr('id') + '"]');
        let shipmentscol = $('#' + prefix + '_shipmentscol'),
            shipments = shipmentscol.find('#' + prefix + '_shipmentslist');

        $.each($('form#versandrechner_' + type).serializeArray(), function() {
            if (this.name != prefix + "_service")
                data_array[this.name] = this.value;
        });
        data_array["service_leistung"] = {};
        $('#versandrechner_' + type + ' input[name="' + prefix + '_service"]:checked').each(function() {
            data_array["service_leistung"][$(this).val()] = "1";
            // console.log ($(this).val());
        });
        if (data_array["service_leistung"] === {}) {
            data_array["service_leistung"] = '';
        }

        data_array["kontaktwunsch"] = "Per E-Mail";
        data_array["telefon"] = 123456789;
        data_array["plz-start"] = $('#an_plz-start').html();
        data_array["plz-ziel"] = $('#an_plz-ziel').html();
        data_array["name"] = $('#span_anfrage-firmenname').html();
        data_array["volumengewicht"] = $('#versandrechner_' + type + ' input[name="' + prefix + '_volumengewicht"]').val();

        data_array["zeitfenster"] = zeitFensterLabel.text().trim();
        data_array["zustelltag"] = zustellTagLabel.text().trim();
        data_array["kundennr"] = client_id;
        data_array["email"] = $('#span_anfrage-email').html();
        data_array["pakete"] = [{
            "laenge": data_array["groesse-x"],
            "breite": data_array["groesse-y"],
            "hoehe": data_array["groesse-z"],
            "gewicht": data_array["gewicht"],
            "volumengewicht": data_array["volumengewicht"],
            "preis": data_array["summe"],
        }];

        // Add all the packages as separate items.
        shipments.find("ul").each(function() {
            let length = $(this).find("input.shipment_length").val();
            let width = $(this).find("input.shipment_width").val();
            let height = $(this).find("input.shipment_height").val();
            let weight = $(this).find("input.shipment_weight").val();
            let volumeweight = $(this).find("input.shipment_volumeweight").val();
            let price = $(this).find("input.shipment_price").val();

            data_array["pakete"].push({
                "laenge": length,
                "breite": width,
                "hoehe": height,
                "gewicht": weight,
                "volumengewicht": volumeweight,
                "preis": price,
            });

        });
        var data = JSON.stringify(data_array);
        // console.log (data);

        $.ajax({
            url: apiUrl,
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(res) { //
                if (res['success']) {
                    console.log(res);
                    $('#' + prefix + '_ajaxdone .text').html(res['msg']);
                    $('#' + prefix + '_ajaxdone').show();
                    // $('#'+prefix+'_versandrechnerkontakt').hide();

                } else {
                    if (res.status && res.statusText) {
                        $('#' + prefix + '_ajaxerror .text').html(res.status + ' ' + res.statusText + '<br>' + res['msg']);
                    } else {
                        $('#' + prefix + '_ajaxerror .text').html(res['msg']);
                    }
                    $('#' + prefix + '_ajaxerror').show();
                }
            },
            error: function(response) { //
                console.log(response);
                $('#' + prefix + '_ajaxerror .text').html(response.status + ' ' + response.statusText + '<br>' + response.responseText);
                $('#' + prefix + '_ajaxerror').show();
            }
        });
    }

    function rechne_volumengewicht() {
        let x = Number($('#' + prefix + '_groesse-x').val());
        let y = Number($('#' + prefix + '_groesse-y').val());
        let z = Number($('#' + prefix + '_groesse-z').val());
        let m = Number($('#' + prefix + '_gewicht').val());
        let mv = Math.ceil((x * y * z) / 6000, -1);
        if (isNaN(mv)) { mv = "0" }
        $('#' + prefix + '_volumengewicht').val(mv);
    }

    function rechne_preis(options, prefix, type) {
        let zone = parseInt($('input[name=' + prefix + '_zeitfenster]:checked', '#versandrechner_' + type).val());
        let grundpreis = {
            7: 6.43,
            6: 12.00,
            5: 14.00,
            3: 18.15,
            2: 28.11,
            0: 0,
            '-1': 0
        };
        let preissteigerungsversatz = {
            7: 0,
            6: 0,
            5: 0,
            3: 0,
            2: 1,
            0: 0,
            '-1': 0
        };
        let preissteigerung = {
            7: 0.53,
            6: 0.53,
            5: 0.53,
            3: 0.53,
            2: 0.53,
            0: 0,
            '-1': 0
        };
        let preissteigerung_hoch = {
            7: 0.74,
            6: 0.75, // ausnahme
            5: 0.74,
            3: 0.74,
            2: 0.74,
            0: 0,
            '-1': 0
        };


        let preis = 0;
        let aufschlag = 0;


        /*
            switch (zone) { // umland
                case 7 :
                    grundpreis = 6.43; // 9-17
                    break;
                case 6 :
                    grundpreis = 16.60; // 8-12
                    break;
                case 5 :
                    grundpreis = 19.20; // 8-10
                    break;
                case 3 :
                    grundpreis = 24.60; // 8-9
                    break;
                case 2 :
                    grundpreis = 37.54; // 7.30-8
                    break;
                default:
                    grundpreis = 0; // fix
                    break;
            }*/
        // console.log ('Zone: '+zone);
        // debug console.log('Grundpreis: ' + grundpreis[zone]);

        //let gewicht =  Math.ceil($("#_volumengewicht").val());
        let gewicht = Math.ceil($('#' + prefix + '_gewicht').val());
        // pro kg 46 cent mehr, bis einschließlich 30kg. danach 74 cent mehr


        if (gewicht < 31) {
            preis = (grundpreis[zone] + (gewicht - 1) * preissteigerung[zone]) * 1.3 + 1;
        } else {
            preis = ((grundpreis[zone] + (29) * preissteigerung[zone]) * 1.3 + 1) +
                ((gewicht - 30) * preissteigerung_hoch[zone] * 1.3);


        }
        // sonderheit bei zone 2
        if (gewicht > 1) {
            preis = preis - (preissteigerungsversatz[zone] * preissteigerung[zone]) * 1.3;
        }

        console.log('Preis: ' + preis);

        // serviceleistungen
        if ($('#' + prefix + '_service1').is(':checked')) aufschlag = aufschlag + 50;
        if ($('#' + prefix + '_service2').is(':checked')) aufschlag = aufschlag + 5;
        if ($('#' + prefix + '_service3').is(':checked')) aufschlag = aufschlag + 4;
        if ($('#' + prefix + '_service4').is(':checked')) aufschlag = aufschlag + 2;
        if ($('#' + prefix + '_service5').is(':checked')) aufschlag = aufschlag + 3.5;
        if ($('#' + prefix + '_service6').is(':checked')) aufschlag = aufschlag + 7;
        if ($('#' + prefix + '_service7').is(':checked')) aufschlag = aufschlag + 30;
        if ($('#' + prefix + '_service8').is(':checked')) aufschlag = aufschlag + 1;
        if ($('#' + prefix + '_service9').is(':checked')) aufschlag = aufschlag + 10;
        // if ($('#'+prefix+'_service10').is(':checked')) aufschlag = aufschlag + 8;
        if ($('#' + prefix + '_service11').is(':checked')) aufschlag = aufschlag + 8;
        if ($('#' + prefix + '_service12').is(':checked')) aufschlag = aufschlag + 5;
        if ($('#' + prefix + '_service13').is(':checked')) aufschlag = aufschlag + 2;
        if ($('#' + prefix + '_service14').is(':checked')) aufschlag = aufschlag + 46;
        if ($('#' + prefix + '_service15').is(':checked')) aufschlag = aufschlag + 50;
        if ($('#' + prefix + '_service16').is(':checked')) aufschlag = aufschlag + 40;
        if ($('#' + prefix + '_service17').is(':checked')) aufschlag = aufschlag + 2;
        if ($('#' + prefix + '_service18').is(':checked')) aufschlag = aufschlag + 2;

        console.log('Aufschlag Service: ' + aufschlag);


        preis = Math.round((preis + aufschlag) * 100) / 100; //evtl. weitere nachkommastelle weg
        console.log('Gesamt: ' + preis);
        /* dummy */

        // Nur den gewuenschten Preis nehmen. Wichtig fuer andere Funktionen.
        if (options && options.returnPreis) {
            return preis;
        }

        $('#' + prefix + '_warnung').hide();
        $('#' + prefix + '_mwst').hide();

        let preisstring = "Bitte kontaktieren Sie uns für ein maßgeschneidertes Angebot";

        let steuerstring = "";

        if (gewicht < 50) {
            preisstring = '€ ' + (preis).toFixed(2).replace(".", ",");
            steuerstring = '€ ' + (preis * 0.19).toFixed(2).replace(".", ",");
            $('#' + prefix + '_mwst').show();
        }
        $('#' + prefix + '_brutto').text('' + preisstring);
        $('#' + prefix + '_steuer').text(steuerstring);
        $('#' + prefix + '_ergebnis').show();
        $('input[name="summe"]').val(preis);


        $('#' + prefix + '_versandrechnerkontakt').show();

    }

    function rechne_gesamt_volumengewicht() {
        let alleVolumenGewichte = $('.shipment_volumeweight');
        let result = 0;
        alleVolumenGewichte.each(function() {
            result += parseFloat($(this).val());
        });
        $('#' + prefix + '_gesamtvolumengewichtvalue').text(result);


    }

    function rechne_gesamt_preis() {
        let allePreise = $('.shipment_price');
        let result = 0;
        allePreise.each(function() {
            result += parseFloat($(this).val());
        });

        $('#' + prefix + '_gesamtpreisvalue').text(result.toFixed(2));
    }
    // URL-Parameter abfragen
    function getUrlParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    };

}