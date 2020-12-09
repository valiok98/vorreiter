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
    create_inquiry($mysqli, $postData);
    echo json_encode(array("success" => true, "msg" => $success_msg));
}

/**
 * Create the inquiry and the packages that belong to it.
 */
function create_inquiry($mysqli, $data)
{

    $sql = "INSERT INTO anfragen
        (plz_start,
        plz_ziel,
        zeit_fenster,
        zustelltag,
        volumengewicht,
        kunden_id,
        kontakt_wunsch) 
        VALUES (?, ?, ?, ?, ? ,? ,'phone')";

    if ($stmt = $mysqli->prepare($sql)) {

        $stmt->bind_param(
            "iissii",
            $mysqli->real_escape_string(intval($data['plzStart'])),
            $mysqli->real_escape_string(intval($data['plzEnd'])),
            $mysqli->real_escape_string($data['deliveryTime']),
            $mysqli->real_escape_string($data['deliveryDay']),
            $mysqli->real_escape_string(intval($data['volumeWeight'])),
            $mysqli->real_escape_string(intval($data['clientId']))
        );

        global $error_msg;

        if ($stmt->execute() && $error_msg === '') {
            global $success_msg;
            if (create_packets($mysqli, $data, $mysqli->insert_id)) {
                $success_msg .= "Anfrage erstellt.\n";
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
 * Create the packages belonging to the inquiry.
 */
function create_packets($mysqli, $data, $anfrageId)
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
    gurtmass,
    service_leistungen,
    preis,
    anfrage_id)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param(
                "iiiiiisdi",
                $mysqli->real_escape_string(intval($paket['sizeX'])),
                $mysqli->real_escape_string(intval($paket['sizeY'])),
                $mysqli->real_escape_string(intval($paket['sizeZ'])),
                $mysqli->real_escape_string(intval($paket['volumeWeight'])),
                $mysqli->real_escape_string(intval($paket['weight'])),
                $mysqli->real_escape_string(intval($paket['girth'])),
                $mysqli->real_escape_string(json_encode($paket['services'])),
                $mysqli->real_escape_string(doubleval($paket['price'])),
                $mysqli->real_escape_string($anfrageId)
            );

            if (!$stmt->execute()) {
                return false;
            }
            $stmt->close();
        } else return false;
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
