<?php
require_once dirname(__FILE__) . '/get_data_helpers.php';


if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {

    $post_data = json_decode(file_get_contents('php://input'), true);
    $clientName = $post_data["clientName"];
    $clientData = get_client_by_name($clientName);
    if ($clientData) {
        echo json_encode(array("success" => true, "clientData" => $clientData));
    } else echo json_encode(array("success" => false));
}
