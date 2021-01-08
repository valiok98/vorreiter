<?php
// Set the header for remote access.
header('Access-Control-Allow-Origin: https://wirliefernsicher.de');  
require_once dirname(__FILE__) . '/../../helpers_by_table/inquiries_helpers.php';
require_once dirname(__FILE__) . '/../../helpers_general/helpers.php';

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {

    $response = create_dummy_inquiry($_POST);
    // Check if the response is true, otherwise send the error message.
    if ($response === true) {
        echo json_encode(array("success" => true));
    } else {
        echo_failure($response);
    }
}