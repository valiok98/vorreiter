<?php
require_once dirname(__FILE__) . '/../../helpers_by_table/clients_helpers.php';
require_once dirname(__FILE__) . '/../../helpers_general/helpers.php';


if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {

    $post_data = json_decode(file_get_contents('php://input'), true);
    $client_name = $post_data["client_name"];
    $client_data = get_client_by_name($client_name);
    // Remove the password for security reasons.
    unset($client_data['password']);
    if (gettype($client_data) === 'string') {
        echo_failure("Die Daten zum Kunden konnten nicht geladen werden.");
    } else {
        echo json_encode(array("success" => true, "client_data" => $client_data));
    }
}
