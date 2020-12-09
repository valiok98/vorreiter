<?php
class AdminLogin
{
    private $mysqli;
    private $id;
    private $inputEmailUsername;
    private $inputPassword;
    private $inputRememberMe;
    private $hashedPassword;
    private $checkEmail;
    private $error;
    private $success;


    public function __construct($mysqli, $inputEmailUsername, $inputPassword, $inputRememberMe)
    {
        $this->mysqli = $mysqli;
        $this->inputEmailUsername = trim($inputEmailUsername);
        $this->inputPassword = trim($inputPassword);
        $this->inputRememberMe = $inputRememberMe;
        if (filter_var($this->inputEmailUsername, FILTER_VALIDATE_EMAIL)) {
            $this->checkEmail = true;
        } else {
            $this->checkEmail = false;
        }
    }


    public function exists()
    {

        try {
            $sql = "";
            if ($this->checkEmail) {
                $sql = "SELECT password FROM vorreiter_admin_users WHERE email = ? AND permanent = 1";
            } else {
                $sql = "SELECT password FROM vorreiter_admin_users WHERE username = ? AND permanent = 1";
            }

            if ($stmt = $this->mysqli->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param(
                    "s",
                    $this->mysqli->real_escape_string($this->inputEmailUsername)
                );

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Store result
                    $stmt->store_result();

                    // Check if username exists, if yes then verify password
                    if ($stmt->num_rows == 1) {
                        $stmt->bind_result($this->hashedPassword);
                        if ($stmt->fetch()) {
                            if (password_verify($this->inputPassword, $this->hashedPassword)) {
                                return true;
                            }
                        }
                    }
                }
            }
            return false;
        } catch (Exception $e) {
            return array("success" => false, "msg" => $e->getMessage());
        }
    }

    public function login()
    {

        try {
            // Prepare a select statement
            $sql = '';
            if ($this->checkEmail) {
                $sql = "SELECT id, username, password FROM vorreiter_admin_users WHERE email = ? AND permanent = 1";
            } else {
                $sql = "SELECT id, username, password FROM vorreiter_admin_users WHERE username = ? AND permanent = 1";
            }

            $username = '';

            if ($stmt = $this->mysqli->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param(
                    "s",
                    $this->mysqli->real_escape_string($this->inputEmailUsername)
                );

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Store result
                    $stmt->store_result();

                    // Check if username exists, if yes then verify password
                    if ($stmt->num_rows == 1) {
                        // Bind result variables
                        $stmt->bind_result($this->id, $username, $this->hashedPassword);
                        if ($stmt->fetch()) {
                            if (password_verify($this->inputPassword, $this->hashedPassword)) {
                                // Password is correct, so start a new session
                                session_start();
                                // Store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $this->id;
                                $_SESSION["username"] = $username;
                                $_SESSION["usertype"] = 'admin';

                                // Set a cookie if the remember me checkbox is checked.
                                if ($this->inputRememberMe) {
                                    setcookie("rememberMeCookie", $username, time() + 7200);
                                }

                                $this->success = true;
                            } else {
                                // Display an error message if password is not valid
                                $this->error = "Das eingegebene Passwort stimmt nicht.";
                            }
                        }
                    } else {
                        // Display an error message if username doesn't exist
                        $this->error = "Es gibt kein Profil mit den Angaben(Benutzername/Email).";
                    }
                } else {
                    echo "Es ist ein MySQL Fehler aufgetretten.";
                }

                // Close statement
                $stmt->close();
            }

            // Close connection
            $this->mysqli->close();

            if ($this->error) {
                return array("success" => false, "msg" => $this->error);
            } else if ($this->success) {
                return array("success" => true, "url" => URL . "admin_content/welcome.php");
            }
        } catch (Exception $e) {
            return array("success" => false, "msg" => $e->getMessage());
        }
    }
}
