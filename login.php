<?php
require_once dirname(__FILE__) . "/config.php";
require_once dirname(__FILE__) . "/definitions.php";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once dirname(__FILE__) . '/admin_content/login.php';
    $admin = new AdminLogin($mysqli, $_POST['loginEmailOrUsername'], $_POST['loginPassword']);
    // Check if the login data is for an admin.
    if ($admin->exists()) {
        $admin->login();
    } else {
        // Check if the login data is for a regular user.
        require_once dirname(__FILE__) . '/user_content/login.php';
        $user = new UserLogin($mysqli, $_POST['loginEmailOrUsername'], $_POST['loginPassword']);
        if ($user->exists()) {
            $user->login();
        } else {
            header('location:' . URL . 'index.php');
        }
    }
}
