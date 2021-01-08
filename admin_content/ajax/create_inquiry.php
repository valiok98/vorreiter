<?php
require_once dirname(__FILE__) . '/../../helpers_by_table/inquiries_helpers.php';


if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {
    $post_data = json_decode(file_get_contents('php://input'), true);
    $response = create_inquiry($post_data);

    // Check if the response is true, otherwise send the error message.
    if (gettype($response) === 'integer') {
        // Get the newly created inquiry.
        $inquiry = get_inquiry_by_id($response);
        if (gettype($inquiry) === 'string') {
            echo_failure($inquiry);
        } else {
            // Convert the newly created inquiry to the table format for display.
            $inquiry = get_inquiry_row($inquiry);
            echo json_encode(array("success" => true, "inquiry" => $inquiry));
        }
    } else {
        echo_failure($response);
    }
}
