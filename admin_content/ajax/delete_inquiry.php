<?php
require_once dirname(__FILE__) . '/../../helpers_by_table/inquiries_helpers.php';
require_once dirname(__FILE__) . '/../../helpers_general/helpers.php';


if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {
    $data = [];
    $post_data = json_decode(file_get_contents('php://input'), true);
    $inquiry_id = intval($post_data['inquiry_id']);
    $response = delete_inquiry_by_id($inquiry_id);
    if (gettype($response) === 'string') {
        echo_failure("Die Daten zur Anfrage konnten nicht gefunden werden.");
    } else {
        echo json_encode(array("success" => true));
    }
}
