<?php
require_once dirname(__FILE__) . '/get_data_helpers.php';


if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {
    $data = [];
    $postData = json_decode(file_get_contents('php://input'), true);
    $inquiryId = intval($postData['id']);
    $inquiryData = get_inquiry_by_id($inquiryId);
    if (!$inquiryData) {
        echo json_encode(array("success" => false));
    } else {
        $data = $inquiryData;
        // Get the client data.
        $clientId = $data['kunden_id'];
        $clientData = get_client_by_id($clientId);
        if (!$clientData) {
            echo json_encode(array("success" => false));
        } else {
            $data = array_merge($data, ["clientData" => $clientData]);
            // Get the packages data.
            $packages = get_packages_by_inquiry_id($inquiryId);
            if (!$packages) {
                echo json_encode(array("success" => false));
            } else {
                $data = array_merge($data, ["packages" => $packages]);
                echo json_encode(array("success" => true, "inquiryData" => $data));
            }
        }
    }
}
