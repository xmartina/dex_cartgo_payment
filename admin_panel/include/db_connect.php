<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
$servername = "localhost"; // Change this if your database is hosted on a different server
$username = "matagram_tmit_landing_page"; // Change this to your database username
$password = "tmit_landing_page"; // Your database password
$dbname = "matagram_tmit_landing_page"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
