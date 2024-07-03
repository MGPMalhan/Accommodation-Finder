<?php

require '../config.php'; // Database credentials

// Create connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die ("Connection failed: " . $conn->connect_error);
}

// Directory where images will be stored
$imageDirectory = __DIR__ . '/property/images/';

// Ensure the images directory exists
if (!is_dir($imageDirectory)) {
    mkdir($imageDirectory, 0777, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; // This should be hashed as well
    $role = $_POST['role'] ?? 'student';
    $contactInfo = $_POST['contactInfo'];
    $landloardId = $_POST['landloardId']; // Assuming this is passed in the form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];
    $price = $_POST['price'];
    $imageFilenames = null;
    $status = 'pending';

    // Check if image file is uploaded and add to /property/images directory (single). rename with UID
    if (isset ($_FILES['image'])) {
        $image = $_FILES['image'];

        // Check if the file is an image
        $check = getimagesize($image['tmp_name']);
        if ($check === false) {
            echo "File is not an image.";
            exit();
        }

        $newImageName = uniqid() . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
        $targetFile = $imageDirectory . $newImageName;

        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            // echo "The file " . htmlspecialchars(basename($image['name'])) . " has been uploaded.";
            $image = $newImageName;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Check if image2 file is uploaded and add to /property/images directory (single). rename with UID
    if (isset ($_FILES['image2'])) {
        $image2 = $_FILES['image2'];

        // Check if the file is an image
        $check = getimagesize($image2['tmp_name']);
        if ($check === false) {
            echo "File is not an image.";
            exit();
        }

        $newImageName2 = uniqid() . '.' . pathinfo($image2['name'], PATHINFO_EXTENSION);
        $targetFile2 = $imageDirectory . $newImageName2;

        if (move_uploaded_file($image2['tmp_name'], $targetFile2)) {
            // echo "The file " . htmlspecialchars(basename($image2['name'])) . " has been uploaded.";
            $image2 = $newImageName2;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Check if image3 file is uploaded and add to /property/images directory (single). rename with UID
    if (isset ($_FILES['image3'])) {
        $image3 = $_FILES['image3'];

        // Check if the file is an image
        $check = getimagesize($image3['tmp_name']);
        if ($check === false) {
            echo "File is not an image.";
            exit();
        }

        $newImageName3 = uniqid() . '.' . pathinfo($image3['name'], PATHINFO_EXTENSION);
        $targetFile3 = $imageDirectory . $newImageName3;

        if (move_uploaded_file($image3['tmp_name'], $targetFile3)) {
            // echo "The file " . htmlspecialchars(basename($image3['name'])) . " has been uploaded.";
            $image3 = $newImageName3;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Prepare SQL statement to insert the property data
    $stmt = $conn->prepare("INSERT INTO Property (landlordId, title, description, location, longitude, latitude, rentalPrice, status, image, image2, image3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("isssdddssss", $landloardId, $title, $description, $location, $longitude, $latitude, $price, $status, $image, $image2, $image3);

        if ($stmt->execute()) {
            echo "New property listed successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . htmlspecialchars($conn->error);
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
