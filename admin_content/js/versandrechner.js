'use strict';

jQuery(document).ready(function() {
    var api_url = main_url + 'admin_content/ajax/api.php'; // über eigene php-datei
    // var api_url = versandrechner.apiUrl + "/ajax/api.php?action=versandrechner"; // über wp
    // Zustimmung fuer die Loeschung. 
    let dialogDeleteShipment = jQuery("#dialog_delete_shipment").dialog({
        resizable: false,
        autoOpen: false,
        height: "auto",
        width: 400,
        buttons: {
            "Ja": function() {
                // Delete from DOM.
                let orderIndex = jQuery(this).data('orderIndex');
                let contentID = jQuery('#shipmentslist #new_shipment' + orderIndex).attr('aria-controls');
                jQuery('#shipmentslist #new_shipment' + orderIndex).remove();
                jQuery('#' + contentID).remove();
                jQuery("#shipmentslist").accordion('option', 'disabled', false);

                rechne_gesamt_preis();
                rechne_gesamt_volumengewicht();

                jQuery(this).dialog("close");
            },
            "Abbrechen": function() {
                jQuery("#shipmentslist").accordion('option', 'disabled', false);
                jQuery(this).dialog("close");
            }
        }
    });


    if (jQuery('#versandrechner').length) {
        // Token
        let token = jQuery('#versandrechner input[name="token"]').val();
        // Irgendwas dummes damit machen, hauptsache ein (nicht spezifisch hierfür geschriebener) Spambot weiß es nicht
        let spl = token.substring(0, 4) + token.substring(4).split("").reverse().join("");

        jQuery('#versandrechner input[name="token"]').val(spl);

        jQuery('#versandrechner').on('submit', function(ev) {
            let newOrder = jQuery(this).find('button[type=submit][clicked=true]');

            // Falls der user eine neue sendung hinzufügen möchten.
            if (newOrder.length) {
                newOrder.removeAttr('clicked');
                // Neue Sendung nur dann hinzufügen, falls es momemtan < 10 Sendungen gibt.
                if (jQuery('.new_shipment').length < 10) {
                    add_new_order_item();
                }
            } else {
                // Falls der user auf Berechnen clickt.
                rechne_volumengewicht();
                rechne_preis();
                if (document.activeElement.value !== "calc") {
                    //  nicht nur Berechnung erwünscht
                    // Felder validieren
                    sende_kontaktwunsch(document.activeElement.value);
                }
            }
            ev.preventDefault();
        });

        // Event listener für neue Sendungen. Einfach Attribut clicked hinzufügen beim Clicken,
        // wichtig zum Unterscheiden beim Form submi oben.
        jQuery('#versandrechner button#neworder').on('click', function() {
            jQuery('input[type=submit]', jQuery(this).parents('form')).removeAttr('clicked');
            jQuery(this).attr('clicked', 'true');
        });

        // Accordion fuer alle Sendungen.
        jQuery("#shipmentslist").accordion({
            collapsible: true,
            active: false,
            icons: {
                header: "ui-icon-arrowthick-1-e",
                activeHeader: "ui-icon-arrowthick-1-s"
            }
        });

        jQuery('#btnversandrechner_mail').on('click', function() {
            jQuery('#versandrechner').submit();

        });

        jQuery('#btnversandrechner_phone').on('click', function() {
            jQuery('#versandrechner').submit();
        });



        jQuery(".grge").change(rechne_volumengewicht);
        jQuery("#servicelink").click(function() {
            jQuery("#serviceauswahl").show();
            jQuery("#servicelink").hide();
        });
        jQuery("#serviceclose").click(function() {
            jQuery("#serviceauswahl").hide();
            jQuery("#servicelink").show();
        });
        jQuery('#zeitfenster').change(function() { jQuery('#service1').prop('checked', (jQuery('#zeitfenster').val() == "-1")); });

        jQuery('#groesse-x').val(getUrlParameterByName('l'));
        jQuery('#groesse-y').val(getUrlParameterByName('b'));
        jQuery('#groesse-z').val(getUrlParameterByName('h'));
        jQuery('#gewicht').val(getUrlParameterByName('g'));
        rechne_volumengewicht();
    }


    function add_new_order_item() {
        let shipmentscol = jQuery('#shipmentscol'),
            shipments = shipmentscol.find('#shipmentslist');


        shipmentscol.show();


        // Die Sendungsliste ist leer oder es gibt keine Orders im sessionStorage. In beiden Fällen neu erstellen.
        if (!sessionStorage.getItem('numshipments')) {
            sessionStorage.setItem('numshipments', '0');
        } else {
            // Get the previous posts ... will work if we get them on page load, not inside this function. TODO
        }


        let plzStart = jQuery('#versandrechner input[name="plz-start"]');
        let plzZiel = jQuery('#versandrechner input[name="plz-ziel"]');
        let zeitFenster = jQuery('#versandrechner input[name="zeitfenster"]:checked');
        let zeitFensterLabel = jQuery('#versandrechner label[for="' + zeitFenster.attr('id') + '"]');
        let zustellTag = jQuery('#versandrechner input[name="zustelltag"]:checked');
        let zustellTagLabel = jQuery('#versandrechner label[for="' + zustellTag.attr('id') + '"]');
        let groesseX = jQuery('#versandrechner input[name="groesse-x"]');
        let groesseY = jQuery('#versandrechner input[name="groesse-y"]');
        let groesseZ = jQuery('#versandrechner input[name="groesse-z"]');
        let volumenGewicht = jQuery('#versandrechner input[name="volumengewicht"]');
        let gewicht = jQuery('#versandrechner input[name="gewicht"]');

        let orderIndex = JSON.parse(sessionStorage.getItem('numshipments'));

        sessionStorage.setItem('numshipments', JSON.stringify(orderIndex + 1));

        shipments.append('<h3 class="new_shipment" id="new_shipment' + orderIndex + '"><div><span>Paket: ' + (orderIndex + 1) + '</span><span class="delete_shipment"><b>X</b></span></div></h3>' +
            '<div>' +
            '<ul>' +
            '<li>Sendungsnummer: ' + (orderIndex + 1) + '</li>' +
            '<li>PLZ Start: ' + plzStart.val() + '</li>' +
            '<li>PLZ Ziel: ' + plzZiel.val() + '</li>' +
            '<li>Zeitfenster: ' + zeitFensterLabel.text().trim() + '</li>' +
            '<li>Zustelltag: ' + zustellTagLabel.text().trim() + '</li>' +
            '<li>Größe-X: ' + groesseX.val() + '</li>' +
            '<li>Größe-Y: ' + groesseY.val() + '</li>' +
            '<li>Größe-Z: ' + groesseZ.val() + '</li>' +
            '<li>Volumengewicht: ' + volumenGewicht.val() + '</li>' +
            '<li>Gewicht: ' + gewicht.val() + '</li>' +
            '<li>Preis: ' + parseFloat(rechne_preis({ returnPreis: true })).toFixed(2) + '</li>' +
            '<input type="hidden" class="shipment_length" value=' + groesseX.val() + '>' +
            '<input type="hidden" class="shipment_width" value=' + groesseY.val() + '>' +
            '<input type="hidden" class="shipment_height" value=' + groesseZ.val() + '>' +
            '<input type="hidden" class="shipment_weight" value=' + gewicht.val() + '>' +
            '<input type="hidden" class="shipment_volumeweight" value=' + volumenGewicht.val() + '>' +
            '<input type="hidden" class="shipment_price" value=' + rechne_preis({ returnPreis: true }) + '>' +
            '</ul>' +
            '</div>');

        // Refresh the accordion.
        shipments.accordion("refresh");

        rechne_gesamt_preis();
        rechne_gesamt_volumengewicht();

        // Clear all the needed fiels.
        groesseX.val('');
        groesseY.val('');
        groesseZ.val('');
        gewicht.val('');


        // Event listener falls man eine sendung löscht.
        jQuery('#shipmentslist #new_shipment' + orderIndex + ' .delete_shipment').on('click', function() {
            jQuery("#shipmentslist").accordion('option', 'disabled', true);
            dialogDeleteShipment.data('orderIndex', orderIndex).dialog('open');
        });


    }

    function sende_kontaktwunsch(wunsch) {
        jQuery('#versandrechner  .error').hide();
        jQuery('#ajaxerror').hide();
        jQuery('#ajaxdone').hide();

        if (wunsch === "email") {
            let re = RegExp(/^([a-zA-Z0-9_\-.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,7})$/);

            if (re.test(jQuery('#versandrechner input#email').val()) === false) {
                console.log('Ungültige Mailadresse');
                jQuery('#versandrechner label[for="email"] > .error').show();
                return;
            }
        } else
        if (wunsch === "phone") {
            let rep = RegExp(/([+\s\-\d]{4,})/);
            let ren = RegExp(/([\u00C0-\u017F\w.:\-\s]{3,})/);

            if (rep.test(jQuery('#versandrechner input#telefon').val()) === false) {
                console.log('Ungültige Telefonnummer');
                jQuery('#versandrechner label[for="telefon"] > .error').show();
                return;
            }
            if (ren.test(jQuery('#versandrechner input#name').val()) === false) {
                console.log('Ungültiger Name');
                jQuery('#versandrechner label[for="name"] > .error').show();
                return;
            }
        }



        let data_array = {};
        let zeitFenster = jQuery('#versandrechner input[name="zeitfenster"]:checked');
        let zeitFensterLabel = jQuery('#versandrechner label[for="' + zeitFenster.attr('id') + '"]');
        let zustellTag = jQuery('#versandrechner input[name="zustelltag"]:checked');
        let zustellTagLabel = jQuery('#versandrechner label[for="' + zustellTag.attr('id') + '"]');
        let shipmentscol = jQuery('#shipmentscol'),
            shipments = shipmentscol.find('#shipmentslist');


        jQuery.each(jQuery('form#versandrechner').serializeArray(), function() {
            if (this.name != "service")
                data_array[this.name] = this.value;
        });
        data_array["service_leistung"] = {};
        jQuery('#versandrechner input[name="service"]:checked').each(function() {
            data_array["service_leistung"][jQuery(this).val()] = "1";
            // console.log (jQuery(this).val());
        });
        if (data_array["service_leistung"] === {}) {
            data_array["service_leistung"] = '';
        }

        if (wunsch === "email") {
            data_array["kontaktwunsch"] = "Per E-Mail";
        } else {
            data_array["kontaktwunsch"] = "Telefonisch";
        }
        //console.log (data_array);

        data_array["volumengewicht"] = jQuery('#versandrechner input[name="volumengewicht"]').val();

        data_array["zeitfenster"] = zeitFensterLabel.text().trim();
        data_array["zustelltag"] = zustellTagLabel.text().trim();
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
            let length = jQuery(this).find("input.shipment_length").val();
            let width = jQuery(this).find("input.shipment_width").val();
            let height = jQuery(this).find("input.shipment_height").val();
            let weight = jQuery(this).find("input.shipment_weight").val();
            let volumeweight = jQuery(this).find("input.shipment_volumeweight").val();
            let price = jQuery(this).find("input.shipment_price").val();

            data_array["pakete"].push({
                "laenge": length,
                "breite": width,
                "hoehe": height,
                "gewicht": weight,
                "volumengewicht": volumeweight,
                "preis": price,
            });

        });
        console.log(data);
        var data = JSON.stringify(data_array);
        // console.log (data);

        jQuery.ajax({
            url: api_url,
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(res) { //
                if (res['success']) {
                    console.log(res);
                    jQuery('#ajaxdone .text').html(res['msg']);
                    jQuery('#ajaxdone').show();
                    // jQuery('#versandrechnerkontakt').hide();

                } else {
                    if (res.status && res.statusText) {
                        jQuery('#ajaxerror .text').html(res.status + ' ' + res.statusText + '<br>' + res['msg']);
                    } else {
                        jQuery('#ajaxerror .text').html(res['msg']);
                    }
                    jQuery('#ajaxerror').show();
                }
            },
            error: function(response) { //
                console.log(response);
                jQuery('#ajaxerror .text').html(response.status + ' ' + response.statusText + '<br>' + response.responseText);
                jQuery('#ajaxerror').show();
            }
        });
    }

    function rechne_volumengewicht() {
        let x = Number(jQuery("#groesse-x").val());
        let y = Number(jQuery("#groesse-y").val());
        let z = Number(jQuery("#groesse-z").val());
        let m = Number(jQuery("#gewicht").val());
        let mv = Math.ceil((x * y * z) / 6000, -1);
        if (isNaN(mv)) { mv = "0" }
        jQuery("#volumengewicht").val(mv);
    }

    function rechne_preis(options) {
        let zone = parseInt(jQuery('input[name=zeitfenster]:checked', '#versandrechner').val());
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

        //let gewicht =  Math.ceil(jQuery("#volumengewicht").val());
        let gewicht = Math.ceil(jQuery("#gewicht").val());
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
        if (jQuery('#service1').is(':checked')) aufschlag = aufschlag + 50;
        if (jQuery('#service2').is(':checked')) aufschlag = aufschlag + 5;
        if (jQuery('#service3').is(':checked')) aufschlag = aufschlag + 4;
        if (jQuery('#service4').is(':checked')) aufschlag = aufschlag + 2;
        if (jQuery('#service5').is(':checked')) aufschlag = aufschlag + 3.5;
        if (jQuery('#service6').is(':checked')) aufschlag = aufschlag + 7;
        if (jQuery('#service7').is(':checked')) aufschlag = aufschlag + 30;
        if (jQuery('#service8').is(':checked')) aufschlag = aufschlag + 1;
        if (jQuery('#service9').is(':checked')) aufschlag = aufschlag + 10;
        // if (jQuery('#service10').is(':checked')) aufschlag = aufschlag + 8;
        if (jQuery('#service11').is(':checked')) aufschlag = aufschlag + 8;
        if (jQuery('#service12').is(':checked')) aufschlag = aufschlag + 5;
        if (jQuery('#service13').is(':checked')) aufschlag = aufschlag + 2;
        if (jQuery('#service14').is(':checked')) aufschlag = aufschlag + 46;
        if (jQuery('#service15').is(':checked')) aufschlag = aufschlag + 50;
        if (jQuery('#service16').is(':checked')) aufschlag = aufschlag + 40;
        if (jQuery('#service17').is(':checked')) aufschlag = aufschlag + 2;
        if (jQuery('#service18').is(':checked')) aufschlag = aufschlag + 2;

        console.log('Aufschlag Service: ' + aufschlag);


        preis = Math.round((preis + aufschlag) * 100) / 100; //evtl. weitere nachkommastelle weg
        console.log('Gesamt: ' + preis);
        /* dummy */

        // Nur den gewuenschten Preis nehmen. Wichtig fuer andere Funktionen.
        if (options && options.returnPreis) {
            return preis;
        }

        jQuery('#warnung').hide();
        jQuery('#mwst').hide();

        let preisstring = "Bitte kontaktieren Sie uns für ein maßgeschneidertes Angebot";

        let steuerstring = "";

        if (gewicht < 50) {
            preisstring = '€ ' + (preis).toFixed(2).replace(".", ",");
            steuerstring = '€ ' + (preis * 0.19).toFixed(2).replace(".", ",");
            jQuery('#mwst').show();
        }
        jQuery('#brutto').text('' + preisstring);
        jQuery('#steuer').text(steuerstring);
        jQuery('#ergebnis').show();
        jQuery('input[name="summe"]').val(preis);


        jQuery('#versandrechnerkontakt').show();

    }


    function rechne_gesamt_volumengewicht() {
        let alleVolumenGewichte = jQuery('.shipment_volumeweight');
        let result = 0;
        alleVolumenGewichte.each(function() {
            result += parseFloat(jQuery(this).val());
        });
        jQuery('#gesamtvolumengewichtvalue').text(result);


    }

    function rechne_gesamt_preis() {
        let allePreise = jQuery('.shipment_price');
        let result = 0;
        allePreise.each(function() {
            result += parseFloat(jQuery(this).val());
        });

        jQuery('#gesamtpreisvalue').text(result.toFixed(2));
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

});