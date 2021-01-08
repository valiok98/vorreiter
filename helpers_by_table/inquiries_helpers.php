<?php
// This file contains all the helper functions for extracting data from the vorreiter_inquiries table.
// All getters should always return a row(s).
// All setters should always set using the ID of the entry.
// For general helper functions refer to ../helpers_general/helpers.php


require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../definitions.php';
require_once dirname(__FILE__) . '/packages_helpers.php';
require_once dirname(__FILE__) . '/clients_helpers.php';
require_once dirname(__FILE__) . '/pickup_address_helpers.php';
require_once dirname(__FILE__) . '/delivery_address_helpers.php';
require_once dirname(__FILE__) . '/../templates/constants/countries.const.php';



/**
 * Get the data for an inquiry using its id.
 * 
 * @param{$id} - the inquiry's id.
 * @return{$inquiryData} - the whole row containing all inquiry properties.
 */
function get_inquiry_by_id($inquiryId)
{
    global $mysqli;

    $inquiryId = intval($inquiryId);
    $sql = "SELECT * FROM vorreiter_inquiries WHERE id = ?";

    if ($stmt = $mysqli->prepare($sql)) {

        $stmt->bind_param("i", $mysqli->real_escape_string($inquiryId));

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $inquiryData = $result->fetch_assoc();
            if ($inquiryData && $mysqli->affected_rows === 1) {
                return $inquiryData;
            }
        } else return $stmt->error;
    } else return $mysqli->error;
}



/**
 * Create the inquiry and the packages that belong to it.
 * 
 * @param{$inquiryData} - the inquiry data.
 * 
 * @return{boolean|string} - true if everything is ok, string containing the error.
 */
function create_inquiry($inquiryData)
{
    global $mysqli;

    $sql = "INSERT INTO vorreiter_inquiries
        (postal_code_start,
        postal_code_end,
        time_window,
        delivery_day,
        client_id,
        pickup_address_id,
        delivery_address_id,
        contact_wish) 
        VALUES (?, ?, ?, ?, ? , ?, ?, 'phone')";

    if ($stmt = $mysqli->prepare($sql)) {


        $pickupAddress = $inquiryData['from_address'];
        $deliveryAddress = $inquiryData['to_address'];

        // Get the client data.
        $clientData = get_client_by_id(intval($inquiryData['client_id']));

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

        $stmt->bind_param(
            "iissiii",
            $mysqli->real_escape_string(intval($inquiryData['postal_code_start'])),
            $mysqli->real_escape_string(intval($inquiryData['postal_code_end'])),
            $mysqli->real_escape_string(trim($inquiryData['time_window'])),
            $mysqli->real_escape_string(trim($inquiryData['delivery_day'])),
            $mysqli->real_escape_string(intval($inquiryData['client_id'])),
            $mysqli->real_escape_string(intval($responsePickup)),
            $mysqli->real_escape_string(intval($responseDelivery))
        );

        if ($stmt->execute()) {
            return create_inquiry_packages($inquiryData['packages'], $mysqli->insert_id);
        } else return $stmt->error;
        $stmt->close();
    } else return $mysqli->error;
}


/**
 * Create the dummy inquiry and the packages that belong to it.
 * Also create a dummy client, to whom the inquiry belongs.
 * 
 * @param{$inquiryData} - the inquiry data.
 * 
 * @return{boolean|string} - true if everything is ok, string containing the error.
 */
function create_dummy_inquiry($inquiryData)
{
    global $mysqli;
    // Create the dummy client and get its id.
    $clientId = create_dummy_client();

    // Check if there was an error while creating the pickup address.
    // On success we get the pickup address id (integer).
    if (gettype($clientId) === 'string') {
        return $clientId;
    }

    if ($clientId) {

        $sql = "INSERT INTO vorreiter_inquiries
        (postal_code_start,
        postal_code_end,
        time_window,
        delivery_day,
        client_id,
        pickup_address_id,
        delivery_address_id,
        contact_wish) 
        VALUES (?, ?,  ?, ?,  ? , ?, ?, 'phone')";

        if ($stmt = $mysqli->prepare($sql)) {

            // Get the client data.
            $clientData = get_client_by_id($clientId);

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

            $stmt->bind_param(
                "iissiii",
                $mysqli->real_escape_string(intval($inquiryData['postal_code_start'])),
                $mysqli->real_escape_string(intval($inquiryData['postal_code_end'])),
                $mysqli->real_escape_string(trim($inquiryData['time_window'])),
                $mysqli->real_escape_string(trim($inquiryData['delivery_day'])),
                $mysqli->real_escape_string(intval($clientId)),
                $mysqli->real_escape_string(intval($responsePickup)),
                $mysqli->real_escape_string(intval($responseDelivery))
            );

            if ($stmt->execute()) {
                return create_inquiry_packages($inquiryData['packages'], $mysqli->insert_id);
            } else return $stmt->error;

            $stmt->close();
        } else return $mysqli->error;
    }
}

/**
 * Get the data for all the inquiries.
 * 
 * @return{$inquiries} - all the inquiries.
 */
function get_table_inquiries()
{
    global $mysqli;
    $sql = "SELECT * FROM vorreiter_inquiries ORDER BY timestamp DESC";

    if ($stmt = $mysqli->prepare($sql)) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $inquiries = [];
            while ($row = $result->fetch_assoc()) {
                array_push($inquiries, inquiry_row($row));
            }
            return $inquiries;
        } else return $stmt->error;
    } else return $mysqli->error;
}


function inquiry_row($inquiry)
{
    global $countries_code;

    $row_return = [];

    $status_color = '';
    switch ($inquiry['status']) {
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

    $client_data = get_client_by_id($inquiry['client_id']);
    $pickup_address = get_pickup_address_by_id($inquiry['pickup_address_id']);
    $lieferadresse = get_delivery_address_by_id($inquiry['delivery_address_id']);
    $packages = get_packages_by_order_id($inquiry['id']);

    $row_return['client_data'] = $client_data;
    $row_return['packages'] = $packages;
    $row_return['created_at'] = date_format(date_create($inquiry['timestamp']), "H:i d/m/Y");
    $row_return['pickup_postal_code'] = $pickup_address['postal_code'];
    $row_return['pickup_country'] = $countries_code[$pickup_address['country']];
    $row_return['delivery_postal_code'] = $lieferadresse['postal_code'];
    $row_return['delivery_country'] = $countries_code[$lieferadresse['country']];
    $row_return['status'] = $inquiry['status'];
    $row_return['status_color'] = $status_color;

    return $row_return;
}