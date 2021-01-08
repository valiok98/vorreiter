<?php
require_once dirname(__FILE__) . "/../config.php";
require_once dirname(__FILE__) . "/../definitions.php";

// Processing form data when form is submitted.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once dirname(__FILE__) . '/../admin_content/login.php';

    $_POST = json_decode(file_get_contents('php://input'), true);

    $SAFE_POST = filter_var_array($_POST, [
        "inputEmailUsername" => FILTER_SANITIZE_STRING,
        "inputPassword" => FILTER_SANITIZE_STRING,
        "inputRememberMe" => FILTER_VALIDATE_BOOLEAN
    ]);

    $admin = new AdminLogin($mysqli, trim($SAFE_POST["inputEmailUsername"]), trim($SAFE_POST["inputPassword"]), $SAFE_POST["inputRememberMe"]);
    // Check if the login data is for an admin.
    if ($admin->exists()) {
        echo json_encode($admin->login());
    } else {
        echo json_encode(array("success" => false, "msg" => "Es gibt kein Admin mit den Angaben oder Sie sind nicht als Admin bestätigt."));
    }
}
