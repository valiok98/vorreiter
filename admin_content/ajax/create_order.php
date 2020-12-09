<?php
require_once dirname(__FILE__) . '/../../config.php';
require_once dirname(__FILE__) . '/../../definitions.php';

$success_msg = '';
$error_msg = '';

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {
    global $success_msg;

    $postData = json_decode(file_get_contents('php://input'), true);
    create_order($mysqli, $postData);
    echo json_encode(array("success" => true, "msg" => $success_msg));
}

/**
 * Create the order and the packages that belong to it.
 */
function create_order($mysqli, $data)
{


    $sql = "INSERT INTO auftraege
        (
        zeit_fenster,
        zustelltag,
        volumengewicht,
        tracking_nummer,
        kunden_id,
        abholadresse_id,
        lieferadresse_id) VALUES (?, ?, ?, ?,?, ?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {


        $abholadresse = $data['fromAddress'];
        $lieferadresse = $data['toAddress'];
        // Get the client data.
        $clientData = get_client_by_id($mysqli, intval($data['clientId']));

        if (count($abholadresse['sameAddress'])) {
            $abholadresse['companyName'] = $clientData['firmenname'];
            $abholadresse['salutation'] = $clientData['anrede'];
            $abholadresse['personalTitle'] = $clientData['anrede'];;
            $abholadresse['firstName'] = $clientData['username'];
            $abholadresse['lastName'] = $clientData['username'];
            $abholadresse['phone'] = $clientData['telefon'];
            $abholadresse['email'] = $clientData['email'];
            $abholadresse['street'] = $clientData['strasse'];
            $abholadresse['houseNumber'] = $clientData['hausnummer'];
            $abholadresse['postCode'] = $clientData['plz'];
            $abholadresse['place'] = $clientData['ort'];
            $abholadresse['country'] = $clientData['land'];
        }

        if (count($lieferadresse['sameAddress'])) {
            $lieferadresse['companyName'] = $clientData['firmenname'];
            $lieferadresse['salutation'] = $clientData['anrede'];
            $lieferadresse['personalTitle'] = $clientData['anrede'];;
            $lieferadresse['firstName'] = $clientData['username'];
            $lieferadresse['lastName'] = $clientData['username'];
            $lieferadresse['phone'] = $clientData['telefon'];
            $lieferadresse['email'] = $clientData['email'];
            $lieferadresse['street'] = $clientData['strasse'];
            $lieferadresse['houseNumber'] = $clientData['hausnummer'];
            $lieferadresse['postCode'] = $clientData['plz'];
            $lieferadresse['place'] = $clientData['ort'];
            $lieferadresse['country'] = $clientData['land'];
        }


        $abholadresse_id = create_pickup_address($mysqli, $abholadresse);
        $lieferadresse_id = create_delivery_address($mysqli, $lieferadresse);
        $tracking_number = rand(100000000, 999999999);

        $stmt->bind_param(
            "ssiiiii",
            $data['deliveryTime'],
            $data['deliveryDay'],
            intval($data['volumeWeight']),
            intval($tracking_number),
            intval($data['clientId']),
            $abholadresse_id,
            $lieferadresse_id
        );

        global $error_msg;

        if ($stmt->execute() && $error_msg === '') {
            global $success_msg;
            if (create_packets($mysqli, $data, $mysqli->insert_id)) {
                $success_msg = "Auftrag erstellt.\n";
            } else {
                set_failure("Die Pakete konnten nicht erstellt werden.\n");
            }
        } else {
            set_failure($stmt->error);
        }

        $stmt->close();
    } else {
        set_failure($mysqli->error);
    }
}
/**
 * Create the pickup address belonging to the order.
 */
function create_pickup_address($mysqli, $abholadresse)
{
    $sql = "INSERT INTO abholadresse
        (
        firmenname,
        anrede,
        titel,
        vorname,
        nachname,
        telefon,
        email,
        strasse,
        hausnummer,
        plz,
        ort,
        land
        ) VALUES (?, ?, ?, ?,     ?, ?, ?, ?,   ?, ?, ?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param(
            "ssssssssiiss",
            $abholadresse['companyName'],
            $abholadresse['salutation'],
            $abholadresse['personalTitle'],
            $abholadresse['firstName'],
            $abholadresse['lastName'],
            $abholadresse['phone'],
            $abholadresse['email'],
            $abholadresse['street'],
            intval($abholadresse['houseNumber']),
            intval($abholadresse['postCode']),
            $abholadresse['place'],
            $abholadresse['country']
        );

        if ($stmt->execute()) {
            global $success_msg;
            $success_msg = 'Abholadresse erstellt.\n';
            return $mysqli->insert_id;
        } else {

            set_failure($stmt->error);
        }

        $stmt->close();
    } else {

        set_failure($mysqli->error);
    }
}
/**
 * Create the delivery address belonging to the order.
 */
function create_delivery_address($mysqli, $lieferadresse)
{
    $sql = "INSERT INTO lieferadresse
        (
        firmenname,
        anrede,
        titel,
        vorname,
        nachname,
        telefon,
        email,
        strasse,
        hausnummer,
        plz,
        ort,
        land
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {

        $stmt->bind_param(
            "ssssssssiiss",
            $lieferadresse['companyName'],
            $lieferadresse['salutation'],
            $lieferadresse['personalTitle'],
            $lieferadresse['firstName'],
            $lieferadresse['lastName'],
            $lieferadresse['phone'],
            $lieferadresse['email'],
            $lieferadresse['street'],
            $lieferadresse['houseNumber'],
            $lieferadresse['postCode'],
            $lieferadresse['place'],
            $lieferadresse['country']
        );

        if ($stmt->execute()) {
            global $success_msg;
            $success_msg = 'Lieferadresse erstellt.\n';
            return $mysqli->insert_id;
        } else {

            set_failure($stmt->error);
        }

        $stmt->close();
    } else {

        set_failure($mysqli->error);
    }
}
/**
 * Create the packages belonging to the inquiry.
 */
function create_packets($mysqli, $data, $auftragId)
{
    $pakete = $data['packages'];

    // set_failure(json_encode($pakete));

    foreach ($pakete as $paket) {
        $sql = "INSERT INTO pakete
    (laenge,
    breite,
    hoehe,
    volumengewicht,
    gewicht,
    service_leistungen,
    preis,
    auftrag_id)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param(
                "iiiiisdi",
                intval($paket['sizeX']),
                intval($paket['sizeY']),
                intval($paket['sizeZ']),
                intval($paket['volumeWeight']),
                intval($paket['weight']),
                json_encode($paket['services']),
                doubleval($paket['price']),
                $auftragId
            );

            if (!$stmt->execute()) {
                return false;
            }
            $stmt->close();
        } else {
            return false;
        }
    }
    return true;
}

/**
 * Function that handles failure.
 */
function set_failure($msg)
{
    global $success_msg;
    global $error_msg;
    $success_msg = '';
    $error_msg = $msg;
    echo json_encode(array("success" => false, "msg" => $error_msg));
    die;
}

function get_client_by_id($mysqli, $clientId)
{
    $sql = "SELECT * FROM kunden WHERE id = " . $clientId;

    if ($stmt = $mysqli->prepare($sql)) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($clientData = $result->fetch_assoc()) {
                return $clientData;
            }
        } else echo json_encode(array("success" => false));
    } else echo json_encode(array("success" => false));
}
