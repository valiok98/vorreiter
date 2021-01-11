<?php
require_once dirname(__FILE__) . '/../../helpers_by_table/clients_helpers.php';


if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {
    $clients = get_table_clients();
    if (gettype($clients) === 'string') {
        echo_failure("Die Daten zu den Kunden konnten nicht geladen werden.");
    } else {
        echo json_encode(array("success" => true, "clients" => $clients));
    }
}
