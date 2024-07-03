<?php

require '../config.php';

// Database connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die ("Connection failed: " . $conn->connect_error);
}

// Check the update form submission (username, password, confirmPassword) JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    echo "Username: " . $username . "<br>";
    echo "Password: " . $password . "<br>";

    // Prepare the SQL statement
    $sql = "UPDATE User SET password = ? WHERE username = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the variables to the prepared statement as parameters
        $stmt->bind_param("ss", $password, $username);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            echo "Password updated successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the connection
$conn->close();