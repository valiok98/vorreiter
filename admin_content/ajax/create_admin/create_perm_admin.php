<?php
require_once dirname(__FILE__) . '/../../../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['inputUsername'];
    $email = $_POST['inputEmail'];
    $oldPass = $_POST['inputTempPass'];
    $newPass = $_POST['inputNewPass'];
    $newPassAgain = $_POST['inputNewPassAgain'];
    $result_json = '';

    if ($newPass == $newPassAgain) {
        $newPassHash =  password_hash($newPass, PASSWORD_DEFAULT); // Creates a password hash

        // Delete previous record.
        $sql = "DELETE FROM admin_users WHERE email = ? AND username = ?";
        if ($stmt = $mysqli->prepare($sql)) {

            // Bind variables to the prepared statement as parameters
            $stmt->bind_param(
                "ss",
                $email,
                $username
            );
            // Attempt to execute the prepared statement
            if (!$stmt->execute()) {
                $result_json =  json_encode(array("success" => false, "msg" => $stmt->error));
            }
        } else {
            $result_json =  json_encode(array("success" => false, "msg" => $mysqli->error));
        }

        if ($result_json) {
            // Close connection
            $mysqli->close();
            echo $result_json;
            die;
        }


        // Insert the new record.
        $sql = "INSERT INTO admin_users (username,
    email,
    permanent,
    PASSWORD)
    VALUES (?, ?, 1, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param(
                "sss",
                $username,
                $email,
                $newPassHash,
            );

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                $result_json =  json_encode(array("success" => true));
            } else {
                $result_json =  json_encode(array("success" => false, "msg" => $stmt->error));
            }
        } else {
            $result_json =  json_encode(array("success" => false, "msg" => $mysqli->error));
        }
    } else {
        $result_json = json_encode(array("success" => false, "msg" => "Die Passwörter stimmen nicht überein."));
    }
    // Close connection
    $mysqli->close();

    echo $result_json;
}
