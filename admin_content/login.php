<?php
class AdminLogin
{
    private $mysqli;
    private $id;
    private $username_or_email;
    private $password;
    private $hashed_password;
    private $check_by_email;
    private $password_error;
    private $username_or_email_error;

    public function __construct($mysqli, $username_or_email, $password)
    {
        $this->mysqli = $mysqli;
        $this->username_or_email = trim($username_or_email);
        $this->password = trim($password);
        if (filter_var($this->username_or_email, FILTER_VALIDATE_EMAIL)) {
            $this->check_by_email = true;
        } else {
            $this->check_by_email = false;
        }
    }


    public function exists()
    {
        $sql = '';
        if ($this->check_by_email) {
            $sql = "SELECT password FROM admin_users WHERE email = ?";
        } else {
            $sql = "SELECT password FROM admin_users WHERE username = ?";
        }


        if ($stmt = $this->mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $this->username_or_email);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($this->hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($this->password, $this->hashed_password)) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    public function login()
    {
        // Prepare a select statement
        $sql = '';
        if ($this->check_by_email) {
            $sql = "SELECT id, username, password FROM admin_users WHERE email = ?";
        } else {
            $sql = "SELECT id, username, password FROM admin_users WHERE username = ?";
        }

        $username = '';

        if ($stmt = $this->mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $this->username_or_email);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($this->id, $username, $this->hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($this->password, $this->hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $this->id;
                            $_SESSION["username"] = $username;
                            $_SESSION["usertype"] = 'admin';

                            // Redirect user to welcome page
                            header("location:" . URL . "admin_content/welcome.php");
                            die;
                        } else {
                            // Display an error message if password is not valid
                            $this->password_error = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $this->username_or_email_error = "No account found with that username/email.";
                }
            } else {
                echo "Something went wrong with MySQL.";
            }

            // Close statement
            $stmt->close();
        }

        $this->display_errors();
        // Close connection
        $this->mysqli->close();
    }


    private function display_errors()
    {
        if (!empty($this->username_or_email_error) || !empty($this->password_error)) {

            echo 'The following error/s occured:<br>' . $this->username_or_email_error .
                '<br>' . $this->password_error;
        }
    }
}
