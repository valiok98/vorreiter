<?php
// This file contains all the helper functions for extracting data from the vorreiter_pickup_address table.
// All getters should always return a row(s).
// All setters should always set using the ID of the entry.
// For general helper functions refer to ../helpers_general/helpers.php


require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../definitions.php';
require_once dirname(__FILE__) . '/../helpers_general/helpers.php';

/**
 * Get the data for a pickup_address using it's id.
 * 
 * @param{$addressId} - the address' id.
 * @return{$pickupAddress} - the whole row containing all pickup address properties.
 */
function get_pickup_address_by_id($addressId)
{
    global $mysqli;
    $addressId = intval($addressId);
    $sql = "SELECT * FROM vorreiter_pickup_address WHERE id = ?";

    if ($stmt = $mysqli->prepare($sql)) {

        $stmt->bind_param("i", $mysqli->real_escape_string($addressId));

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $pickupAddress = $result->fetch_assoc();
            if ($pickupAddress && $mysqli->affected_rows === 1) {
                return $pickupAddress;
            } else return $stmt->error;
        } else return $mysqli->error;
    }
}


/**
 * Create the pickup address belonging to the order.
 */
function create_pickup_address($pickupAddressData)
{
    global $mysqli;

    $sql = "INSERT INTO vorreiter_pickup_address
        (
        company_name,
        salutation,
        title,
        first_name,
        last_name,
        phone,
        email,
        street,
        house_number,
        postal_code,
        place,
        country,
        fax
        ) VALUES (?, ?, ?, ?,     ?, ?, ?, ?,   ?, ?, ?, ?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param(
            "ssssssssiisss",
            $mysqli->real_escape_string(trim($pickupAddressData['company_name'])),
            $mysqli->real_escape_string(trim($pickupAddressData['salutation'])),
            $mysqli->real_escape_string(trim($pickupAddressData['title'])),
            $mysqli->real_escape_string(trim($pickupAddressData['first_name'])),
            $mysqli->real_escape_string(trim($pickupAddressData['last_name'])),
            $mysqli->real_escape_string(trim($pickupAddressData['phone'])),
            $mysqli->real_escape_string(trim($pickupAddressData['email'])),
            $mysqli->real_escape_string(trim($pickupAddressData['street'])),
            $mysqli->real_escape_string(intval($pickupAddressData['house_number'])),
            $mysqli->real_escape_string(intval($pickupAddressData['postal_code'])),
            $mysqli->real_escape_string(trim($pickupAddressData['place'])),
            $mysqli->real_escape_string(trim($pickupAddressData['country'])),
            $mysqli->real_escape_string(trim($pickupAddressData['fax']))
        );

        if ($stmt->execute()) {
            return $mysqli->insert_id;
        } else return $stmt->error;
        $stmt->close();
    } else return $mysqli->error;
}
