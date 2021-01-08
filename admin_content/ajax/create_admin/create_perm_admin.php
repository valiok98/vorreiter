<?php
require_once dirname(__FILE__) . '/../../../config.php';
require_once dirname(__FILE__) . '/../../../helpers_general/helpers.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['inputUsername'];
    $email = $_POST['inputEmail'];
    $oldPass = $_POST['inputTempPass'];
    $newPass = $_POST['inputNewPass'];
    $newPassAgain = $_POST['inputNewPassAgain'];

    if ($newPass == $newPassAgain) {
        $newPassHash =  password_hash($newPass, PASSWORD_DEFAULT); // Creates a password hash

        // Insert the new record.
        $sql = "UPDATE vorreiter_admin_users SET permanent = 1, password = ? WHERE username = ? AND email = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param(
                "sss",
                $newPassHash,
                $username,
                $email
            );

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                echo json_encode(array("success" => true));
            } else {
                echo_failure($stmt->error);
            }
        } else {
            echo_failure($mysqli->error);
        }
    } else {
        echo_failure("Die Passwörter stimmen nicht überein.");
    }
}
