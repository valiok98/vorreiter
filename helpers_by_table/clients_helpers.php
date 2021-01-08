<?php
// This file contains all the helper functions for extracting data from the vorreiter_clients table.
// All getters should always return a row(s).
// All setters should always set using the ID of the entry.
// For general helper functions refer to ../helpers_general/helpers.php


require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../definitions.php';
require_once dirname(__FILE__) . '/../helpers_general/helpers.php';


/**
 * Get the data for a client using their id.
 * 
 * @param{$id} - the client's id.
 * @return{$clientData} - the whole row containing all client properties.
 */
function get_client_by_id($clientId)
{
    global $mysqli;
    $clientId = intval($clientId);
    $sql = "SELECT * FROM vorreiter_clients WHERE id = ?";

    if ($stmt = $mysqli->prepare($sql)) {

        $stmt->bind_param("i", $mysqli->real_escape_string($clientId));

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $clientData = $result->fetch_assoc();
            if ($clientData && $mysqli->affected_rows === 1) {
                return $clientData;
            }
        } else return $stmt->error;
    } else return $mysqli->error;
}


/**
 * Get the data for a client using their name.
 * 
 * @param{$id} - the client's id.
 * @return{$clientData} - all rows containing all client properties.
 */
function get_client_by_name($clientName)
{
    global $mysqli;
    $clientName = trim(strval($clientName));
    $clientName = $mysqli->real_escape_string($clientName);
    $sql = "SELECT * FROM vorreiter_clients WHERE company_name LIKE '%" . $clientName . "%'";

    if ($stmt = $mysqli->prepare($sql)) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $clientData = [];
            while ($row = $result->fetch_assoc()) {
                array_push($clientData, $row);
            }
            return $clientData;
        } else return $stmt->error;
    } else return $mysqli->error;
}


/**
 * Get the data for a client using their email.
 * 
 * @param{$id} - the client's id.
 * @return{$clientData} - all rows containing all client properties.
 */
function get_client_by_email($clientEmail)
{
    global $mysqli;
    $clientEmail = trim(strval($clientEmail));
    $clientEmail = $mysqli->real_escape_string($clientEmail);
    $sql = "SELECT * FROM vorreiter_clients WHERE email = ?";

    if ($stmt = $mysqli->prepare($sql)) {

        $stmt->bind_param("s", $mysqli->real_escape_string($clientEmail));

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $clientData = $result->fetch_assoc();
            if ($clientData && $mysqli->affected_rows === 1) {
                return $clientData;
            }
        } else return $stmt->error;
    } else return $mysqli->error;
}

/**
 * Create the client.
 * 
 * @param{$clientData} - the client data.
 * 
 * @return{boolean|string} - true if everything is ok, string containing the error.
 */
function create_client($clientData)
{

    global $mysqli;


    $additional_text = trim(strval($clientData["additional_text"]));
    $company_name = trim(strval($clientData["company_name"]));
    $country = trim(strval($clientData["country"]));
    $email = trim(strval($clientData["email"]));
    $fax = trim(strval($clientData["fax"]));
    $first_name = trim(strval($clientData["first_name"]));
    $house_number = intval($clientData["house_number"]);
    $last_name = trim(strval($clientData["last_name"]));
    $mobile_phone = trim(strval($clientData["mobile_phone"]));
    $phone = trim(strval($clientData["phone"]));
    $phone_central = trim(strval($clientData["phone_central"]));
    $place = trim(strval($clientData["place"]));
    $postal_code = intval($clientData["postal_code"]);
    $salutation = trim(strval($clientData["salutation"]));
    $shorthand = trim(strval($clientData["shorthand"]));
    $street = trim(strval($clientData["street"]));
    $title = trim(strval($clientData["title"]));


    // Generate the random login data for the user.
    $rand_username = gen_random_string(40);
    $rand_password = gen_random_string(10);
    $rand_password_hashed =  password_hash($rand_password, PASSWORD_DEFAULT); // Creates a password hash

    // Prepare an insert statement
    $sql = "INSERT INTO vorreiter_clients (company_name,
            salutation,
            email,
            phone,
            street,
            house_number,
            postal_code,
            first_name,
            last_name,
            title,
            fax,
            mobile_phone,
            shorthand,
            place,
            country,
            phone_central,
            additional_text,
            username,
            password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param(
            "sssssiissssssssssss",
            $mysqli->real_escape_string($company_name),
            $mysqli->real_escape_string($salutation),
            $mysqli->real_escape_string($email),
            $mysqli->real_escape_string($phone),
            $mysqli->real_escape_string($street),
            $mysqli->real_escape_string($house_number),
            $mysqli->real_escape_string($postal_code),
            $mysqli->real_escape_string($first_name),
            $mysqli->real_escape_string($last_name),
            $mysqli->real_escape_string($title),
            $mysqli->real_escape_string($fax),
            $mysqli->real_escape_string($mobile_phone),
            $mysqli->real_escape_string($shorthand),
            $mysqli->real_escape_string($place),
            $mysqli->real_escape_string($country),
            $mysqli->real_escape_string($phone_central),
            $mysqli->real_escape_string($additional_text),
            $mysqli->real_escape_string($rand_username),
            $mysqli->real_escape_string($rand_password_hashed)
        );

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            return true;
        } else return $stmt->error;
        // Close statement
        $stmt->close();
    } else return $mysqli->error;
}


/**
 * Create a dummy client.
 * 
 * @return{integer|string} - client id if everything is ok, string containing the error.
 */
function create_dummy_client()
{

    global $mysqli;

    // Generate the random login data for the user.
    // We generate a random password, which the client does not know...maybe email it to them later.
    $rand_username = gen_random_string(40);
    $rand_password = gen_random_string(10);
    $rand_password_hashed =  password_hash($rand_password, PASSWORD_DEFAULT); // Creates a password hash

    $email = $rand_username . "@" . $rand_username . ".com";

    // Prepare an insert statement
    $sql = "INSERT INTO vorreiter_clients (
     company_name,
     salutation,
     email,
     phone,
     street,
     house_number,
     postal_code,
     first_name,
     last_name,
     title,
     fax,
     mobile_phone,
     shorthand,
     place,
     country,
     phone_central,
     additional_text,
     username,
     password)
     VALUES ('TBD', 'TBD', ?, 'TBD', 'TBD', 0, 0, 'TBD', 'TBD', 'TBD', 'TBD', 'TBD', 'TBD', 'TBD', 'TBD', 'TBD', 'TBD', ?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {
        // Attempt to execute the prepared statement
        $stmt->bind_param(
            "sss",
            $mysqli->real_escape_string(trim($email)),
            $mysqli->real_escape_string(trim($rand_username)),
            $mysqli->real_escape_string(trim($rand_password_hashed))
        );
        if ($stmt->execute()) {
            // Return the cient id.
            return $mysqli->insert_id;
        } else return $stmt->error;

        // Close statement
        $stmt->close();
    } else return $mysqli->error;

}
