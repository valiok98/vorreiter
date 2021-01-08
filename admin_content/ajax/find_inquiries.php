<?php
require_once dirname(__FILE__) . '/../../helpers_by_table/inquiries_helpers.php';


if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {
    $inquiries = get_inquiries();
    if (gettype($inquiries) === 'string') {
        echo_failure("Die Daten zu den Anfragen konnten nicht geladen werden.");
    } else {
        echo json_encode(array("success" => true, "inquiries" => $inquiries));
    }
}
