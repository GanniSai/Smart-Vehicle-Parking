<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$mysqli = new mysqli("localhost", "root", "", "parkinglotsreservations");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

function executeQuery($phoneNumber) {
    global $mysqli;

    $phoneNumber = $mysqli->real_escape_string($phoneNumber);

    $sqlQuery = "SELECT parking_end_date, parking_date FROM reservations WHERE client_phone = '$phoneNumber' ORDER BY id DESC LIMIT 1";

    $result = $mysqli->query($sqlQuery);

    if (!$result) {
        return ['error' => $mysqli->error];
    }

    $data = $result->fetch_assoc();

    $result->close();

    return $data;
}

$phoneNumber = isset($_GET['phone']) ? $_GET['phone'] : '';

if ($phoneNumber === "") {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Please enter a phone number']);
} else {
    $result = executeQuery($phoneNumber);

    if (isset($result['error'])) {
        header('Content-Type: application/json');
        echo json_encode(['error' => $result['error']]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['data' => $result]);
    }
}

$mysqli->close();
?>
