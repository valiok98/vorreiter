<?php


class CreateAdmin
{

    private $mysqli;
    private $username;
    private $email;
    private $password;
    private $username_error;
    private $email_error;
    private $password_error;


    public function __construct($mysqli, $username, $email, $password)
    {
        $this->mysqli = $mysqli;
        $this->username = trim($username);
        $this->email = trim($email);
        $this->password = trim($password);
        $this->username_error = '';
        $this->email_error = '';
        $this->password_error = '';
    }

    public function create()
    {
        if (empty($this->username)) {
            $this->username_error = 'Please enter a username';
        }
        if (empty($this->email)) {
            $this->email_error = 'Please enter an email';
        }
        if (empty($this->password)) {
            $this->password_error = 'Please enter a password';
        }

        $this->check_errors();

        // Check input errors before inserting in database
        if (empty($this->username_error) && empty($this->email_error) && empty($this->password_error)) {

            // Prepare an insert statement
            $sql = "INSERT INTO admin_users (username, email, password) VALUES (?, ?, ?)";

            if ($stmt = $this->mysqli->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("sss", $this->username, $this->email, $this->password);

                // Set parameters
                $this->password = password_hash($this->password, PASSWORD_DEFAULT); // Creates a password hash

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Redirect to login page
                    header("location:" . URL . "index.php");
                    die;
                } else {
                    echo "Something went wrong with MySQL.";
                }

                // Close statement
                $stmt->close();
            }
        } else {
            echo 'The following error/s occured:<br>' . $this->username_error .
                '<br>' . $this->email_error;
        }

        // Close connection
        $this->mysqli->close();
    }

    private function check_errors()
    {
        // Check if the username already exists.
        $sql1 = "SELECT * FROM admin_users WHERE username = ?";
        $sql2 = "SELECT * FROM users WHERE username = ?";

        if (($stmt1 = $this->mysqli->prepare($sql1)) && ($stmt2 = $this->mysqli->prepare($sql2))) {
            $stmt1->bind_param("s", $this->username);
            $stmt2->bind_param("s", $this->username);

            if ($stmt1->execute()) {
                $stmt1->store_result();
                if ($stmt1->num_rows == 1) {
                    $this->username_error = "This username is already taken.";
                }
            } else {
                echo "Something went wrong with MySQL.";
            }

            if ($stmt2->execute()) {
                $stmt2->store_result();
                if ($stmt2->num_rows == 1) {
                    $this->username_error = "This username is already taken by a regular user.";
                }
            } else {
                echo "Something went wrong with MySQL.";
            }


            $stmt1->close();
            $stmt2->close();
        }
        // Check if the email already exists.
        $sql1 = "SELECT * FROM admin_users WHERE email = ?";
        $sql2 = "SELECT * FROM users WHERE email = ?";

        if (($stmt1 = $this->mysqli->prepare($sql1)) && ($stmt2 = $this->mysqli->prepare($sql2))) {
            $stmt1->bind_param("s", $this->username);
            $stmt2->bind_param("s", $this->username);

            if ($stmt1->execute()) {
                $stmt1->store_result();
                if ($stmt1->num_rows == 1) {
                    $this->username_error = "This email is already taken.";
                }
            } else {
                echo "Something went wrong with MySQL.";
            }

            if ($stmt2->execute()) {
                $stmt2->store_result();
                if ($stmt2->num_rows == 1) {
                    $this->username_error = "This email is already taken by a regular user.";
                }
            } else {
                echo "Something went wrong with MySQL.";
            }


            $stmt1->close();
            $stmt2->close();
        }
    }
}
