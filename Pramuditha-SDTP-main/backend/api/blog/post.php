<?php

require '../config.php';

// Database connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die ("Connection failed: " . $conn->connect_error);
}

// Check the contact form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // wardenId, title, content, image file
    $wardenId = $_POST['wardenId'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // handle Image Upload
    $image = null;
    if (isset ($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = "post_" . uniqid() . '.' . $fileExtension;
        $allowedFileExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedFileExtensions)) {
            $destPath = $_SERVER['DOCUMENT_ROOT'] . '/postImages/' . $newFileName;
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $image = $newFileName;
            } else {
                echo "Error uploading the file.";
            }
        } else {
            echo "Error Invalid file type. Please upload a valid image file.";
        }
    }

    // Insert post data into the database
    if ($stmt = $conn->prepare("INSERT INTO Article (wardenId, title, content, image) VALUES (?, ?, ?, ?)")) {
        $stmt->bind_param("isss", $wardenId, $title, $content, $image);
        if ($stmt->execute()) {
            echo "New post created successfully.";
        } else {
            echo "Error: Could not execute query: $stmt. " . $conn->error;
        }
    } else {
        echo "Error: Could not prepare query: $stmt. " . $conn->error;
    }

}

// Close the connection
$conn->close();