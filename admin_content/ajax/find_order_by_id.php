<?php
require_once dirname(__FILE__) . '/get_data_helpers.php';


if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {
    $data = [];
    $postData = json_decode(file_get_contents('php://input'), true);
    $orderId = intval($postData['id']);
    $orderData = get_order_by_id($orderId);
    if (!$orderData) {
        echo json_encode(array("success" => false));
    } else {
        $data = $orderData;
        // Get the client data.
        $clientId = $data['kunden_id'];
        $clientData = get_client_by_id($clientId);
        if (!$clientData) {
            echo json_encode(array("success" => false));
        } else {
            $data = array_merge($data, ["clientData" => $clientData]);
            // Get the packages data.
            $packages = get_packages_by_order_id($orderId);
            if (!$packages) {
                echo json_encode(array("success" => false));
            } else {
                $data = array_merge($data, ["packages" => $packages]);
                // Get the pickup address.
                $pickupAddress = get_pickup_address_by_id($data['abholadresse_id']);
                if (!$packages) {
                    echo json_encode(array("success" => false));
                } else {
                    $data = array_merge($data, ["abholadresse" => $pickupAddress]);
                    // Get the delivery address.
                    $deliveryAddress = get_delivery_address_by_id($data['lieferadresse_id']);
                    if (!$packages) {
                        echo json_encode(array("success" => false));
                    } else {
                        $data = array_merge($data, ["lieferadresse" => $deliveryAddress]);
                        echo json_encode(array("success" => true, "orderData" => $data));
                    }
                }
            }
        }
    }
}
