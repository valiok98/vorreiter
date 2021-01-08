<?php
require_once dirname(__FILE__) . '/../../helpers_by_table/orders_helpers.php';
require_once dirname(__FILE__) . '/../../helpers_general/helpers.php';


if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {
    $post_data = json_decode(file_get_contents('php://input'), true);
    $response = create_order_from_inquiry($post_data);

    // Check if the response is true, otherwise send the error message.
    if ($response === true) {
        echo json_encode(array("success" => true));
    } else {
        echo_failure($response);
    }
}
