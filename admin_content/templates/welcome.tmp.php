<?php
require_once dirname(__FILE__) . '/../../definitions.php';

function anfragen_table($row)
{
    switch ($row['status']) {
        case "Offen":
            $row['status'] = '<span style="color: red;">' . $row['status'] . '</span>';
            break;
        case "Ausstehend":
            $row['status'] = '<span style="color: orange;">' . $row['status'] . '</span>';
            break;
        case "Abgelehnt":
            $row['status'] = '<span style="color: purple;">' . $row['status'] . '</span>';
            break;
        case "Beauftragt":
            $row['status'] = '<span style="color: green;">' . $row['status'] . '</span>';
            break;
    }

    return '<tr>
    <td>
    <span>&nbsp;<img src="../images/an_auf_table/firmen_details.png">&nbsp;' . $row['kunden_name'] . '</span></td>
    <td>' . date_format(date_create($row['zeit']), "d/m/Y") . '</td>
    <td>' . $row['plz_start'] . '</td>
    <td>' . $row['plz_ziel'] . '</td>
    <td>' . $row['status'] . '</td>
    <td>
        <img src="../images/an_auf_table/eye.png" style="width: 22px; height: 14px; cursor: pointer;">
        <img src="../images/an_auf_table/change_status.png" style="width: 18px; height: 18px; cursor: pointer;">
    </td>
</tr>';

    //     return
    //         '<tr>
    //             <td>' . $row['kunden_id'] . '</td>
    //             <td>' . $row['zeit'] . '</td>
    //             <td>' . $row['plz_start'] . '</td>
    //             <td>' . $row['plz_ziel'] . '</td>
    //             <td>' . $row['zeit_fenster'] . '</td>
    //             <td>' . $row['zustelltag'] . '</td>
    //             <td>' . $row['volumengewicht'] . '</td>
    //             <td>' . $row['service_leistung'] . '</td>
    //             <td>' . $row['kunden_name'] . '</td>
    //             <td>' . $row['email'] . '</td>
    //             <td>' . $row['telefon'] . '</td>
    //             <td>' . $row['kontakt_wunsch'] . '</td>
    //             <td style="text-align: center;">
    //                 <img id="action_nr_' . $row['id'] . '" style="cursor: pointer;" src="' . $action_img_url . '" 
    //                     data-toggle="tooltip"
    //                     data-placement="top"
    //                     title="' . $action_span_text . '">
    //             </td>
    //             <td>
    //                 <img id="eye_nr_' . $row['id'] . '" style="cursor: pointer;" src="' . $eye_img_url . '">
    //             </td>
    //             <script>
    //             // Part for completed.
    //                 jQuery("#eye_nr_' . $row['id'] . '").on("click", function() {
    //                     jQuery(this).prop("src","' . URL . "images/orange_eye.gif\"" . ');
    //                     jQuery.ajax({
    //                         type: "post",
    //                         data: {anfrage_id: ' . $row['id'] . '},
    //                         dataType: "json",
    //                         success: function() {
    //                         }

    //                     });
    //                 });
    //             // Part for auftraege.
    //                 let ist_auftrag_bool_' . $row['id'] . ' = ' . (!$row['ist_auftrag'] ? "0" : "1") . ';
    //                 jQuery("#action_nr_' . $row['id'] . '").on("click", function (){
    //                     if(!ist_auftrag_bool_' . $row['id'] . '){
    //                         // Ist noch kein auftrag.

    //                         jQuery("input[name=\'chk_ae_dg_abholadresse\']").show();
    //                         jQuery("label[for=\'chk_ae_dg_abholadresse\']").show();

    //                         var dialogAuftrag = jQuery("#dialog_auftrag").dialog({
    //                             resizable: true,
    //                             autoOpen: false,
    //                             height: "auto",
    //                             modal: true,
    //                             width: 800,
    //                             open: function() {
    //                                 let auftragData = jQuery(this).data("auftragData");
    //                                 console.log(auftragData);

    //                                 jQuery.ajax({
    //                                     type: "post",
    //                                     url: "' . URL . 'admin_content/get_client_data.php",
    //                                     data: {
    //                                         anfrage_id: auftragData["anfrage_id"]
    //                                     },
    //                                     dataType: "json",
    //                                     success: function(data) {
    //                                         jQuery("input[name=\'ae_dg_firmenname\']").val(data["firmenname"]);
    //                                         jQuery("select[name=\'ae_dg_anrede\']").val(data["anrede"]);
    //                                         jQuery("input[name=\'ae_dg_ansprechpartner\']").val(data["ansprechpartner"]);
    //                                         jQuery("input[name=\'ae_dg_email\']").val(data["email"]);
    //                                         jQuery("input[name=\'ae_dg_telefon\']").val(data["telefon"]);
    //                                         jQuery("input[name=\'ae_dg_strasse\']").val(data["strasse"]);
    //                                         jQuery("input[name=\'ae_dg_hausnummer\']").val(data["hausnummer"]);
    //                                         jQuery("input[name=\'ae_dg_plz\']").val(data["plz"]);
    //                                         jQuery("input[name=\'ae_dg_ort\']").val(data["ort"]);
    //                                         jQuery("input[name=\'ae_dg_land\']").val(data["land"]);
    //                                         jQuery("input[name=\'ae_dg_ztelefon\']").val(data["ztelefon"]);
    //                                         jQuery("input[name=\'ae_dg_freitext\']").val(data["freitext"]);
    //                                         console.log(data);
    //                                     }
    //                                 });
    //                             },
    //                             buttons: {
    //                                 "Auftrag erstellen": function() {
    //                                     let auftragData = jQuery(this).data("auftragData");

    //                                     let formdata = jQuery("form#dg_auftrag_erstellen").serializeArray();
    //                                     formdata.push({name: "anfrage_id", value: ' . $row['id'] . '});

    //                                     if(jQuery("#chk_ae_dg_abholadresse:checked").length) {
    //                                         if(!jQuery("#ae_dg_abholadresse").val()){
    //                                             $(".toast .toast-body").html("Abholadresse darf nicht leer sein.");
    //                                             $(".toast").toast("show");
    //                                             return;
    //                                         }
    //                                     }

    //                                     jQuery.ajax({
    //                                         type: "post",
    //                                         url: "' . URL . 'admin_content/create_auftrag.php",
    //                                         data: formdata,
    //                                         dataType: "json",
    //                                         success: function(data) {
    //                                             console.log(data);
    //                                             $(".toast .toast-body").html("Auftrag erfolgreich erstellt.");
    //                                             $(".toast").toast("show");
    //                                             $("#ae_dg_abholadresse").hide();
    //                                             $("label[for=\"ae_dg_abholadresse\"]").hide();
    //                                             $("#ae_dg_abholadresse").removeAttr("required");

    //                                             ist_auftrag_bool_' . $row['id'] . ' = 1;

    //                                             jQuery("#eye_nr_' . $row['id'] . '").click();

    //                                             jQuery("#action_nr_' . $row['id'] . '").prop("src", "' . $action_img_auftrag . '");
    //                                         }

    //                                     });
    //                                     jQuery("#chk_ae_dg_abholadresse").prop("checked", false);
    //                                     jQuery("#ae_dg_abholadresse").val("");
    //                                     jQuery("input[name=\'ae_dg_abholadresse\']").hide();
    //                                     jQuery("label[for=\'ae_dg_abholadresse\']").hide();



    //                                     jQuery(this).dialog("close");
    //                                 },
    //                                 "Abbrechen": function() {
    //                                     jQuery(this).dialog("close");
    //                                 }
    //                             }
    //                         });

    //                         let auftragData = {
    //                             anfrage_id: ' . $row['id'] . '
    //                         };

    //                         dialogAuftrag.data("auftragData", auftragData).dialog("open");
    //                     }else {
    //                         // Ist schon auftrag.

    //                         jQuery("input[name=\'chk_ae_dg_abholadresse\']").hide();
    //                         jQuery("label[for=\'chk_ae_dg_abholadresse\']").hide();

    //                         var dialogAuftrag = jQuery("#dialog_auftrag").dialog({
    //                             resizable: true,
    //                             autoOpen: false,
    //                             height: "auto",
    //                             modal: true,
    //                             width: 800,
    //                             open: function() {
    //                                 let auftragData = jQuery(this).data("auftragData");
    //                                 console.log(auftragData);

    //                                 jQuery.ajax({
    //                                     type: "post",
    //                                     url: "' . URL . 'admin_content/get_client_data.php",
    //                                     data: {
    //                                         anfrage_id: auftragData["anfrage_id"]
    //                                     },
    //                                     dataType: "json",
    //                                     success: function(data) {
    //                                         jQuery("input[name=\'ae_dg_firmenname\']").val(data["firmenname"]);
    //                                         jQuery("select[name=\'ae_dg_anrede\']").val(data["anrede"]);
    //                                         jQuery("input[name=\'ae_dg_ansprechpartner\']").val(data["ansprechpartner"]);
    //                                         jQuery("input[name=\'ae_dg_email\']").val(data["email"]);
    //                                         jQuery("input[name=\'ae_dg_telefon\']").val(data["telefon"]);
    //                                         jQuery("input[name=\'ae_dg_strasse\']").val(data["strasse"]);
    //                                         jQuery("input[name=\'ae_dg_hausnummer\']").val(data["hausnummer"]);
    //                                         jQuery("input[name=\'ae_dg_plz\']").val(data["plz"]);
    //                                         jQuery("input[name=\'ae_dg_ort\']").val(data["ort"]);
    //                                         jQuery("input[name=\'ae_dg_land\']").val(data["land"]);
    //                                         jQuery("input[name=\'ae_dg_ztelefon\']").val(data["ztelefon"]);
    //                                         jQuery("input[name=\'ae_dg_freitext\']").val(data["freitext"]);
    //                                         console.log(data);
    //                                     }
    //                                 });
    //                             },
    //                             buttons: {
    //                                 "Schließen": function() {
    //                                     jQuery(this).dialog("close");
    //                                 }
    //                             }
    //                         });

    //                         let auftragData = {
    //                             anfrage_id: ' . $row['id'] . '
    //                         };

    //                         dialogAuftrag.data("auftragData", auftragData).dialog("open");

    //                     }
    //                 });
    //             </script>
    //         </tr>';
}

function auftraege_table($row)
{
    return '<tr>
    <td>
    <span>&nbsp;<img src="../images/an_auf_table/firmen_details.png">&nbsp;' . $row['kunden_name'] . '</span></td>
    <td>' . date_format(date_create($row['zeit']), "d/m/Y") . '</td>
    <td>' . $row['plz_start'] . '</td>
    <td>' . $row['plz_ziel'] . '</td>
    <td>' . $row['completed'] . '</td>
    <td>
        <img src="../images/an_auf_table/eye.png">
        <img src="../images/an_auf_table/change_status.png">
    </td>
</tr>';

    $status = $row['status'];
    $other_status = '';

    if ($status == 'offen') {
        $other_status = 'abgeschlossen';
    } else {
        $other_status = 'offen';
    }

    return '<tr>
                <td>            
                    ' . ($status != "abgeschlossen" ? '
                            <select id="auftrag_status_' . $row['id'] . '">
                                <option selected>' . $status . '</option>
                                <option>' . $other_status . '</option>
                            </select>
                            <br>
                            <br>' : '
                            <button type="button" id=\'auftrag_btn_' . $row['id'] . '\'
                            class=\'btn btn-primary\'>Rechnung erstellen</button>
                            ') . '
                        <button type="button" style="display: none;" id=\'auftrag_btn_' . $row['id'] . '\'
                            class=\'btn btn-primary\'>Rechnung erstellen</button>
                    
                </td>
                <td>' . $row['kunden_id'] . '</td>
                <td>' . $row['firmenname'] . '</td>
                <td>' . $row['anrede'] . '</td>
                <td>' . $row['ansprechpartner'] . '</td>
                <td>' . $row['email'] . '</td>
                <td>' . $row['telefon'] . '</td>
                <td>' . $row['strasse'] . '</td>
                <td>' . $row['hausnummer'] . '</td>
                <td>' . $row['plz'] . '</td>
                <td>' . $row['ort'] . '</td>
                <td>' . $row['land'] . '</td>
                <td>' . $row['telefon_zentrale'] . '</td>
                <td>' . $row['freitext'] . '</td>
                <td>' . $row['abholadresse'] . '</td>
                <td>' . $row['tracking_nummer'] . '</td>
            </tr>
            
            <script>
                jQuery("#auftrag_status_' . $row['id'] . '").on("change", function(){
                    if(jQuery(this).val() == "abgeschlossen") {
                        jQuery("#auftrag_btn_' . $row['id'] . '").show();
                        jQuery("#auftrag_status_' . $row['id'] . '").remove();
                        // Update the auftrag status to abgeschlossen.
                        
                        jQuery.ajax({
                            type: "post",
                            url: "' . URL . 'admin_content/ajax/update_auftrag_status.php",
                            data: {auftrag_id: ' . $row['id'] . '},
                            dataType: "json",
                            success: function(data) {
                                console.log(data);
                                console.log("Status update to abgeschlossen");
                            }
                        });
                    }
                });          
            </script>
            ';
}
