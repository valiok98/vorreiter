<?php
require_once dirname(__FILE__) . '/../../config.php';
require_once dirname(__FILE__) . '/../../definitions.php';

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {

    create_inquiry($mysqli, $_POST);
}

/**
 * Create the inquiry and the packages that belong to it.
 */
function create_inquiry($mysqli, $data)
{

    $clientId = create_dummy_client($mysqli);

    if ($clientId) {

        $sql = "INSERT INTO anfragen
        (plz_start,
        plz_ziel,
        
        zeit_fenster,
        zustelltag,

        kunden_id,
        kontakt_wunsch) 
        VALUES (?, ?,  ?, ?,  ? ,'phone')";

        if ($stmt = $mysqli->prepare($sql)) {


            $stmt->bind_param(
                "iissi",
                intval($data['plzStart']),
                intval($data['plzEnd']),
                $data['deliveryTime'],
                $data['deliveryDay'],
                intval($clientId)
            );

            if ($stmt->execute()) {
                if (create_packets($mysqli, $data, $mysqli->insert_id)) {
                    return true;
                } else return false;
            } else return false;

            $stmt->close();
        } else return false;
    }
}
/**
 * Create the packages belonging to the inquiry.
 */
function create_packets($mysqli, $data, $anfrageId)
{
    $pakete = $data['packages'];

    foreach ($pakete as $paket) {

        $services = '[]';
        if ($paket['services']) {
            $services = json_encode($paket['services']);
        }

        $sql = "INSERT INTO pakete
    (laenge,
    breite,
    hoehe,
    volumengewicht,
    gewicht,
    service_leistungen,
    preis,
    anfrage_id)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param(
                "iiiiisdi",
                intval($paket['sizeX']),
                intval($paket['sizeY']),
                intval($paket['sizeZ']),
                intval($paket['volumeWeight']),
                intval($paket['weight']),
                $services,
                doubleval($paket['price']),
                $anfrageId
            );

            if (!$stmt->execute()) {
                return false;
            }
            $stmt->close();
        } else return false;
    }
    return true;
}


function create_dummy_client($mysqli)
{

    $username = gen_random_username($mysqli);
    $email = $username . "@" . $username . ".com";

    // Prepare an insert statement
    $sql = "INSERT INTO kunden (firmenname,
     anrede,
     email,
     telefon,
     strasse,
     hausnummer,
     plz,
     vorname,
     nachname,
     titel,
     fax,
     mobil,
     kuerzel,
     ort,
     land, telefon_zentrale, freitext, username, password)
     VALUES ('TBD', 'TBD', ?, 'TBD', 'TBD', 0, 0, 'TBD', 'TBD', 'TBD', 'TBD', 'TBD', 'TBD', 'TBD', 'TBD', 'TBD', 'TBD', ?, 'TBD')";

    if ($stmt = $mysqli->prepare($sql)) {
        // Attempt to execute the prepared statement

        $stmt->bind_param(
            "ss",
            $email,
            $username
        );
        if ($stmt->execute()) {
            $clientId = $mysqli->insert_id;
            return $clientId;
        } else return false;

        // Close statement
        $stmt->close();
    }

    return false;
}



function gen_random_string($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function gen_random_username($mysqli)
{
    $username = '';

    do {
        $username = gen_random_string(6);
        $username_invalid = true;

        $sql = "SELECT id FROM kunden WHERE username = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param(
                "s",
                $mysqli->real_escape_string($username)
            );

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 0) {
                    $username_invalid = false;
                }
            }
        }
    } while ($username_invalid);

    return $username;
}
