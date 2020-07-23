<?php
require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../definitions.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['client_data']) && !empty($_POST['client_data'])) {
    $client_data = $_POST['client_data'];
    $sql = "SELECT id, firmenname, plz, ort FROM kunden WHERE firmenname LIKE '%" . $client_data . "%'";

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
