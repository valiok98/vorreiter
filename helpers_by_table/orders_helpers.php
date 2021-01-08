<?php
// This file contains all the helper functions for extracting data from the vorreiter_orders table.
// All getters should always return a row(s).
// All setters should always set using the ID of the entry.
// For general helper functions refer to ../helpers_general/helpers.php


require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../definitions.php';
require_once dirname(__FILE__) . '/inquiries_helpers.php';
require_once dirname(__FILE__) . '/packages_helpers.php';
require_once dirname(__FILE__) . '/pickup_address_helpers.php';
require_once dirname(__FILE__) . '/delivery_address_helpers.php';
require_once dirname(__FILE__) . '/../templates/constants/countries.const.php';


/**
 * Get the data for an order using its id.
 * 
 * @param{$id} - the order's id.
 * @return{$orderData} - the whole row containing all order properties.
 */
function get_order_by_id($orderId)
{
    global $mysqli;
    $orderId = intval($orderId);
    $sql = "SELECT * FROM vorreiter_orders WHERE id = ?";

    if ($stmt = $mysqli->prepare($sql)) {

        $stmt->bind_param("i", $mysqli->real_escape_string($orderId));

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $orderData = $result->fetch_assoc();
            if ($orderData && $mysqli->affected_rows === 1) {
                return $orderData;
            }
        } else return $stmt->error;
    } else return $mysqli->error;
}


/**
 * Create the order and the packages/pickup/delivery address that belong to it.
 * 
 * @param{$orderData} - the order data.
 * 
 * @return{boolean|string} - true if everything is ok, string containing the error.
 */
function create_order($orderData)
{

    global $mysqli;

    $sql = "INSERT INTO vorreiter_orders
        (
        time_window,
        delivery_day,
        volume_weight,
        tracking_number,
        client_id,
        pickup_address_id,
        delivery_address_id) VALUES (?, ?, ?, ?,?, ?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {

        $pickupAddress = $orderData['from_address'];
        $deliveryAddress = $orderData['to_address'];
        // Get the client data.
        $clientData = get_client_by_id(intval($orderData['client_id']));

        if (count($pickupAddress['same_address'])) {
            $pickupAddress['company_name'] = $clientData['company_name'];
            $pickupAddress['salutation'] = $clientData['salutation'];
            $pickupAddress['title'] = $clientData['title'];;
            $pickupAddress['first_name'] = $clientData['first_name'];
            $pickupAddress['last_name'] = $clientData['last_name'];
            $pickupAddress['phone'] = $clientData['phone'];
            $pickupAddress['email'] = $clientData['email'];
            $pickupAddress['street'] = $clientData['street'];
            $pickupAddress['house_number'] = $clientData['house_number'];
            $pickupAddress['postal_code'] = $clientData['postal_code'];
            $pickupAddress['place'] = $clientData['place'];
            $pickupAddress['country'] = $clientData['country'];
        }

        if (count($pickupAddress['same_address'])) {
            $deliveryAddress['company_name'] = $clientData['company_name'];
            $deliveryAddress['salutation'] = $clientData['salutation'];
            $deliveryAddress['title'] = $clientData['title'];;
            $deliveryAddress['first_name'] = $clientData['first_name'];
            $deliveryAddress['last_name'] = $clientData['last_name'];
            $deliveryAddress['phone'] = $clientData['phone'];
            $deliveryAddress['email'] = $clientData['email'];
            $deliveryAddress['street'] = $clientData['street'];
            $deliveryAddress['house_number'] = $clientData['house_number'];
            $deliveryAddress['postal_code'] = $clientData['postal_code'];
            $deliveryAddress['place'] = $clientData['place'];
            $deliveryAddress['country'] = $clientData['country'];
        }


        $responsePickup = create_pickup_address($pickupAddress);
        // Check if there was an error while creating the pickup address.
        // On success we get the pickup address id (integer).
        if (gettype($responsePickup) === 'string') {
            return $responsePickup;
        }
        $responseDelivery = create_delivery_address($deliveryAddress);
        // Check if there was an error while creating the delivery address.
        // On success we get the delivery address id (integer).
        if (gettype($responseDelivery) === 'string') {
            return $responseDelivery;
        }
        // Create a random tracking number.
        $trackingNumber = rand(100000000, 999999999);

        $stmt->bind_param(
            "ssiiiii",
            $mysqli->real_escape_string(trim($orderData['time_window'])),
            $mysqli->real_escape_string(trim($orderData['delivery_day'])),
            $mysqli->real_escape_string(intval($orderData['volume_weight'])),
            $mysqli->real_escape_string(intval($trackingNumber)),
            $mysqli->real_escape_string(intval($orderData['client_id'])),
            $mysqli->real_escape_string(intval($responsePickup)),
            $mysqli->real_escape_string(intval($responseDelivery))
        );

        if ($stmt->execute()) {
            return create_order_packages($orderData['packages'], $mysqli->insert_id);
        } else return $stmt->error;

        $stmt->close();
    } else return $mysqli->error;
}


/**
 * Create the order and the packages/pickup/delivery address that belong to it from a given inquiry.
 * 
 * @param{$data} - the data {inquiry_id, pickup_address, delivery_address}.
 * 
 * @return{boolean|string} - true if everything is ok, string containing the error.
 */
function create_order_from_inquiry($data)
{

    global $mysqli;

    $sql = "INSERT INTO vorreiter_orders
        (
        time_window,
        delivery_day,
        volume_weight,
        tracking_number,
        client_id,
        pickup_address_id,
        delivery_address_id) VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {

        $pickupAddress = $data['from_address'];
        $deliveryAddress = $data['to_address'];

        // Get the inquiry data.
        $inquiryData = get_inquiry_by_id(intval($data['inquiry_id']));
        // On success we get the inquiry.
        if (gettype($inquiryData) === 'string') {
            return $inquiryData;
        }

        // Get the pickup address data.
        $pickupAddressData = get_pickup_address_by_id(intval($inquiryData['pickup_address_id']));
        // On success we get the pickup address.
        if (gettype($pickupAddressData) === 'string') {
            return $pickupAddressData;
        }

        // Get the delivery address data.
        $deliveryAddressData = get_delivery_address_by_id(intval($inquiryData['delivery_address_id']));
        // On success we get the delivery address.
        if (gettype($deliveryAddressData) === 'string') {
            return $deliveryAddressData;
        }

        // Get the inquiry's packages.
        $packages = get_packages_by_inquiry_id(intval($data['inquiry_id']));
        // On success we get the packages.
        if (gettype($packages) === 'string') {
            return $packages;
        }

        if (count($pickupAddress['same_address'])) {
            $pickupAddress = $pickupAddressData;
        }

        if (count($deliveryAddress['same_address'])) {
            $deliveryAddress = $deliveryAddressData;
        }

        $responsePickup = create_pickup_address($pickupAddress);
        // Check if there was an error while creating the pickup address.
        // On success we get the pickup address id (integer).
        if (gettype($responsePickup) === 'string') {
            return $responsePickup;
        }
        $responseDelivery = create_delivery_address($deliveryAddress);
        // Check if there was an error while creating the delivery address.
        // On success we get the delivery address id (integer).
        if (gettype($responseDelivery) === 'string') {
            return $responseDelivery;
        }
        // Create a random tracking number.
        $trackingNumber = rand(100000000, 999999999);


        $stmt->bind_param(
            "ssiiiii",
            $mysqli->real_escape_string(trim($inquiryData['time_window'])),
            $mysqli->real_escape_string(trim($inquiryData['delivery_day'])),
            $mysqli->real_escape_string(intval($inquiryData['volume_weight'])),
            $mysqli->real_escape_string(intval($trackingNumber)),
            $mysqli->real_escape_string(intval($inquiryData['client_id'])),
            $mysqli->real_escape_string(intval($responsePickup)),
            $mysqli->real_escape_string(intval($responseDelivery))
        );

        if ($stmt->execute()) {
            return create_order_packages($packages, $mysqli->insert_id);
        } else return $stmt->error;

        $stmt->close();
    } else return $mysqli->error;
}

/**
 * Get the data for all the orders.
 * 
 * @return{$orders} - all the orders.
 */
function get_orders()
{
    global $mysqli;
    $sql = "SELECT * FROM vorreiter_orders ORDER BY timestamp DESC";

    if ($stmt = $mysqli->prepare($sql)) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $orders = [];
            while ($row = $result->fetch_assoc()) {
                array_push($orders, order_row($row));
            }
            return $orders;
        } else return $stmt->error;
    } else return $mysqli->error;
}

function order_row($order)
{
    global $countries_code;

    $row_return = [];

    $status_color = '';
    switch ($order['status']) {
        case "offen":
            $status_color = 'red';
            break;
        case "ausstehend":
            $status_color = 'orange';
            break;
        case "abgelehnt":
            $status_color = 'purple';
            break;
        case "beauftragt":
            $status_color = 'green';
            break;
    }

    $client_data = get_client_by_id($order['client_id']);
    $pickup_address = get_pickup_address_by_id($order['pickup_address_id']);
    $lieferadresse = get_delivery_address_by_id($order['delivery_address_id']);
    $packages = get_packages_by_order_id($order['id']);

    $row_return['client_data'] = $client_data;
    $row_return['packages'] = $packages;
    $row_return['created_at'] = date_format(date_create($order['timestamp']), "H:i d/m/Y");
    $row_return['pickup_postal_code'] = $pickup_address['postal_code'];
    $row_return['pickup_country'] = $countries_code[$pickup_address['country']];
    $row_return['delivery_postal_code'] = $lieferadresse['postal_code'];
    $row_return['delivery_country'] = $countries_code[$lieferadresse['country']];
    $row_return['status'] = $order['status'];
    $row_return['status_color'] = $status_color;

    return $row_return;
}
