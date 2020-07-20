<?php
require_once dirname(__FILE__) . '/../../config.php';
require_once dirname(__FILE__) . '/../../definitions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['auftrag_id']) && !empty($_POST['auftrag_id'])) {
    $auftrag_id = $_POST['auftrag_id'];
    update_status($auftrag_id);
    echo json_encode(array("success" => true));
}

function update_status($auftrag_id)
{
    global $mysqli;

    $sql = "UPDATE auftraege SET status = 'abgeschlossen' WHERE id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $auftrag_id);
        if ($stmt->execute()) {
            $stmt->close();
        } else {
            echo json_encode(array("success" => false, "msg" => "Auftrag konnte nicht erneuert werden."));
        }
        $stmt->close();
    } else {
        echo json_encode(array("success" => false, "msg" => "Datenbankfehler"));
    }
    $mysqli->close();
}
