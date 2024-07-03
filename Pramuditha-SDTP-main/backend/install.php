<?php

require 'api/config.php'; // Your database configuration file

// Function to execute a query with error handling
function executeQuery($link, $query)
{
    if (mysqli_query($link, $query)) {
        echo "Query executed successfully: " . $query . "<br>";
    } else {
        echo "ERROR: Could not execute query: $query. " . mysqli_error($link) . "<br>";
    }
}

// User table
$userTable = "CREATE TABLE IF NOT EXISTS User (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('landloard', 'student', 'warden') NOT NULL,
    contactInfo VARCHAR(255),
    avatar VARCHAR(255)
);";

// Property table
$propertyTable = "CREATE TABLE IF NOT EXISTS Property (
    id INT AUTO_INCREMENT PRIMARY KEY,
    landlordId INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    location VARCHAR(255) NOT NULL,
    longitude FLOAT NOT NULL,
    latitude FLOAT NOT NULL,
    rentalPrice FLOAT NOT NULL,
    status ENUM('available', 'reserved', 'rented', 'pending', 'rejected') NOT NULL,
    image VARCHAR(255) NOT NULL,
    image2 VARCHAR(255),
    image3 VARCHAR(255),
    listedOn DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (landlordId) REFERENCES User(id)
);";

// Reservation table
$reservationTable = "CREATE TABLE IF NOT EXISTS Reservation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    propertyId INT NOT NULL,
    studentId INT NOT NULL,
    status ENUM('requested', 'accepted', 'rejected', 'cancelled') NOT NULL,
    reservationDate DATETIME NOT NULL,
    duration INT NOT NULL,
    FOREIGN KEY (propertyId) REFERENCES Property(id),
    FOREIGN KEY (studentId) REFERENCES User(id)
);";

// ChatRoom table
$chatRoomTable = "CREATE TABLE IF NOT EXISTS ChatRoom (
    id INT AUTO_INCREMENT PRIMARY KEY,
    studentId INT NOT NULL,
    landlordId INT NOT NULL,
    FOREIGN KEY (studentId) REFERENCES User(id),
    FOREIGN KEY (landlordId) REFERENCES User(id),
    UNIQUE (studentId, landlordId)
);";

// ChatMessage table
$chatMessageTable = "CREATE TABLE IF NOT EXISTS ChatMessage (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chatRoomId INT NOT NULL,
    senderId INT NOT NULL,
    content TEXT NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (chatRoomId) REFERENCES ChatRoom(id),
    FOREIGN KEY (senderId) REFERENCES User(id)
);";

// Article table
$articleTable = "CREATE TABLE IF NOT EXISTS Article (
    id INT AUTO_INCREMENT PRIMARY KEY,
    wardenId INT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    publishDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    image VARCHAR(255) NOT NULL,
    FOREIGN KEY (wardenId) REFERENCES User(id)
);";

// Review table
$reviewTable = "CREATE TABLE IF NOT EXISTS Review (
    id INT AUTO_INCREMENT PRIMARY KEY,
    propertyId INT NOT NULL,
    userId INT NOT NULL,
    username VARCHAR(255) NOT NULL,
    rating INT NOT NULL,
    message TEXT NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (propertyId) REFERENCES Property(id),
    FOREIGN KEY (userId) REFERENCES User(id)
);";

// Contact table
$contactTable = "CREATE TABLE IF NOT EXISTS Contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL
);";

// Add default warden user
$defaultWarden = "INSERT INTO User (username, password, role, avatar) VALUES ('warden', 'warden', 'warden', 'avatar.png');";
// Add default landloard user
$defaultLandloard = "INSERT INTO User (username, password, role, avatar) VALUES ('landloard', 'landloard', 'landloard', 'avatar.png');";
// Add default student user
$defaultStudent = "INSERT INTO User (username, password, role, avatar) VALUES ('student', 'student', 'student', 'avatar.png');";
// Add default chat Room
$defaultChatRoom = "INSERT INTO ChatRoom (studentId, landlordId) VALUES (3, 2);";
// Add default chat message


// Execute the queries
executeQuery($link, $userTable);
executeQuery($link, $propertyTable);
executeQuery($link, $reservationTable);
executeQuery($link, $chatRoomTable);
executeQuery($link, $chatMessageTable);
executeQuery($link, $articleTable);
executeQuery($link, $reviewTable);
executeQuery($link, $contactTable);
executeQuery($link, $defaultWarden);
executeQuery($link, $defaultLandloard);
executeQuery($link, $defaultStudent);
executeQuery($link, $defaultChatRoom);

// Close the connection
mysqli_close($link);
