<?php
require_once dirname(__FILE__) . '/config.php';

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once dirname(__FILE__) . '/user_content/register.php';
    $newUser = new CreateUser($mysqli, $_POST["signupUsername"], $_POST["signupEmail"], $_POST["signupPassword"]);
    $newUser->create();

    // Admin registration.
    // require_once dirname(__FILE__) . '/admin_content/register.php';
    // $newAdmin = new CreateAdmin($mysqli, $_POST["signupUsername"], $_POST["signupEmail"], $_POST["signupPassword"]);
    // $newAdmin->create();
}
