<?php
require_once dirname(__FILE__) . '/../../definitions.php';
require_once dirname(__FILE__) . '/../../config.php';
require_once dirname(__FILE__) . '/constants/countries.const.php';


function anfragen_table($row)
{
    global $countries_code;

    switch ($row['status']) {
        case "offen":
            $row['status'] = '<span style="color: red;">' . $row['status'] . '</span>';
            break;
        case "ausstehend":
            $row['status'] = '<span style="color: orange;">' . $row['status'] . '</span>';
            break;
        case "abgelehnt":
            $row['status'] = '<span style="color: purple;">' . $row['status'] . '</span>';
            break;
        case "beauftragt":
            $row['status'] = '<span style="color: green;">' . $row['status'] . '</span>';
            break;
    }

    $client = get_client_by_id($row['kunden_id']);

    return '<tr>
    <td>
    <span>&nbsp;<img src="../images/an_auf_table/firmen_details.png">&nbsp;' . $client['firmenname'] . '</span></td>
    <td>' . date_format(date_create($row['zeit']), "d/m/Y") . '</td>
    <td>' . $countries_code[$row['land_start']] . ' ' . $row['plz_start'] . '</td>
    <td>' . $countries_code[$row['land_ziel']] . ' ' . $row['plz_ziel'] . '</td>
    <td>' . $row['status'] . '</td>
    <td>
        <inquiry_detail :id="' . $row['id'] . '"></inquiry_detail>
    </td>
</tr>';
}

function order_row($row)
{
    global $countries_code;

    $statusColor = '';
    switch ($row['status']) {
        case "offen":
            $statusColor = 'red';
            break;
        case "ausstehend":
            $statusColor = 'orange';
            break;
        case "abgelehnt":
            $statusColor = 'purple';
            break;
        case "beauftragt":
            $statusColor = 'green';
            break;
    }

    $client = get_client_by_id($row['kunden_id']);
    $abholadresse = get_pickup_address_by_id($row['abholadresse_id']);
    $lieferadresse = get_delivery_address_by_id($row['lieferadresse_id']);

    $clientData = array();
    $clientData['companyName'] = $client['firmenname'];
    $clientData['companyStreet'] = strval($client['strasse'])  . ' ' . strval($client['hausnummer']);
    $clientData['companyAddress'] = strval($client['plz']) . ' ' . strval($client['ort']);
    $clientData['clientNumber'] = $client['id'];

    $row['companyName'] = $client['firmenname'];
    $row['clientData'] = $clientData;
    $row['createdAt'] = date_format(date_create($row['zeit']), "d/m/Y");
    $row['pickupPLZ'] = $abholadresse['plz'];
    $row['pickupCountry'] = $countries_code[$abholadresse['land']];
    $row['deliveryPLZ'] = $lieferadresse['plz'];
    $row['deliveryCountry'] = $countries_code[$lieferadresse['land']];
    $row['statusValue'] = $row['status'];
    $row['statusColor'] = $statusColor;

    return $row;
}

function auftraege_table_detailed($row)
{
    global $countries_code;
    
    switch ($row['status']) {
        case "offen":
            $row['status'] = '<span style="color: red;">' . $row['status'] . '</span>';
            break;
        case "ausstehend":
            $row['status'] = '<span style="color: orange;">' . $row['status'] . '</span>';
            break;
        case "abgelehnt":
            $row['status'] = '<span style="color: purple;">' . $row['status'] . '</span>';
            break;
        case "beauftragt":
            $row['status'] = '<span style="color: green;">' . $row['status'] . '</span>';
            break;
    }

    $client = get_client_by_id($row['kunden_id']);
    $abholadresse = get_pickup_address_by_id($row['abholadresse_id']);
    $lieferadresse = get_delivery_address_by_id($row['lieferadresse_id']);

    return '<tr>
    <td>' . $row['id'] . '</td>
    <td>
    <span>&nbsp;<img src="../images/an_auf_table/firmen_details.png">&nbsp;' . $client['firmenname'] . '</span></td>
    <td>' . $client['ansprechpartner'] . '</td>
    <td>' . $client['telefon'] . '</td>
    <td>' . date_format(date_create($row['zeit']), "d/m/Y") . '</td>
    <td>' . $countries_code[$abholadresse['land']] . ' ' . $abholadresse['plz'] . '</td>
    <td>' . $countries_code[$lieferadresse['land']] . ' ' . $lieferadresse['plz'] . '</td>
    <td>' . $row['status'] . '</td>
    <td>
        <order_detail :id="' . $row['id'] . '"></order_detail>
    </td>
</tr>';
}
function get_client_by_id($clientId)
{
    global $mysqli;
    $sql = "SELECT * FROM kunden WHERE id = " . $clientId;

    if ($stmt = $mysqli->prepare($sql)) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($clientData = $result->fetch_assoc()) {
                return $clientData;
            }
        } else return -1;
    } else return -1;
}

function get_pickup_address_by_id($id)
{
    global $mysqli;

    $sql = "SELECT * FROM abholadresse WHERE id = " . $id;

    if ($stmt = $mysqli->prepare($sql)) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($data = $result->fetch_assoc()) {
                return $data;
            }
        } else return -1;
    } else return -1;
}

function get_delivery_address_by_id($id)
{
    global $mysqli;

    $sql = "SELECT * FROM lieferadresse WHERE id = " . $id;

    if ($stmt = $mysqli->prepare($sql)) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($data = $result->fetch_assoc()) {
                return $data;
            }
        } else return -1;
    } else return -1;
}
