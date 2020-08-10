<?php
require_once dirname(__FILE__) . '/../../config.php';
require_once dirname(__FILE__) . '/../../definitions.php';


if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {

    $post_data = json_decode(file_get_contents('php://input'), true);
    $client_name = $post_data["clientName"];
    $sql = "SELECT * FROM kunden WHERE firmenname LIKE '%" . $client_name . "%'";

    if ($stmt = $mysqli->prepare($sql)) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $client_data = [];
            while ($row = $result->fetch_assoc()) {
                array_push($client_data, $row);
            }
            echo json_encode(array("success" => true, "clients" => $client_data));
        } else echo json_encode(array("success" => false));
    } else echo json_encode(array("success" => false));
}
