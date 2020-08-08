<?php

require_once dirname(__FILE__) . '/../../config.php';

// The response we get on successful execution.
$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // Takes raw data from the request
    $json = file_get_contents('php://input');

    // Converts it into a PHP object
    $data = json_decode($json);


    if (isset($data->username) && (strlen($data->username) > 0)) {
        http_response_code(403);
        die('Spambot erkannt.');
    }

    if (!$data->{'email'}) {
        set_failure("Die eingegebene Email ist leer oder nicht korrekt.");
    }

    $to = $data->{'email'};
    //$to= "j.raisch@weiter-germany.com";
    $body = "";
    $subject = "Neue Anfrage via Portokalkulator";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: LST-Siegen.de <wordpress@lst-siegen.de>" . "\r\n";
    //$headers[] = 'CC: $data->email;';
    $body = "";
    if ($data->kontaktwunsch == "phone") {
        // lst als BCC hinzufügen
        //oder nur lst als empfänger
        //ggf. suject und body anpassen
        $subject .= " (Kontaktaufnahme erwünscht)";
    }
    $body .=
        "Guten Tag, <br/>
    folgende Anfrage wurde über den Portokalkulator auf lst-siegen.de gestellt:<br/>
    <br/><table style=\"border: 1px dashed #999;\" cellpadding=\"8\" cellspacing=\"1\"><tr > <td>
    Von (PLZ):</td><td>      " . $data->{'plz-start'} . " <br/></td></tr><tr><td>
    Nach (PLZ):</td><td>     " . $data->{'plz-start'} . " <br/></td></tr><tr><td>
    Gewicht:</td><td>        $data->gewicht <br/></td></tr><tr><td>
    Größe:</td><td>          " . $data->{'groesse-x'} . " x " . $data->{'groesse-y'} . " x " . $data->{'groesse-z'} . " cm <br/></td></tr><tr><td>
    Zustellzeit-Zone:</td><td>  $data->zeitfenster <br/></td></tr><tr><td>
    Zustellung:</td><td> ";



    switch ($data->zustelltag) {
        case 1:
            $body .= "Werktag (Mo. – Fr.)";
            break;
        case 2:
            $body .= "Samstags";
            break;
        case 4:
            $body .= "Sonntags";
            break;
        default:
            $body .= "Keine Angabe";
            break;
    }

    $body .= "<br/></td></tr><tr><td>
    Serviceoptionen:</td><td>  <ul>  ";

    foreach ($data->service as $key => $value) {
        $body .= '<li> ' . $key . ' </li>';
        $body .= '<li> ' . $key . ' </li>';
    }

    $body .= "</ul></td></tr> <tr> <td>Berechnete Summe:</td><td>" . number_format($data->summe, 2, ",", ".") . " EUR (netto)<br> " . number_format($data->summe * 1.19, 2, ",", ".") . " EUR (inkl. MwSt.) </td></tr>";

    $body .= "<tr><td colspan='2'><br/> Kundendaten: <br/>";
    $body .= " 
    $data->name  <br/>
    $data->email";




    if ($data->kontaktwunsch == "phone") {
        $body .= " 
    Der Kunde wünscht eine telefonische Kontaktaufnahme: \n<br/>
    Telefonnummer: $data->telefon";
    } else {
    }



    $body .= "</td></tr></table>
    </table>";
    // mail an kunde, danach body erweitern und mail an lst:

    $body .= "
    <br/><br/>
    - > <a href=\"https://lst-siegen.de\"><strong>Anfragenhistorie betrachten</strong></a> \n<br/><br/>
    - > <a href=\"https://lst-siegen.de\"><strong>Einen Auftrag aus dieser Anfrage erstellen</strong></a>";


    //echo $body;


    // Check connection
    $user_id = $data->{'kundennr'} === '' ? -1 : intval($data->{'kundennr'});
    if (user_exists($mysqli, $user_id)) {
        $data->{'kundennr'} = $user_id;
        create_package_request($mysqli, $data);
    } else {
        set_failure("Die eingegebenen KundenID existiert nicht. Bitte überprüfen Sie die ID nochmal.");
    }


    $mysqli->close();

    if ($error_msg === '' && $success_msg !== '') {
        send_request_email($to, $subject, $body, $headers);
        echo json_encode(array("success" => true, "msg" => $success_msg));
    } else {
        echo json_encode(array("success" => false, "msg" => $error_msg));
    }
}

function validate_token($token)
{
    if (isset($token) && (strlen($token) > 11)) {
        $m = intval(substr($token, 0, 2));
        if (($m > 60) || ($m < 0)) {
            echo "M falsch. " . $m;
            return false;
        }

        $s = substr($token, 2, 2);
        if (($s > 60) || ($s < 0)) {
            echo "S falsch. " . $s;
            return false;
        }

        $crc = strrev(substr($token, 4));
        $subtoken = substr($token, 0, 4);
        $hasht = hash("crc32b", $subtoken);
        if ($crc != $hasht) {
            echo "Prüfsumme falsch. \n";
            echo $crc . " erhalten\n";
            echo $hasht . "  crc\n";
            return false;
        }

        return true;
    } else {
        return false;
    }
}

function user_exists($mysqli, $user_id)
{
    $result = false;
    $sql = "SELECT * FROM kunden WHERE id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $result = true;
            }
        } else {
            echo "Something went wrong with MySQL.";
        }
        $stmt->close();
    }
    return $result;
}

function create_package_request($mysqli, $data)
{
    $sql = "INSERT INTO anfragen
        (plz_start,
        plz_ziel,
        zeit_fenster,
        zustelltag,
        volumengewicht,
        service_leistung,
        kunden_name,
        email,
        telefon,
        kontakt_wunsch,
        kunden_id,
        completed) 
        VALUES (?, ?, ?, ?, ?, ? ,? ,?, ?, ? ,?, 0)";

    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param(
            "iississsssi",
            intval($data->{'plz-start'}),
            intval($data->{'plz-ziel'}),
            $data->{'zeitfenster'},
            $data->{'zustelltag'},
            intval($data->{'volumengewicht'}),
            json_encode($data->{'service_leistung'}),
            $data->{'name'},
            $data->{'email'},
            $data->{'telefon'},
            $data->{'kontaktwunsch'},
            intval($data->{'kundennr'})
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
            set_failure("Ein Datenbankfehler ist aufgetreten.\n");
        }

        $stmt->close();
    } else {
        set_failure("Ein Datenbankfehler ist aufgetreten.\n");
    }
}

function create_packets($mysqli, $data, $anfrage_id)
{
    $pakete = $data->{'pakete'};

    // set_failure(json_encode($pakete));

    foreach ($pakete as $paket) {
        $sql = "INSERT INTO pakete
    (laenge,
    breite,
    hoehe,
    volumengewicht,
    gewicht,
    preis,
    anfrage_id)
    VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param(
                "iiiiidi",
                intval($paket->{'laenge'}),
                intval($paket->{'breite'}),
                intval($paket->{'hoehe'}),
                intval($paket->{'volumengewicht'}),
                intval($paket->{'gewicht'}),
                doubleval($paket->{'preis'}),
                $anfrage_id
            );

            if (!$stmt->execute()) {
                return false;
            }
            $stmt->close();
        } else return false;
    }
    return true;
}

function create_user($mysqli, $data)
{
    $rand_username = substr(str_shuffle(MD5(microtime())), 0, 10);
    $rand_password = substr(str_shuffle(MD5(microtime())), 0, 10);
    $rand_password_hashed =  password_hash($rand_password, PASSWORD_DEFAULT); // Creates a password hash

    $sql = "INSERT INTO kunden (firmenname,
            anrede,
            ansprechpartner,
            email,
            telefon,
            strasse,
            hausnummer,
            plz,
            ort,
            land, telefon_zentrale, freitext, username, password, first_update)
            VALUES ('Firmenname', 'Frau', ?, ?, ?, 'Neustrasse', 0, 0, 'Neuort', 'Neuland', '0', '', ?, ?, 0)";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param(
            "sssss",
            $data->{'name'},
            $data->{'email'},
            $data->{'telefon'},
            $rand_username,
            $rand_password_hashed
        );

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Email the client.
            email_client($data->{'email'}, $rand_username, $rand_password);
            // Get the user id.
            $user_id = -1;
            $sql = "SELECT id FROM kunden WHERE username = ?";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("s", $rand_username);
                if ($stmt->execute()) {
                    $stmt->store_result();
                    if ($stmt->num_rows == 1) {
                        $stmt->bind_result($user_id);
                        if ($stmt->fetch()) {
                            return $user_id;
                        }
                    }
                } else {
                    set_failure("Kunden ID existiert nicht. Interner Fehler, bitte melden.");
                }
                $stmt->close();
            }
        } else {
            set_failure("Die eingegeben Email existiert schon mit einem anderen Kunden. Stellen Sie sicher, dass Ihre KundenID richtig ist.");
        }

        // Close statement
        $stmt->close();
    }
    // Close connection
    $mysqli->close();
}

function email_client($email, $username, $password)
{
    try {
        $msg = "Hier sind Ihre Logindaten:\nBenutzername: " . $username . "\nPasswort: " . $password . "\n";
        $headers = "From: v.kostadinov@weiter-entwickelt.de";
        mail($email, "Ihr Konto wurde automatisch angelegt", $msg, $headers);
    } catch (Exception $e) {
        set_failure("Ein Fehler beim Verschicken der Email ist aufgetretten.");
    }
}

function set_failure($msg)
{
    global $success_msg;
    global $error_msg;
    $success_msg = '';
    $error_msg = $msg;
    echo json_encode(array("success" => false, "msg" => $error_msg));
    die;
}

function send_request_email($to, $subject, $body, $headers)
{
    global $success_msg;
    if (mail($to, $subject, $body, $headers)) {
        $success_msg .= "Wir haben Ihnen Ihre Berechnung per E-Mail zugesendet.\n";
    } else {
        set_failure("Senden der Benachrichtigungsmail fehlgeschlagen.");
    }
}
