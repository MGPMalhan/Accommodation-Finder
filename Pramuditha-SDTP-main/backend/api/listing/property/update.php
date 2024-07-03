<?php

require '../../config.php'; // Database credentials

// Create connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die ("Connection failed: " . $conn->connect_error);
}

// uses post method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $listingId = $_POST['listingId'];
    $status = 'pending';
    $title = $_POST['title'];
    $rentalPrice = $_POST['rentalPrice'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    // echo "Listing: " . $listingId;

    $sql = "UPDATE Property SET status = ?, title = ?, rentalPrice = ?, location = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdssi", $status, $title, $rentalPrice, $location, $description, $listingId);

    if ($stmt->execute()) {
        echo "Listing updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
}