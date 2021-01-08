<?php
// This file contains all the helper functions for extracting data from the vorreiter_packages table.
// All getters should always return a row(s).
// All setters should always set using the ID of the entry.
// For general helper functions refer to ../helpers_general/helpers.php


require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../definitions.php';

/**
 * Get the data for a packages using an inquiry id.
 * 
 * @param{$inquiryId} - the inquiry's id.
 * @return{$packages} - the whole row containing all client properties.
 */
function get_packages_by_inquiry_id($inquiryId)
{
    global $mysqli;
    $inquiryId = intval($inquiryId);
    $sql = "SELECT * FROM vorreiter_packages WHERE inquiry_id = ?";

    if ($stmt = $mysqli->prepare($sql)) {

        $stmt->bind_param("i", $mysqli->real_escape_string($inquiryId));

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $packages = [];
            while ($row = $result->fetch_assoc()) {
                array_push($packages, $row);
            }
            return $packages;
        } else return $stmt->error;
    } else return $mysqli->error;
}




/**
 * Get the packages using an order id.
 * 
 * @param{$orderId} - the order's id.
 * @return{$packages} - the whole row containing all client properties.
 */

function get_packages_by_order_id($orderId)
{
    global $mysqli;
    $orderId = intval($orderId);
    $sql = "SELECT * FROM vorreiter_packages WHERE order_id = ?";

    if ($stmt = $mysqli->prepare($sql)) {

        $stmt->bind_param("i", $mysqli->real_escape_string($orderId));

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $packages = [];
            while ($row = $result->fetch_assoc()) {
                array_push($packages, $row);
            }
            return $packages;
        } else return $stmt->error;
    } else return $mysqli->error;
}


/**
 * Create the packages belonging to the inquiry.
 * 
 * @param{$mysqli} - the mysqli connection.
 * @param{$packages} - the packages' data.
 * @param{$inquiryId} - the inquiry's id.
 * 
 * @return{boolean|string} - true if everything is ok, string containing the error.
 */
function create_inquiry_packages($packages, $inquiryId)
{

    global $mysqli;

    foreach ($packages as $package) {
        $sql = "INSERT INTO vorreiter_packages
        (length,
        width,
        height,
        volume_weight,
        weight,
        girth,
        services,
        price,
        inquiry_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // VERY important:
        // Do not escape the servies array, because it would add backslashed to the strings inside the array. 
        // Hence the database would reject it(not proper json).
        if ($stmt = $mysqli->prepare($sql)) {

            // Check if the services is already encoded as a string.
            $services = $package['services'] || [];
            if (gettype($services) === 'array') {
                $services = json_encode($services);
            }
            
            $stmt->bind_param(
                "iiiiiisdi",
                $mysqli->real_escape_string(intval($package['length'])),
                $mysqli->real_escape_string(intval($package['width'])),
                $mysqli->real_escape_string(intval($package['height'])),
                $mysqli->real_escape_string(intval($package['volume_weight'])),
                $mysqli->real_escape_string(intval($package['weight'])),
                $mysqli->real_escape_string(intval($package['girth'])),
                $services,
                $mysqli->real_escape_string(doubleval($package['price'])),
                $mysqli->real_escape_string($inquiryId)
            );

            if (!$stmt->execute()) {
                return $stmt->error;
            }
            $stmt->close();
        } else return $mysqli->error;
    }
    return true;
}



/**
 * Create the packages belonging to the order.
 * 
 * @param{$mysqli} - the mysqli connection.
 * @param{$packages} - the packages' data.
 * @param{$orderId} - the order's id.
 * 
 * @return{boolean|string} - true if everything is ok, string containing the error.
 */
function create_order_packages($packages, $orderId)
{

    global $mysqli;

    foreach ($packages as $package) {
        $sql = "INSERT INTO vorreiter_packages
        (length,
        width,
        height,
        volume_weight,
        weight,
        girth,
        services,
        price,
        order_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // VERY important:
        // Do not escape the servies array, because it would add backslashed to the strings inside the array. 
        // Hence the database would reject it(not proper json).
        if ($stmt = $mysqli->prepare($sql)) {

            // Check if the services is already encoded as a string.
            $services = $package['services'] || [];
            if (gettype($services) === 'array') {
                $services = json_encode($services);
            }

            $stmt->bind_param(
                "iiiiiisdi",
                $mysqli->real_escape_string(intval($package['length'])),
                $mysqli->real_escape_string(intval($package['width'])),
                $mysqli->real_escape_string(intval($package['height'])),
                $mysqli->real_escape_string(intval($package['volume_weight'])),
                $mysqli->real_escape_string(intval($package['weight'])),
                $mysqli->real_escape_string(intval($package['girth'])),
                $services,
                $mysqli->real_escape_string(doubleval($package['price'])),
                $mysqli->real_escape_string($orderId)
            );

            if (!$stmt->execute()) {
                return $stmt->error;
            }
            $stmt->close();
        } else return $mysqli->error;
    }
    return true;
}
