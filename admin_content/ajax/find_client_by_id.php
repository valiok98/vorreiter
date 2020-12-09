<?php
require_once dirname(__FILE__) . '/get_data_helpers.php';


if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {

    $postData = json_decode(file_get_contents('php://input'), true);
    $id = intval($postData['id']);
    $clientData = get_client_by_id($id);
    if ($clientData) {
        echo json_encode(array("success" => true, "clientData" => $clientData));
    } else echo json_encode(array("success" => false));
}
