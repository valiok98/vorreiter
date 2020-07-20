<?php
require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../definitions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['anfrage_id'])) {
        save_auftrag_with_anfrage($_POST);
    } else {
        save_auftrag_without_anfrage($_POST);
    }
    die;
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

// function get_client_data($kundenid)
// {
//     global $mysqli;

//     // Fetch the client's information.
//     $firmenname = '';
//     $anrede = '';
//     $ansprechpartner = '';
//     $email = '';
//     $telefon = '';
//     $strasse = '';
//     $hausnummer = '';
//     $plz = '';
//     $ort = '';
//     $land = '';
//     $telefon_zentrale = '';
//     $freitext = '';

//     $sql = "SELECT firmenname, anrede, ansprechpartner, email, telefon, strasse,
//         hausnummer, plz, ort, land, telefon_zentrale, freitext
//         FROM kunden WHERE id = ?";

//     if ($stmt = $mysqli->prepare($sql)) {
//         $stmt->bind_param("i", $kundenid);
//         if ($stmt->execute()) {
//             $stmt->store_result();
//             if ($stmt->num_rows == 1) {
//                 $stmt->bind_result(
//                     $firmenname,
//                     $anrede,
//                     $ansprechpartner,
//                     $email,
//                     $telefon,
//                     $strasse,
//                     $hausnummer,
//                     $plz,
//                     $ort,
//                     $land,
//                     $telefon_zentrale,
//                     $freitext
//                 );
//                 if (!$stmt->fetch()) {
//                     $stmt->close();
//                     echo json_encode(array("success" => false, "msg" => "Fehler beim Zugriff auf den Kunden."));
//                     die;
//                 }
//             } else {
//                 echo json_encode(array("success" => false, "msg" => "Fehler beim Zugriff auf den Kunden."));
//                 die;
//             }
//         }
//         $stmt->close();
//     }
//     // Save the fetched information in an auftrag.

//     return [
//         "firmenname" =>     $firmenname,
//         "anrede" =>     $anrede,
//         "ansprechpartner" =>     $ansprechpartner,
//         "email" =>     $email,
//         "telefon" =>     $telefon,
//         "strasse" =>     $strasse,
//         "hausnummer" =>     $hausnummer,
//         "plz" =>     $plz,
//         "ort" =>     $ort,
//         "land" =>     $land,
//         "telefon_zentrale" =>     $telefon_zentrale,
//         "freitext" =>     $freitext
//     ];
// }

function save_auftrag_with_anfrage($kundendata)
{
    global $mysqli;
    // Save the fetched information in an auftrag.

    $firmenname = $kundendata["ae_dg_firmenname"];
    $anrede = $kundendata["ae_dg_anrede"];
    $ansprechpartner = $kundendata["ae_dg_ansprechpartner"];
    $email = $kundendata["ae_dg_email"];
    $telefon = $kundendata["ae_dg_telefon"];
    $strasse = $kundendata["ae_dg_strasse"];
    $hausnummer = $kundendata["ae_dg_hausnummer"];
    $plz = $kundendata["ae_dg_plz"];
    $ort = $kundendata["ae_dg_ort"];
    $land = $kundendata["ae_dg_land"];
    $telefon_zentrale = $kundendata["ae_dg_telefon_zentrale"];
    $freitext = $kundendata["ae_dg_freitext"];
    $anfrage_id = intval($kundendata["anfrage_id"]);

    $kundenid = get_client_id($anfrage_id);

    $ist_auftrag = false;

    $sql = "SELECT ist_auftrag FROM anfragen WHERE id = ?";

    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $anfrage_id);
        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($ist_auftrag);
                if ($stmt->fetch()) {
                    if ($ist_auftrag) {
                        $stmt->close();
                        // Error, the anfrage is already an auftrag.
                        echo json_encode(array("success" => false, "msg" => "Die Anfrage ist schon ein Auftrag."));
                        die;
                    } else {
                        // Update the status of the anfrage.
                        $sql = "UPDATE anfragen SET ist_auftrag = 1 WHERE id = ?";
                        if ($stmt = $mysqli->prepare($sql)) {
                            $stmt->bind_param("i", $anfrage_id);
                            if ($stmt->execute()) {
                                $stmt->close();
                            }
                        }
                    }
                }
            }
        }
    } else {
        echo json_encode(array("success" => false, "msg" => "MySQL Fehler."));
        die;
    }

    $tracking_number = rand(100000000, 999999999);
    $abholadresse = '';
    if (isset($kundendata['ae_dg_abholadresse'])) {
        $abholadresse = trim($kundendata['ae_dg_abholadresse']);
    } else {
        $abholadresse = $land . ', ' . $ort . ',' . $plz . ', ' . $strasse . ', ' . $hausnummer;
    }


    $sql = "INSERT INTO auftraege(firmenname,
     anrede, ansprechpartner, email, telefon, strasse, hausnummer, plz,
      ort, land, telefon_zentrale, freitext, abholadresse, tracking_nummer, kunden_id)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param(
            "ssssssiisssssii",
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
            $freitext,
            $abholadresse,
            $tracking_number,
            $kundenid
        );

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            echo json_encode(array("success" => true));
            die;
        } else {
            echo json_encode(array("success" => false, "msg" => "Fehler beim Zugriff auf den Kunden."));
            die;
        }
        $stmt->close();
    } else {

        echo json_encode(array("success" => false, "msg" => $mysqli->error));
        die;
    }
}

function save_auftrag_without_anfrage($kundendata)
{
    global $mysqli;
    // Save the fetched information in an auftrag.

    $firmenname = $kundendata["ae_firmenname"];
    $anrede = $kundendata["ae_anrede"];
    $ansprechpartner = $kundendata["ae_ansprechpartner"];
    $email = $kundendata["ae_email"];
    $telefon = $kundendata["ae_telefon"];
    $strasse = $kundendata["ae_strasse"];
    $hausnummer = $kundendata["ae_hausnummer"];
    $plz = $kundendata["ae_plz"];
    $ort = $kundendata["ae_ort"];
    $land = $kundendata["ae_land"];
    $telefon_zentrale = $kundendata["ae_telefon_zentrale"];
    $freitext = $kundendata["ae_freitext"];
    $kundenid = $kundendata["ae_kundenid"];

    $tracking_number = rand(100000000, 999999999);

    $abholadresse = '';
    if (isset($kundendata['ae_abholadresse'])) {
        $abholadresse = trim($kundendata['ae_abholadresse']);
    } else {
        $abholadresse = $land . ', ' . $ort . ',' . $plz . ', ' . $strasse . ', ' . $hausnummer;
    }


    $sql = "INSERT INTO auftraege(firmenname,
     anrede, ansprechpartner, email, telefon, strasse, hausnummer, plz,
      ort, land, telefon_zentrale, freitext, abholadresse, tracking_nummer, kunden_id)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param(
            "ssssssiisssssii",
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
            $freitext,
            $abholadresse,
            $tracking_number,
            $kundenid
        );

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            echo json_encode(array("success" => true));
            die;
        } else {
            echo json_encode(array("success" => false, "msg" => "Fehler beim Zugriff auf den Kunden."));
            die;
        }
        $stmt->close();
    } else {

        echo json_encode(array("success" => false, "msg" => $mysqli->error));
        die;
    }
}

// function create_auftrag($anfrage_id)
// {   


//     global $mysqli;
//     $kundenid = '';
//     $sql = "SELECT kundenid FROM anfragen WHERE id = ?";

//     if ($stmt = $mysqli->prepare($sql)) {
//         $stmt->bind_param("i", $anfrage_id);
//         if ($stmt->execute()) {
//             $stmt->store_result();
//             if ($stmt->num_rows == 1) {
//                 $stmt->bind_result($kundenid);
//                 if (!$stmt->fetch()) {
//                     $stmt->close();
//                     echo json_encode(array("success" => false, "msg" => "Fehler beim KundenID der Anfrage."));
//                     die;
//                 }
//             }
//         }
//         $stmt->close();
//     }


//     // Fetch the client's information.
//     $firmenname = '';
//     $anrede = '';
//     $ansprechpartner = '';
//     $email = '';
//     $telefon = '';
//     $strasse = '';
//     $hausnummer = '';
//     $plz = '';
//     $ort = '';
//     $land = '';
//     $telefon_zentrale = '';
//     $freitext = '';

//     $sql = "SELECT firmenname, anrede, ansprechpartner, email, telefon, strasse,
//         hausnummer, plz, ort, land, telefon_zentrale, freitext
//         FROM kunden WHERE id = ?";

//     if ($stmt = $mysqli->prepare($sql)) {
//         $stmt->bind_param("i", $kundenid);
//         if ($stmt->execute()) {
//             $stmt->store_result();
//             if ($stmt->num_rows == 1) {
//                 $stmt->bind_result(
//                     $firmenname,
//                     $anrede,
//                     $ansprechpartner,
//                     $email,
//                     $telefon,
//                     $strasse,
//                     $hausnummer,
//                     $plz,
//                     $ort,
//                     $land,
//                     $telefon_zentrale,
//                     $freitext
//                 );
//                 if (!$stmt->fetch()) {
//                     $stmt->close();
//                     echo json_encode(array("success" => false, "msg" => "Fehler beim Zugriff auf den Kunden."));
//                     die;
//                 }
//             } else {
//                 echo json_encode(array("success" => false, "msg" => "Fehler beim Zugriff auf den Kunden."));
//                 die;
//             }
//         }
//         $stmt->close();
//     }
//     // Save the fetched information in an auftrag.

//     $tracking_number = rand(100000000, 999999999);
//     $abholadresse = $land . ', ' . $ort . ',' . $plz . ', ' . $strasse . ', ' . $hausnummer;

//     $sql = "INSERT INTO auftraege(firmenname,
//      anrede, ansprechpartner, email, telefon, strasse, hausnummer, plz,
//       ort, land, telefon_zentrale, freitext, abholadresse, tracking_nummer, kunden_id)
//     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

//     if ($stmt = $mysqli->prepare($sql)) {
//         // Bind variables to the prepared statement as parameters
//         $stmt->bind_param(
//             "ssssssiisssssii",
//             $firmenname,
//             $anrede,
//             $ansprechpartner,
//             $email,
//             $telefon,
//             $strasse,
//             $hausnummer,
//             $plz,
//             $ort,
//             $land,
//             $telefon_zentrale,
//             $freitext,
//             $abholadresse,
//             $tracking_number,
//             $kundenid
//         );

//         // Attempt to execute the prepared statement
//         if ($stmt->execute()) {
//             echo json_encode(array("success" => true));
//             die;
//         } else {
//             echo json_encode(array("success" => false, "msg" => "Fehler beim Zugriff auf den Kunden."));
//             die;
//         }
//         $stmt->close();
//     } else {

//         echo json_encode(array("success" => false, "msg" => $mysqli->error));
//         die;
//     }
//     // Close statement
// }

// function create_auftrag($anfrage_id)
// {
//     $kundenid = get_client_id($anfrage_id);
//     $kundendata = get_client_data($kundenid);
//     save_auftrag($kundendata);
// }
