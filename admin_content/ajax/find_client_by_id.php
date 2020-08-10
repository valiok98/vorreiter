<?php
require_once dirname(__FILE__) . '/../../config.php';
require_once dirname(__FILE__) . '/../../definitions.php';


if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {

    $post_data = file_get_contents('php://input');

    $client_id = intval($post_data['client_id']);
    $sql = "SELECT * FROM kunden WHERE id = " . $client_id;

    if ($stmt = $mysqli->prepare($sql)) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $client_data = [];
            while ($row = $result->fetch_assoc()) {
                array_push($client_data, $row);
            }
            echo json_encode(array("success" => true, "client_data" => $client_data));
        } else echo json_encode(array("success" => false));
    } else echo json_encode(array("success" => false));
}
