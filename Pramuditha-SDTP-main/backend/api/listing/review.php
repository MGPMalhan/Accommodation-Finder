<?php

require '../config.php';

// Database connection

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection

if ($conn->connect_error) {

    die ("Connection failed: " . $conn->connect_error);

}

// Check the chat form submission ( studentID, propertyID, Username, rating, message)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $studentID = $_POST['studentID'];

    $propertyID = $_POST['propertyID'];

    $username = $_POST['username'];

    $rating = $_POST['rating'];

    $message = $_POST['message'];

    // Prepare the SQL statement

    $sql = "INSERT INTO Review (propertyId, userId, username, rating, message) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {

        // Bind the variables to the prepared statement as parameters

        $stmt->bind_param("iisis", $propertyID, $studentID, $username, $rating, $message);

        // Attempt to execute the prepared statement

        if ($stmt->execute()) {

            echo "Review sent successfully.";

        } else {

            echo "Error: " . $sql . "<br>" . $conn->error;

        }

        // Close the statement

        $stmt->close();

    }

}

// Close the connection

$conn->close();
