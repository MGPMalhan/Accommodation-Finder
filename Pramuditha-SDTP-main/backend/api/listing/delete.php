<?php

// Delete Listing

require '../config.php'; // Database credentials

// Create connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die ("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $listingId = $_GET['listingId'];

    echo "Listing: " . $listingId;

    $sql = "DELETE FROM Property WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $listingId);

    if ($stmt->execute()) {
        echo "Listing deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
}

