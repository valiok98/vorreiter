<?php
require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../definitions.php';

// echo json_encode(array("msg" => 'Hello world'));
// die;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["rup_kundenid"]) && isset($_POST["rup_benutzername"]) && isset($_POST["rup_passwort"])) {
    $result = '';
    $id = $_POST["rup_kundenid"];
    $username = trim($_POST["rup_benutzername"]);
    $password = trim($_POST["rup_passwort"]);

    $sql = "SELECT * FROM kunden WHERE username = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            $stmt->store_result();


            // If there is no user with these details, update the current one.
            if ($stmt->num_rows == 0) {
                $password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                $sql = "UPDATE kunden SET username = ?, password = ?, first_update = 1 WHERE id = ?";
                if ($stmt = $mysqli->prepare($sql)) {
                    $stmt->bind_param('ssi', $username, $password, $id);
                    if ($stmt->execute()) {
                        // Redirect the client to the welcome.php page with the new user/pass
                        session_start();

                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;
                        $_SESSION["usertype"] = 'user';

                        $result = json_encode(array("success" => true, "id" => $id, "username" => $username));
                    } else {
                        $result = json_encode(array("success" => false, "message" => "Datenbankfehler ist aufgetretten."));
                    }
                    // Close statement
                    $stmt->close();
                }
            } else {
                // There is already a user with the current username, choose a new one.
                $result = json_encode(array("success" => false, "msg" => "Benutzername schon vergeben."));
            }
        } else {
            $result = json_encode(array("msg" => 'MySQL Fehler aufgetretten.'));
        }
    }

    $stmt->close();
    echo $result;
}
