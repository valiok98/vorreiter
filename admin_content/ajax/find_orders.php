<?php
require_once dirname(__FILE__) . '/../../helpers_by_table/orders_helpers.php';


if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {
    $orders = get_orders();
    if (gettype($orders) === 'string') {
        echo_failure("Die Daten zu den Aufträgen konnten nicht geladen werden.");
    } else {
        echo json_encode(array("success" => true, "orders" => $orders));
    }
}
