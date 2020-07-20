<?php
require_once dirname(__FILE__) . '/../config.php';


if (
    isset($_POST["bv_kundenid"]) &&
    !empty($_POST["bv_kundenid"]) &&
    isset($_POST["bv_firmenname"]) &&
    !empty($_POST["bv_firmenname"]) &&
    isset($_POST["bv_anrede"]) &&
    !empty($_POST["bv_anrede"]) &&
    isset($_POST["bv_ansprechpartner"]) &&
    !empty($_POST["bv_ansprechpartner"]) &&
    isset($_POST["bv_email"]) &&
    !empty($_POST["bv_email"]) &&
    isset($_POST["bv_telefon"]) &&
    !empty($_POST["bv_telefon"]) &&
    isset($_POST["bv_strasse"]) &&
    !empty($_POST["bv_strasse"]) &&
    isset($_POST["bv_hausnummer"]) &&
    !empty($_POST["bv_hausnummer"]) &&
    isset($_POST["bv_plz"]) &&
    !empty($_POST["bv_plz"]) &&
    isset($_POST["bv_ort"]) &&
    !empty($_POST["bv_ort"]) &&
    isset($_POST["bv_land"]) &&
    !empty($_POST["bv_land"]) &&
    isset($_POST["bv_ztelefon"]) &&
    !empty($_POST["bv_ztelefon"]) &&
    isset($_POST["bv_freitext"]) &&
    !empty($_POST["bv_freitext"])
) {
    $client = new UpdateClient(
        $mysqli,
        $_POST["bv_kundenid"]
    );
    $client->setup_update_general(
        $_POST["bv_firmenname"],
        $_POST["bv_anrede"],
        $_POST["bv_ansprechpartner"],
        $_POST["bv_email"],
        $_POST["bv_telefon"],
        $_POST["bv_strasse"],
        $_POST["bv_hausnummer"],
        $_POST["bv_plz"],
        $_POST["bv_ort"],
        $_POST["bv_land"],
        $_POST["bv_ztelefon"],
        $_POST["bv_freitext"]
    );
    // Update without user/pass change.
    $client->update();
    echo $client->result_json;
    $client->mysqli->close();
} else if (
    isset($_POST["bv_kundenid"]) &&
    !empty($_POST["bv_kundenid"]) &&
    isset($_POST["bv_benutzername"]) &&
    !empty($_POST["bv_benutzername"]) &&
    isset($_POST["bv_alt_passwort"]) &&
    !empty($_POST["bv_alt_passwort"]) &&
    isset($_POST["bv_neu1_passwort"]) &&
    !empty($_POST["bv_neu1_passwort"]) &&
    isset($_POST["bv_neu2_passwort"]) &&
    !empty($_POST["bv_neu2_passwort"])
) {
    $client = new UpdateClient(
        $mysqli,
        $_POST["bv_kundenid"]
    );
    $client->setup_update_password(
        $_POST["bv_benutzername"],
        $_POST["bv_alt_passwort"],
        $_POST["bv_neu1_passwort"],
        $_POST["bv_neu2_passwort"]
    );
    // Update only the password.
    $client->update_password();
    echo $client->result_json;
    $client->mysqli->close();
} else {
    echo json_encode(array("success" => false, "msg" => "Die Angaben sind nicht vollständig."));
}

class UpdateClient
{
    public $mysqli;
    private $id;
    private $name;
    private $salutation;
    private $contact;
    private $email;
    private $phone;
    private $street;
    private $house_number;
    private $plz;
    private $place;
    private $country;
    private $central_phone;
    private $textarea;
    private $username;
    private $old_password;
    private $new_password1;
    private $new_password2;
    public $result_json = '';

    public function __construct(
        $mysqli,
        $id
    ) {
        $this->mysqli = $mysqli;
        $this->id = $id;
    }

    public function setup_update_general(
        $name,
        $salutation,
        $contact,
        $email,
        $phone,
        $street,
        $house_number,
        $plz,
        $place,
        $country,
        $central_phone,
        $textarea
    ) {
        $this->name = $name;
        $this->salutation = $salutation;
        $this->contact = $contact;
        $this->email = $email;
        $this->phone = $phone;
        $this->street = $street;
        $this->house_number = $house_number + 0;
        $this->plz = $plz + 0;
        $this->place = $place;
        $this->country = $country;
        $this->central_phone = $central_phone;
        $this->textarea = $textarea;
    }

    public function setup_update_password($username, $old_password, $new_password1, $new_password2)
    {

        $this->username = trim($username);
        $this->old_password = trim($old_password);
        $this->new_password1 = trim($new_password1);
        $this->new_password2 = trim($new_password2);
    }

    public function update()
    {
        $sql = "UPDATE kunden SET firmenname = ?,
            anrede = ?,
            ansprechpartner =?,
            email = ?,
            telefon = ?,
            strasse = ?,
            hausnummer = ?,
            plz = ?,
            ort = ?,
            land = ?,
            telefon_zentrale = ?,
            freitext = ?
            WHERE id = ?";

        // Prepare an insert statement
        if ($stmt = $this->mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param(
                "ssssssiissssi",
                $this->name,
                $this->salutation,
                $this->contact,
                $this->email,
                $this->phone,
                $this->street,
                $this->house_number,
                $this->plz,
                $this->place,
                $this->country,
                $this->central_phone,
                $this->textarea,
                $this->id
            );

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                $this->result_json = json_encode(array("success" => true));
                // Should we email the client ?
            } else {
                $this->result_json = json_encode(array("success" => false, "message" => "Benutzerdaten konnten nicht erneuert werden."));
            }

            // Close statement
            $stmt->close();
        }
        // Close connection
    }

    // public function update_username($username)
    // {
    //     $this->username = trim($username);
    //     $sql = "UPDATE kunden SET firmenname = ?,
    //     anrede = ?,
    //     ansprechpartner =?,
    //     email = ?,
    //     telefon = ?,
    //     strasse = ?,
    //     hausnummer = ?,
    //     plz = ?,
    //     ort = ?,
    //     land = ?,
    //     telefon_zentrale = ?,
    //     freitext = ?,
    //     username = ?
    //     WHERE id = ?";
    //     if ($stmt = $this->mysqli->prepare($sql)) {
    //         // Bind variables to the prepared statement as parameters
    //         $stmt->bind_param(
    //             "ssssssiisssssi",
    //             $this->name,
    //             $this->salutation,
    //             $this->contact,
    //             $this->email,
    //             $this->phone,
    //             $this->street,
    //             $this->house_number,
    //             $this->plz,
    //             $this->place,
    //             $this->country,
    //             $this->central_phone,
    //             $this->textarea,
    //             $this->username,
    //             $this->id
    //         );

    //         // Attempt to execute the prepared statement
    //         if ($stmt->execute()) {
    //             $this->result_json = json_encode(array("success" => true));
    //             // Should we email the client ?
    //         } else {
    //             $this->result_json = json_encode(array("success" => false, "message" => "Benutzername konnte nicht erneuert werden."));
    //         }

    //         // Close statement
    //         $stmt->close();
    //     } else {
    //         echo json_encode(array("msg" => $this->mysqli->error));
    //         die;
    //     }
    // }

    public function update_password()
    {
        if ($this->new_password1 !== $this->new_password2) {
            $this->result_json = json_encode(array("success" => false, "msg" => "Die neuen Passwörter stimmen nicht überein."));
        } else if ($this->is_password($this->old_password)) {
            $password_hashed =  password_hash($this->new_password1, PASSWORD_DEFAULT); // Creates a password hash
            
            // Check the username.
            $retrieved_username = '';
            $sql  = "SELECT username FROM kunden WHERE id = ?";
            if($stmt = $this->mysqli->prepare($sql)) {
                $stmt->bind_param("i", $this->id);
                if($stmt->execute()){
                    $stmt->store_result();
                    if($stmt->num_rows == 1) {
                        $stmt->bind_result($retrieved_username);
                        if(!$stmt->fetch()){
                            $retrieved_username = '';
                        }
                    }
                }
            }
            
            if($retrieved_username !== $this->username) {
                $this->result_json = json_encode(array("success"=>false, "msg"=>"Der eingegebene Benutzername stimmt nicht."));
                return;
            }

            $sql = "UPDATE kunden SET password= ? WHERE id = ? AND username = ?";
            if ($stmt = $this->mysqli->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param(
                    "sis",
                    $password_hashed,
                    $this->id,
                    $this->username
                );

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    $this->result_json = json_encode(array("success" => true));
                } else {
                    $this->result_json = json_encode(array("success" => false, "msg" => "Passwort konnte nicht erneuert werden. 
                    Überprüfen Sie bitte Ihren Benutzernamen."));
                }

                // Close statement
                $stmt->close();
            }
        } else {
            $this->result_json = json_encode(array("success" => false, "msg" => "Das alte Passwort stimmt nicht."));
        }
    }

    public function is_password($pass)
    {
        $pass = trim($pass);
        $sql = "SELECT password FROM kunden WHERE id = ?";
        if ($stmt = $this->mysqli->prepare($sql)) {
            $stmt->bind_param("i", $this->id);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $retrieved_pass = '';
                    $stmt->bind_result($retrieved_pass);
                    if ($stmt->fetch()) {
                        if (password_verify($pass, $retrieved_pass)) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
}
