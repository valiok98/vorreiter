<?php
require_once dirname(__FILE__) . '/../config.php';
if (
    isset($_POST["bv_firmenname"]) &&
    isset($_POST["bv_anrede"]) &&
    isset($_POST["bv_ansprechpartner"]) &&
    isset($_POST["bv_email"]) &&
    isset($_POST["bv_telefon"]) &&
    isset($_POST["bv_strasse"]) &&
    isset($_POST["bv_hausnummer"]) &&
    isset($_POST["bv_plz"]) &&
    isset($_POST["bv_ort"]) &&
    isset($_POST["bv_land"]) &&
    isset($_POST["bv_ztelefon"]) &&
    isset($_POST["bv_freitext"]) &&
    isset($_POST["bv_kunden_informieren"])
) {
    $client = new CreateClient(
        $mysqli,
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
        $_POST["bv_freitext"],
        $_POST["bv_kunden_informieren"]
    );
    $client->create();
}

class CreateClient
{
    private $mysqli;
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
    private $inform_client;
    private $rand_username;
    private $rand_password;
    private $result_json;

    public function __construct(
        $mysqli,
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
        $textarea,
        $inform_client
    ) {
        $this->mysqli = $mysqli;
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
        $this->inform_client = $inform_client;
    }

    public function create()
    {
        $this->rand_username = substr(str_shuffle(MD5(microtime())), 0, 10);
        $this->rand_password = substr(str_shuffle(MD5(microtime())), 0, 10);
        $rand_password_hashed =  password_hash($this->rand_password, PASSWORD_DEFAULT); // Creates a password hash

        // Prepare an insert statement
        $sql = "INSERT INTO kunden (firmenname,
            anrede,
            ansprechpartner,
            email,
            telefon,
            strasse,
            hausnummer,
            plz,
            ort,
            land, telefon_zentrale, freitext, username, password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $this->mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param(
                "ssssssiissssss",
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
                $this->rand_username,
                $rand_password_hashed
            );

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                $this->id = $this->mysqli->insert_id;
                $client_data = [
                    "kundennummer" => $this->id,
                    "firmenname" => $this->name,
                    "ansprechpartner" => $this->contact,
                    "telefon" => $this->phone,
                    "email" => $this->email
                ];

                $this->result_json = json_encode(array("success" => true, "client_data" => $client_data));
                // Should we email the client ?
                if ($this->inform_client) {
                    // Get the client ID.
                    $this->email_client();
                }
            } else {
                $this->result_json = json_encode(array("success" => false, "message" => $this->mysqli->error));
                // $this->result_json = json_encode(array("success" => false, "message" => "A database error occured."));
            }

            // Close statement
            $stmt->close();
        }
        // Close connection
        $this->mysqli->close();

        echo $this->result_json;
    }

    private function email_client()
    {
        try {
            $msg = "Hier sind Ihre Logindaten:\nBenutzername: " . $this->rand_username .
                "\nPasswort: " . $this->rand_password .
                "\nIhre KundenID: " . $this->id . "\n";
            $headers = "From: v.kostadinov@weiter-entwickelt.de";
            mail($this->email, "Ihr Konto wurde automatisch angelegt", $msg, $headers);
        } catch (Exception $e) {
            $this->result_json = json_encode(array("success" => false, "message" => "Error in sending an email."));
        }
    }
}
