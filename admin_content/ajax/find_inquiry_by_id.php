<?php
require_once dirname(__FILE__) . '/../../helpers_by_table/inquiries_helpers.php';
require_once dirname(__FILE__) . '/../../helpers_by_table/clients_helpers.php';
require_once dirname(__FILE__) . '/../../helpers_by_table/packages_helpers.php';
require_once dirname(__FILE__) . '/../../helpers_general/helpers.php';


if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {
    $data = [];
    $post_data = json_decode(file_get_contents('php://input'), true);
    $inquiry_id = intval($post_data['inquiry_id']);
    $inquiry_data = get_inquiry_by_id($inquiry_id);
    if (gettype($inquiry_data) === 'string') {
        echo_failure("Die Daten zur Anfrage konnten nicht geladen werden.");
    } else {
        $data = $inquiry_data;
        // Get the client data.
        $client_id = $data['client_id'];
        $client_data = get_client_by_id($client_id);
        // Remove the password for security reasons.
        unset($client_data['password']);
        if (gettype($client_data) === 'string') {
            echo_failure("Die Daten zum Kunden konnten nicht geladen werden.");
        } else {
            $data = array_merge($data, ["client_data" => $client_data]);
            // Get the packages data.
            $packages = get_packages_by_inquiry_id($inquiry_id);
            if (gettype($packages) === 'string') {
                echo_failure("Die Daten zu den Paketen konnten nicht geladen werden.");
            } else {
                $data = array_merge($data, ["packages" => $packages]);
                // Get the pickup address.
                $pickup_address = get_pickup_address_by_id($data['pickup_address_id']);
                if (gettype($pickup_address) === 'string') {
                    echo_failure("Die Daten zur Abholadresse konnten nicht geladen werden.");
                } else {
                    $data = array_merge($data, ["pickup_address" => $pickup_address]);
                    // Get the delivery address.
                    $delivery_address = get_delivery_address_by_id($data['delivery_address_id']);
                    if (gettype($delivery_address) === 'string') {
                        echo_failure("Die Daten zur Lieferadresse konnten nicht geladen werden.");
                    } else {
                        $data = array_merge($data, ["delivery_address" => $delivery_address]);
                        echo json_encode(array("success" => true, "inquiry_data" => $data));
                    }
                }
            }
        }
    }
}
