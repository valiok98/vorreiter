<?php
// This file contains all the helper functions for extracting data from the vorreiter_delivery_address table.
// All getters should always return a row(s).
// All setters should always set using the ID of the entry.
// For general helper functions refer to ../helpers_general/helpers.php


require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../definitions.php';
require_once dirname(__FILE__) . '/../helpers_general/helpers.php';

/**
 * Get the data for a delivery_address using it's id.
 * 
 * @param{$addressId} - the address' id.
 * @return{$pickupAddress} - the whole row containing all delivery address properties.
 */

function get_delivery_address_by_id($addressId)
{
    global $mysqli;
    $addressId = intval($addressId);
    $sql = "SELECT * FROM vorreiter_delivery_address WHERE id = ?";

    if ($stmt = $mysqli->prepare($sql)) {

        $stmt->bind_param("i", $mysqli->real_escape_string($addressId));

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $deliveryAddress = $result->fetch_assoc();
            if ($deliveryAddress && $mysqli->affected_rows === 1) {
                return $deliveryAddress;
            } else return $stmt->error;
        } else return $mysqli->error;
    }
}

/**
 * Create the delivery address belonging to the order.
 */
function create_delivery_address($deliveryAddressData)
{
    global $mysqli;
    
    $sql = "INSERT INTO vorreiter_delivery_address
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
        country
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {

        $stmt->bind_param(
            "ssssssssiiss",
            $mysqli->real_escape_string(trim($deliveryAddressData['company_name'])),
            $mysqli->real_escape_string(trim($deliveryAddressData['salutation'])),
            $mysqli->real_escape_string(trim($deliveryAddressData['title'])),
            $mysqli->real_escape_string(trim($deliveryAddressData['first_name'])),
            $mysqli->real_escape_string(trim($deliveryAddressData['last_name'])),
            $mysqli->real_escape_string(trim($deliveryAddressData['phone'])),
            $mysqli->real_escape_string(trim($deliveryAddressData['email'])),
            $mysqli->real_escape_string(trim($deliveryAddressData['street'])),
            $mysqli->real_escape_string(intval($deliveryAddressData['house_number'])),
            $mysqli->real_escape_string(intval($deliveryAddressData['postal_code'])),
            $mysqli->real_escape_string(trim($deliveryAddressData['place'])),
            $mysqli->real_escape_string(trim($deliveryAddressData['country']))
        );

        if ($stmt->execute()) {
            return $mysqli->insert_id;
        } else return $stmt->error;
        $stmt->close();
    } else return $mysqli->error;
}