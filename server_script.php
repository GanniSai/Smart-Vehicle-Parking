<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Assuming you have a database connection established
$mysqli = new mysqli("localhost", "root", "", "parkinglotsreservations");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Function to execute the SQL query and fetch results
function executeQuery($phoneNumber) {
    global $mysqli;

    // Sanitize the input to prevent SQL injection
    $phoneNumber = $mysqli->real_escape_string($phoneNumber);

    // Construct the SQL query
    $sqlQuery = "SELECT client_name, amt FROM payments WHERE client_phone = '$phoneNumber' ORDER BY id DESC LIMIT 1";

    // Execute the query
    $result = $mysqli->query($sqlQuery);

    if (!$result) {
        // Handle the query error if needed
        return ['error' => $mysqli->error];
    }

    // Fetch the result as an associative array
    $data = $result->fetch_assoc();

    // Close the result set
    $result->close();

    return $data;
}

// Check if 'phone' parameter is set in the URL
$phoneNumber = isset($_GET['phone']) ? $_GET['phone'] : '';

if ($phoneNumber === "") {
    // Set the Content-Type header
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Please enter a phone number']);
} else {
    // Execute the query function
    $result = executeQuery($phoneNumber);

    // Check for errors
    if (isset($result['error'])) {
        // Set the Content-Type header
        header('Content-Type: application/json');
        echo json_encode(['error' => $result['error']]);
    } else {
        // Set the Content-Type header
        header('Content-Type: application/json');
        // Return the result as JSON
        echo json_encode(['data' => $result]);
    }
}

// Close the database connection
$mysqli->close();
?>
