<?php
require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../definitions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rl_firmenadresse']) && isset($_FILES['rl_logo'])) {
    $firmenadresse = trim($_POST['rl_firmenadresse']);
    $logo = $_FILES['rl_logo'];


    $sql = "INSERT INTO rechnungslayout (firmenadresse, logo) VALUES (?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param(
            "sb",
            $firmenadresse,
            $logo
        );


        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false, "message" => "A database error occured."));
        }
        // Close statement
        $stmt->close();
    }
    // Close connection
    $mysqli->close();
}
