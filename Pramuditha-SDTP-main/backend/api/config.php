<?php
header('Access-Control-Allow-Origin: *'); // Allows all origins
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // Allowed methods
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Allowed headers

define('DB_SERVER', 'db');
define('DB_USERNAME', 'user');  // Your database username
define('DB_PASSWORD', 'password');  // Your database password
define('DB_NAME', 'hostel_management');  // Your database name

// Attempt to connect to MySQL database
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check the connection
if ($link === false) {
    die ("ERROR: Could not connect. " . mysqli_connect_error());
}