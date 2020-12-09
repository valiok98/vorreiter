<?php
// This file contains all the helper functions for extracting data from the vorreiter_admin_users table.
// All getters should always return a row(s).
// All setters should always set using the ID of the entry.
// For general helper functions refer to ../helpers_general/helpers.php


require_once dirname(__FILE__) . '/../../config.php';
require_once dirname(__FILE__) . '/../../definitions.php';
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
            if ($adminData = $result->fetch_assoc()) {
                return $adminData;
            }
        } else return false;
    } else return false;
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
            if ($adminData = $result->fetch_assoc() && $mysqli->affected_rows === 1) {
                return $adminData;
            }
        } else return false;
    } else return false;
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

    $sql = "UPDATE vorreiter_admin_users SET renew_pass_url = ? AND renew_pass_date = ? WHERE id = ?";

    $renewPassURL = gen_random_string();
    $renewPassDate = time() + 3600;

    if ($stmt = $mysqli->prepare($sql)) {

        $stmt->bind_param(
            "sii",
            $mysqli->real_escape_string($renewPassURL),
            $mysqli->real_escape_string($renewPassDate),
            $mysqli->real_escape_string($adminID)
        );

        if ($stmt->execute() && $mysqli->affected_rows === 1) {
            return $renewPassURL;
        } else return false;
    } else return false;
}
