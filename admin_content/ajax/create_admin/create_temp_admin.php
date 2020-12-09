<?php
header('Access-Control-Allow-Origin', '*');
// switch ($_SERVER['HTTP_ORIGIN']) {
//     case 'https://www.wirliefernsicher.de': case 'https://weiter-entwickelt.de':
//     header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
//     header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
//     header('Access-Control-Max-Age: 1000');
//     header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
//     break;
// }
require_once dirname(__FILE__) . '/../../../config.php';
require_once dirname(__FILE__) . '/helpers.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fullName = $_POST['fullName'];
    $username = gen_random_username();
    $email = $_POST['email'];
    $password = $_POST['password'];
    $newPassHash =  password_hash($password, PASSWORD_DEFAULT); // Creates a password hash


    // Insert the new record.
    $sql = "INSERT INTO admin_users (username,
        email,
        PASSWORD)
        VALUES (?, ?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param(
            "sss",
            $username,
            $email,
            $newPassHash
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
    // Close connection
    $mysqli->close();

    $to = $email;
    // $to = "d.krumpholz@weiter-entwickelt.de";
    $from = $email;
    $subject = "Herzlich willkommen bei LST-Siegen !";


    $txt = "Hallo !
    \r\n\r\nIhr Name: " . $fullName .
    "\r\n\r\nIhr Benutzername: " . $username .
        "\r\n\r\nEmail: " . $email .
        "\r\n\r\nPasswort: " . $password . "\r\n\r\nDas Passwort ist vorläufig.\r\nUm sich unter https://vorreiter.net/demo/vorreiter einloggen zu können," .
        "\r\nmüssen Sie es unter https://vorreiter.net/demo/vorreiter/admin_content/ajax/create_admin/index.php erneuern.\r\n";

    $headers = "From: " . $from . "\r\n" .
        "Content-Type: text/plain; charset=UTF-8";

    mail($to, $subject, $txt, $headers);

    echo json_encode(array("success" => true));
}

