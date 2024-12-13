<?php
$servername = "localhost"; // Your server name or IP address
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "octa-invest"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
session_start()
// Close the connection
// $conn->close();
?>