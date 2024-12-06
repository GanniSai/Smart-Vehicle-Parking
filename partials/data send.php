<?php

// Set the time zone to India
date_default_timezone_set('Asia/Kolkata');

// ThingSpeak API endpoint and channel ID
$apiEndpoint = "https://api.thingspeak.com/channels/";
$channelID = "2341054";

// ThingSpeak API key (if your channel is private)
$apiKey = "CHUQ51MKST9M9TFR";

// Number of entries to retrieve
$numEntries = 10;

// Construct the URL
$url = $apiEndpoint . $channelID . "/feeds.json?api_key=" . $apiKey . "&results=" . $numEntries;

// Make the API request
$response = file_get_contents($url);

// Check for errors
if ($response === FALSE) {
    die('Error occurred while fetching ThingSpeak data');
}

// Decode the JSON response
$data = json_decode($response, true);

// Process the data
foreach ($data['feeds'] as $entry) {
    // Convert ThingSpeak timestamp to Indian Standard Time (IST)
    $timestamp = date('Y-m-d H:i:s', strtotime($entry['created_at']));

    $field1 = $entry['field1'];
    $field2 = $entry['field2'];
    $field3 = $entry['field3'];
    $field4 = $entry['field4'];

    // Process or store the data as needed
    // For example, you can insert it into a database, perform calculations, etc.
    //echo "Timestamp: $timestamp, Field1: $field1, Field2: $field2, Field3: $field3, Field4: $field4 <br>";

    $connection = mysqli_connect("localhost", "root", "", "parkinglotsreservations");

    $sql = "INSERT INTO thingspeakdata VALUES (NULL,'$timestamp', '$field1', '$field2', '$field3', $field4)";

    $query = mysqli_query($connection, $sql);
    if ($field1 == 1) {
        $sql = "UPDATE parkingslots SET status='available' WHERE id=12 ";
        $query = mysqli_query($connection, $sql);
    } else {
        $sql = "UPDATE parkingslots SET status='booked' WHERE id=12 ";
        $query = mysqli_query($connection, $sql);
    }
    if ($field2 == 1) {
        $sql = "UPDATE parkingslots SET status='available' WHERE id=56 ";
        $query = mysqli_query($connection, $sql);
    } else {
        $sql = "UPDATE parkingslots SET status='booked' WHERE id=56 ";
        $query = mysqli_query($connection, $sql);
    }
    if ($field3 == 1) {
        $sql = "UPDATE parkingslots SET status='available' WHERE id=96 ";
        $query = mysqli_query($connection, $sql);
    } else {
        $sql = "UPDATE parkingslots SET status='booked' WHERE id=96 ";
        $query = mysqli_query($connection, $sql);
    }
    if ($field4 == 1) {
        $sql = "UPDATE parkingslots SET status='available' WHERE id=964 ";
        $query = mysqli_query($connection, $sql);
    } else {
        $sql = "UPDATE parkingslots SET status='booked' WHERE id=964 ";
        $query = mysqli_query($connection, $sql);
    }
}
