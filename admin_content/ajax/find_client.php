<?php
require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../definitions.php';


if (
    $_SERVER['REQUEST_METHOD'] === 'POST' && (
        (isset($_POST['client_data']) && !empty($_POST['client_data'])) ||
        (isset($_POST['client_id']) && !empty($_POST['client_id'])))
) {

    $client_data = $_POST['client_data'];
    $client_id = intval($_POST['client_id']);
    if ($client_data) {
        $sql = "SELECT * FROM kunden WHERE firmenname LIKE '%" . $client_data . "%'";
    } else if ($client_id) {
        $sql = "SELECT * FROM kunden WHERE id = " . $client_id;
    }

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
