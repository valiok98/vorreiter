<?php
// This file contains all the helper functions for extracting data from the vorreiter_admin_users table.
// All getters should always return a row(s).
// All setters should always set using the ID of the entry.
// For general helper functions refer to ../helpers_general/helpers.php


require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../definitions.php';
require_once dirname(__FILE__) . '/../helpers_general/helpers.php';


/**
 * Get the admin data for a single admin using their email.
 * 
 * @param{$adminEmail} - the admin's email.
 * @return{$adminData} - the whole row containing all admin properties.
 */
function get_admin_by_email($adminEmail)
{
    global $mysqli;
    $sql = "SELECT * FROM vorreiter_admin_users WHERE email = ?";

    if ($stmt = $mysqli->prepare($sql)) {

        $stmt->bind_param("s", $mysqli->real_escape_string($adminEmail));

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $adminData = $result->fetch_assoc();
            if ($adminData && $mysqli->affected_rows === 1) {
                $stmt->close();
                return $adminData;
            }
        } else return $stmt->error;
    } else return $mysqli->error;
}

/**
 * Get the admin data for a single admin using their username.
 * 
 * @param{$adminUsername} - the admin's username.
 * @return{$adminData} - the whole row containing all admin properties.
 */
function get_admin_by_username($adminUsername)
{
    global $mysqli;
    $sql = "SELECT * FROM vorreiter_admin_users WHERE username = ?";

    if ($stmt = $mysqli->prepare($sql)) {

        $stmt->bind_param("s", $mysqli->real_escape_string($adminUsername));

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $adminData = $result->fetch_assoc();
            if ($adminData && $mysqli->affected_rows === 1) {
                $stmt->close();
                return $adminData;
            }
        } else return $stmt->error;
    } else return $mysqli->error;
}

/**
 * Set the admin renew password URL string part and the expiration date.
 * 
 * @param{$adminID} - the ID of the admin, who requested to change their password.
 * @return{$renewPassURL} - the URL string part, where the admin can change their password.
 */
function set_admin_renew_pass_url($adminID)
{

    global $mysqli;

    $sql = "UPDATE vorreiter_admin_users SET renew_pass_url = ?, renew_pass_date = (NOW() + INTERVAL 1 HOUR) WHERE id = ?";

    $renewPassURL = gen_random_string(10);

    if ($stmt = $mysqli->prepare($sql)) {

        $stmt->bind_param(
            "si",
            $mysqli->real_escape_string(trim($renewPassURL)),
            $mysqli->real_escape_string(intval($adminID))
        );

        if ($stmt->execute() && $mysqli->affected_rows === 1) {
            $stmt->close();
            return $renewPassURL;
        } else return $stmt->error;
    } else return $mysqli->error;
}



/**
 * Set the admin's new password.
 * 
 * @param{$adminID} - the ID of the admin, who requested to change their password.
 * @return{$success} - true if the update was successful.
 */
function set_admin_new_pass($adminID, $inputPass)
{

    global $mysqli;

    $sql = "UPDATE vorreiter_admin_users SET password = ?, renew_pass_date = NULL, renew_pass_url = NULL WHERE id = ?";

    if ($stmt = $mysqli->prepare($sql)) {

        $hashedPassword = password_hash($inputPass, PASSWORD_DEFAULT); // Creates a password hash

        $stmt->bind_param(
            "si",
            $mysqli->real_escape_string($hashedPassword),
            $mysqli->real_escape_string($adminID)
        );

        if ($stmt->execute() && $mysqli->affected_rows === 1) {
            $stmt->close();
            return true;
        } else return $stmt->error;
    } else return $mysqli->error;
}



/**
 * Create an admin.
 * 
 * @param{$adminData} - the admin data.
 * 
 * @return{boolean|string} - true if everything is ok, string containing the error.
 */
function create_admin($adminData)
{
    global $mysqli;
    
    $hashedPassword = trim($_POST['password']);
    $hashedPassword =  password_hash($hashedPassword, PASSWORD_DEFAULT); // Creates a password hash
    $username = gen_random_admin_username();
    
    
    $sql = "INSERT INTO vorreiter_admin_users
        (username,
        password,
        email,
        full_name)
        VALUES (?, ?, ?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {

        $stmt->bind_param(
            "ssss",
            $mysqli->real_escape_string($username),
            $mysqli->real_escape_string($hashedPassword),
            $mysqli->real_escape_string(trim($adminData['email'])),
            $mysqli->real_escape_string(trim($adminData['full_name']))
        );

        if ($stmt->execute()) {
            return true;
        } else return $stmt->error;
        $stmt->close();
    } else return $mysqli->error;
}



function gen_random_admin_username($length=20)
{
    global $mysqli;

    $username = '';

    do {
        $username = gen_random_string($length);
        $username_invalid = true;

        $sql = "SELECT id FROM vorreiter_admin_users WHERE username = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param(
                "s",
                $mysqli->real_escape_string(trim($username))
            );

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 0) {
                    $username_invalid = false;
                }
            }
        }
    } while ($username_invalid);

    return $username;
}