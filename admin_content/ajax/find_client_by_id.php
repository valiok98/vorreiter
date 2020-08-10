<?php
require_once dirname(__FILE__) . '/../../config.php';
require_once dirname(__FILE__) . '/../../definitions.php';


if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {

    $postData = json_decode(file_get_contents('php://input'), true);
    $clientId = intval($postData['clientId']);
    $sql = "SELECT * FROM kunden WHERE id = " . $clientId;

    if ($stmt = $mysqli->prepare($sql)) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($clientData = $result->fetch_assoc()) {
                echo json_encode(array("success" => true, "clientData" => $clientData));
            }
        } else echo json_encode(array("success" => false));
    } else echo json_encode(array("success" => false));
}
