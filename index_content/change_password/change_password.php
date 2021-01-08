<?php
require_once dirname(__FILE__) . "/../../config.php";
require_once dirname(__FILE__) . "/../../definitions.php";
require_once dirname(__FILE__) . "/../../helpers_by_table/admin_users_helpers.php";


// Processing form data when form is submitted.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $_POST = json_decode(file_get_contents('php://input'), true);

    $SAFE_POST = filter_var_array($_POST, [
        "inputEmailUsername" => FILTER_SANITIZE_STRING,
    ]);

    $inputEmailUsername = trim($SAFE_POST["inputEmailUsername"]);
    $adminData = [];
    // Check if the input is an email.
    if (filter_var($inputEmailUsername, FILTER_VALIDATE_EMAIL)) {
        $adminData = get_admin_by_email($inputEmailUsername);
    } else {
        // The input is a username.
        $adminData = get_admin_by_username($inputEmailUsername);
    }

    echo send_email_to_admin($adminData);
}

/**
 * Send an email to the admin for a password renew.
 * It should contain a unique URL with an expiration date of 1 hour, where they can renew their password.
 */
function send_email_to_admin($adminData)
{

    if ($adminData) {
        $adminID = $adminData["id"];
        $renewPassURL = set_admin_renew_pass_url($adminID);

        $url = URL . 'index_content/change_password/index.php?renew_pass_url=' . $renewPassURL;

        $to = $adminData["email"];
        $from = "vorreiter@vorreiter.net";
        $subject = "Händlerregistration";

        $txt = "Guten Tag " . $adminData["username"] . " (" . $adminData["email"] . ")!\r\n" .
            "Um Ihr Passwort für das Vorreiter System zu ändern, bitte gehen Sie auf\r\n\r\n" .
            $url . "\r\n\r\n" .
            "und füllen Sie die benötigten Angaben aus.\r\n" .
            "Der Link läuft in 1 Stunde ab und danach müssen Sie einen neuen anfordern.\r\n\r\n" .
            "Falls Sie das Vorreiter System nicht kennen, bitte die Mail einfach löschen.\r\n\r\n" .
            "Ihr Vorreiter Team :)\r\n";

        $headers = "From: " . $from . "\r\n" . "Content-Type: text/plain; charset=UTF-8\r\n";
        mail($to, $subject, $txt, $headers);

        return json_encode(array("success" => true));
    } else {
        return json_encode(array("success" => false, "msg" => "Es gibt kein Admin mit den Angaben oder Sie sind nicht als Admin bestätigt."));
    }
}
