<?php

// Database credentials
require ('config.php');

// Create connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die ("Connection failed: " . $conn->connect_error);
}

// Directory where avatar images will be stored
$avatarDirectory = $_SERVER['DOCUMENT_ROOT'] . '/avatars/';

// Ensure the avatars directory exists
if (!is_dir($avatarDirectory)) {
    mkdir($avatarDirectory, 0777, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'] ?? 'student'; // Default to student if role is not provided
    $contactInfo = $_POST['contactInfo'];
    $avatarFilename = null;

    // Validate incoming data
    if (empty ($username) || empty ($password) || empty ($contactInfo)) {
        echo "Username, password, and contact info are required.";
        exit();
    }

    // Handle the avatar upload
    if (isset ($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
        // Assign a unique ID for the user (e.g., using UUID or auto-increment ID from the database)
        // For now, we'll use a random unique ID for demonstration
        $userId = uniqid();

        $fileTmpPath = $_FILES['avatar']['tmp_name'];
        $fileName = $_FILES['avatar']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = "avatar_" . $userId . '_' . md5(time() . $fileName) . '.' . $fileExtension;

        $destPath = $avatarDirectory . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $avatarFilename = $newFileName;
        } else {
            echo "Error uploading the file.";
        }
    }

    // Insert user data into the database
    if ($stmt = $conn->prepare("INSERT INTO User (username, password, role, contactInfo, avatar) VALUES (?, ?, ?, ?, ?)")) {
        $stmt->bind_param("sssss", $username, $password, $role, $contactInfo, $avatarFilename);
        if ($stmt->execute()) {
            echo "New user registered successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        // Error handling
        echo "Error preparing statement: " . htmlspecialchars($conn->error);
    }
}

$conn->close();
?>