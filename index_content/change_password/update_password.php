<?php
require_once dirname(__FILE__) . "/../../config.php";
require_once dirname(__FILE__) . "/../../definitions.php";
require_once dirname(__FILE__) . "/../../helpers_by_table/admin_users_helpers.php";


// Processing form data when form is submitted.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $_POST = json_decode(file_get_contents('php://input'), true);

    $SAFE_POST = filter_var_array($_POST, [
        "inputEmailUsername" => FILTER_SANITIZE_STRING,
        "inputNewPass1" => FILTER_SANITIZE_STRING,
        "inputNewPass2" => FILTER_SANITIZE_STRING,
        "inputRenewPassUrl" => FILTER_SANITIZE_STRING
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

    echo update_admin_password($adminData, $SAFE_POST);
}

/**
 * A function to update the admin's password.
 */
function update_admin_password($adminData, $inputData)
{

    $renewPassUrl = trim($adminData["renew_pass_url"]);
    $renewPassDate = trim($adminData["renew_pass_date"]);
    $clientID = $adminData["id"];

    $inputRenewPassUrl = trim($inputData["inputRenewPassUrl"]);
    $inputNewPass1 = trim($inputData["inputNewPass1"]);
    $inputNewPass2 = trim($inputData["inputNewPass2"]);

    if ($renewPassUrl === $inputRenewPassUrl && $renewPassDate < time()) {
        if ($inputNewPass1 === $inputNewPass2) {
            // Update the admin's password.
            if (set_admin_new_pass($clientID, $inputNewPass1)) {
                return json_encode(array("success" => true));
            } else {
                return json_encode(array("success" => false, "msg" => "Das Passwort konnte nicht erneuert werden."));
            }
        } else {
            return json_encode(array("success" => false, "msg" => "Die eingegebenen Passwörter stimmen nicht überein."));
        }
    } else {
        return json_encode(array("success" => false, "msg" => "Der Link ist abgelaufen. Bitte einen neuen anfordern."));
    }
}
