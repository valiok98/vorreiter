<?php
require_once dirname(__FILE__) . '/../../config.php';
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {
    $post_data = json_decode(file_get_contents('php://input'), true);

    $client = new CreateClient(
        $mysqli,
        $post_data["clientName"],
        $post_data["salutation"],
        $post_data["email"],
        $post_data["phone"],
        $post_data["street"],
        $post_data["houseNumber"],
        $post_data["postcode"],
        $post_data["firstName"],
        $post_data["lastName"],
        $post_data["fax"],
        $post_data["title"],
        $post_data["clientAbv"],
        $post_data["mobilePhone"],
        $post_data["place"],
        $post_data["country"],
        $post_data["centralPhone"],
        $post_data["freeText"],
        $post_data["informClient"]
    );
    $client->create();
}

class CreateClient
{
    private $mysqli;
    private $id;
    private $name;
    private $salutation;
    private $email;
    private $phone;
    private $street;
    private $house_number;
    private $plz;
    private $first_name;
    private $last_name;
    private $fax;
    private $title;
    private $client_abv;
    private $mobile;
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
        $email,
        $phone,
        $street,
        $house_number,
        $plz,
        $first_name,
        $last_name,
        $fax,
        $title,
        $client_abv,
        $mobile,
        $place,
        $country,
        $central_phone,
        $textarea,
        $inform_client
    ) {
        $this->mysqli = $mysqli;
        $this->name = $name;
        $this->salutation = $salutation;
        $this->email = $email;
        $this->phone = $phone;
        $this->street = $street;
        $this->house_number = $house_number + 0;
        $this->plz = $plz + 0;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->fax = $fax;
        $this->title = $title;
        $this->client_abv = $client_abv;
        $this->mobile = $mobile;
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
            email,
            telefon,
            strasse,
            hausnummer,
            plz,
            vorname,
            nachname,
            titel,
            fax,
            mobil,
            kuerzel,
            ort,
            land, telefon_zentrale, freitext, username, password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $this->mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param(
                "sssssiissssssssssss",
                $this->name,
                $this->salutation,
                $this->email,
                $this->phone,
                $this->street,
                $this->house_number,
                $this->plz,
                $this->first_name,
                $this->last_name,
                $this->title,
                $this->fax,
                $this->mobile,
                $this->client_abv,
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
                $clientData = [
                    "clientId" => $this->id,
                    "companyName" => $this->name,
                    "phone" => $this->phone,
                    "email" => $this->email
                ];

                $this->result_json = json_encode(array("success" => true, "clientData" => $clientData));
                // Should we email the client ?
                if ($this->inform_client) {
                    // Get the client ID.
                    $this->email_client();
                }
            } else {
                $this->result_json = json_encode(array("success" => false, "msg" => $stmt->error));
                // $this->result_json = json_encode(array("success" => false, "msg" => "A database error occured."));
            }

            // Close statement
            $stmt->close();
        } else {
            $this->result_json = json_encode(array("success" => false, "msg" => $this->mysqli->error));
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
            $this->result_json = json_encode(array("success" => false, "msg" => "Error in sending an email."));
        }
    }
}
