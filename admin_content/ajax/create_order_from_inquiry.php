<?php
require_once dirname(__FILE__) . '/../../helpers_by_table/orders_helpers.php';


if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {
    $post_data = json_decode(file_get_contents('php://input'), true);
    $response = create_order_from_inquiry($post_data);

    // Check if the response is true, otherwise send the error message.
    if (gettype($response) === 'integer') {
        // Get the newly created order.
        $order = get_order_by_id($response);
        if (gettype($order) === 'string') {
            echo_failure($order);
        } else {
            // Convert the newly created order to the table format for display.
            $order = get_order_row($order);
            echo json_encode(array("success" => true, "order" => $order));
        }
    } else {
        echo_failure($response);
    }
}
