<?php
// Database connection parameters
$servername = "localhost";  // Database server
$username = "multistream6_dexcartgo_back";         // Database username
$password = "dexcartgo_back";             // Database password
$dbname = "multistream6_dexcartgo_back";        // Database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}