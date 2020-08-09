<?php
require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../definitions.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['anfrage_id']) && !empty($_POST['anfrage_id'])) {
    $anfrage_id = $_POST['anfrage_id'];
    $kundenid = get_client_id($anfrage_id);
    $kundendata = get_client_data($kundenid);
    echo json_encode($kundendata);
}

function get_client_id($anfrage_id)
{
    global $mysqli;
    $kundenid = '';
    $sql = "SELECT kunden_id FROM anfragen WHERE id = ?";

    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $anfrage_id);
        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($kundenid);
                if (!$stmt->fetch()) {
                    $stmt->close();
                    echo json_encode(array("success" => false, "msg" => "Fehler beim KundenID der Anfrage."));
                    die;
                }
            }
        }
        $stmt->close();
    }

    return $kundenid;
}

function get_client_data($kundenid)
{
    global $mysqli;

    // Fetch the client's information.
    $firmenname = '';
    $anrede = '';
    $ansprechpartner = '';
    $email = '';
    $telefon = '';
    $strasse = '';
    $hausnummer = '';
    $plz = '';
    $ort = '';
    $land = '';
    $telefon_zentrale = '';
    $freitext = '';

    $sql = "SELECT firmenname, anrede, ansprechpartner, email, telefon, strasse,
        hausnummer, plz, ort, land, telefon_zentrale, freitext
        FROM kunden WHERE id = ?";

    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $kundenid);
        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result(
                    $firmenname,
                    $anrede,
                    $ansprechpartner,
                    $email,
                    $telefon,
                    $strasse,
                    $hausnummer,
                    $plz,
                    $ort,
                    $land,
                    $telefon_zentrale,
                    $freitext
                );
                if (!$stmt->fetch()) {
                    $stmt->close();
                    echo json_encode(array("success" => false, "msg" => "Fehler beim Zugriff auf den Kunden."));
                    die;
                }
            } else {
                echo json_encode(array("success" => false, "msg" => "Fehler beim Zugriff auf den Kunden."));
                die;
            }
        }
        $stmt->close();
    }
    // Save the fetched information in an auftrag.

    return [
        "firmenname" =>     $firmenname,
        "anrede" =>     $anrede,
        "ansprechpartner" =>     $ansprechpartner,
        "email" =>     $email,
        "telefon" =>     $telefon,
        "strasse" =>     $strasse,
        "hausnummer" =>     $hausnummer,
        "plz" =>     $plz,
        "ort" =>     $ort,
        "land" =>     $land,
        "telefon_zentrale" =>     $telefon_zentrale,
        "freitext" =>     $freitext
    ];
}