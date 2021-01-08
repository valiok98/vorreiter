<?php
// Set the header for remote access.
header('Access-Control-Allow-Origin: https://wirliefernsicher.de');
require_once dirname(__FILE__) . '/../../../helpers_by_table/admin_users_helpers.php';
require_once dirname(__FILE__) . '/../../../helpers_general/helpers.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $response = create_admin($_POST);
    // Check if the response is true, otherwise send the error message.
    if ($response === true) {
        // Get the admin with the specified email.
        $client_data = get_admin_by_email(trim(strval($_POST["email"])));
        if (gettype($client_data) === 'string') {
            echo_failure($client_data);
        } else {
            // Try emailing the admin.
            $response = email_admin($client_data);
            if ($response === true) {
                echo json_encode(array("success" => true));
            } else {
                echo_failure($response);
            }
        }
    } else {
        echo_failure($response);
    }
}

function email_admin($client_data)
{
    try {

        $to = $client_data["email"];
        // $to = "d.krumpholz@weiter-entwickelt.de";
        $from = "vorreiter@vorreiter.net";
        $subject = "Herzlich willkommen bei LST-Siegen !";


        $txt = "Hallo !
    \r\n\r\nIhr Name: " . $client_data["full_name"] .
            "\r\n\r\nIhr Benutzername: " . $client_data["username"] .
            "\r\n\r\nEmail: " . $client_data["email"] .
            "\r\n\r\nIhr Passwort ist vorläufig.\r\nUm sich unter https://vorreiter.net/demo/vorreiter einloggen zu können," .
            "\r\nmüssen Sie es unter https://vorreiter.net/demo/vorreiter/admin_content/ajax/create_admin/index.php erneuern.\r\n";

        $headers = "From: " . $from . "\r\n" .
            "Content-Type: text/plain; charset=UTF-8";

        mail($to, $subject, $txt, $headers);
        return true;
    } catch (Exception $e) {
        return "Es konnte keine Email abgesendet werden.";
    }
}
