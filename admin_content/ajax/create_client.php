<?php
require_once dirname(__FILE__) . '/../../helpers_by_table/clients_helpers.php';
require_once dirname(__FILE__) . '/../../helpers_general/helpers.php';


if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {
    $client_data = json_decode(file_get_contents('php://input'), true);
    $response = create_client($client_data);

    if ($response === true) {
        // Check if we should inform the client by sending them their login email/id.
        $inform_client = boolval($client_data["inform_client"]);
        if ($inform_client) {
            // Get the client with the specified email.
            $client_data = get_client_by_email(trim(strval($client_data["email"])));
            if (gettype($client_data) === 'string') {
                echo_failure("Der Kunde konnte nicht abgespeichert werden.");
            } else {
                // Try sending the email.
                $response = email_client($client_data);
                if ($response === true) {
                    echo json_encode(array("success" => true));
                } else {
                    echo_failure($response);
                }
            }
        } else {
            echo json_encode(array("success" => true));
        }
    } else {
        echo_failure($response);
    }
}



function email_client($client_data)
{
    try {

        $username = $client_data["username"];
        $email = $client_data["email"];
        $client_id = $client_data["id"];

        $to = $email;
        $from = "vorreiter@vorreiter.net";
        $subject = "Ihr Konto wurde automatisch angelegt";

        $msg = "Hier sind Ihre Logindaten:\r\n" .
            "Benutzername: " . $username . "\r\n" .
            "Ihre KundenID: " . $client_id . "\r\n" .
            "Ihr Konto ist noch nicht bestätigt worden. Sie müssen ein Passwort wählen.\r\n";

        $headers = "From: " . $from . "\r\n" . "Content-Type: text/plain; charset=UTF-8\r\n";
        mail($to, $subject, $msg, $headers);
        return true;
    } catch (Exception $e) {
        return "Es konnte keine Email abgesendet werden.";
    }
}
