<?php
require_once dirname(__FILE__) . '/../../config.php';
require_once dirname(__FILE__) . '/../../definitions.php';


function get_inquiry_by_id($id)
{
    global $mysqli;

    $id = intval($id);
    $sql = "SELECT * FROM anfragen WHERE id = " . $id;

    if ($stmt = $mysqli->prepare($sql)) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($inquiryData = $result->fetch_assoc()) {
                return $inquiryData;
            }
        } else return false;
    } else return false;
}

function get_order_by_id($id)
{
    global $mysqli;
    $id = intval($id);
    $sql = "SELECT * FROM auftraege WHERE id = " . $id;

    if ($stmt = $mysqli->prepare($sql)) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($orderData = $result->fetch_assoc()) {
                return $orderData;
            }
        } else return false;
    } else return false;
}

function get_client_by_id($id)
{
    global $mysqli;
    $id = intval($id);
    $sql = "SELECT * FROM kunden WHERE id = " . $id;

    if ($stmt = $mysqli->prepare($sql)) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($clientData = $result->fetch_assoc()) {
                return $clientData;
            }
        } else return false;
    } else return false;
}


function get_admin_by_email($email)
{
    global $mysqli;
    $sql = "SELECT * FROM vorreiter_admin_users WHERE email = ?";
     . $email;

    if ($stmt = $mysqli->prepare($sql)) {
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($clientData = $result->fetch_assoc()) {
                return $clientData;
            }
        } else return false;
    } else return false;
}



function get_client_by_name($name)
{
    global $mysqli;
    $name = strval($name);
    $sql = "SELECT * FROM kunden WHERE firmenname LIKE '%" . $name . "%'";

    if ($stmt = $mysqli->prepare($sql)) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $clientData = [];
            while ($row = $result->fetch_assoc()) {
                array_push($clientData, $row);
            }
            return $clientData;
        } else return false;
    } else return false;
}

function get_packages_by_inquiry_id($inquiryId)
{
    global $mysqli;
    $inquiryId = intval($inquiryId);
    $sql = "SELECT * FROM pakete WHERE anfrage_id = " . $inquiryId;

    if ($stmt = $mysqli->prepare($sql)) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $packages = [];
            while ($row = $result->fetch_assoc()) {
                array_push($packages, $row);
            }
            return $packages;
        } else return false;
    } else return false;
}


function get_packages_by_order_id($orderId)
{
    global $mysqli;
    $orderId = intval($orderId);
    $sql = "SELECT * FROM pakete WHERE auftrag_id = " . $orderId;

    if ($stmt = $mysqli->prepare($sql)) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $packages = [];
            while ($row = $result->fetch_assoc()) {
                array_push($packages, $row);
            }
            return $packages;
        } else return false;
    } else return false;
}


function get_pickup_address_by_id($addressId)
{
    global $mysqli;
    $addressId = intval($addressId);
    $sql = "SELECT * FROM abholadresse WHERE id = " . $addressId;

    if ($stmt = $mysqli->prepare($sql)) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($pickupAddress = $result->fetch_assoc()) {
                return $pickupAddress;
            } else return false;
        } else return false;
    }
}
function get_delivery_address_by_id($addressId)
{
    global $mysqli;
    $addressId = intval($addressId);
    $sql = "SELECT * FROM lieferadresse WHERE id = " . $addressId;

    if ($stmt = $mysqli->prepare($sql)) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($deliveryAddress = $result->fetch_assoc()) {
                return $deliveryAddress;
            } else return false;
        } else return false;
    }
}
