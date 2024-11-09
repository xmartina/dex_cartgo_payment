<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$portal_servername = "localhost"; // Change this if your database is hosted on a different server
$portal_username = "matagram_portal_tmit_1"; // Change this to your database username
$portal_password = "portal_tmit_1"; // Your database password
$portal_dbname = "matagram_portal_tmit_1"; // Your database name

// Create connection
$portal_conn = new mysqli($portal_servername, $portal_username, $portal_password, $portal_dbname);

// Check connection
if ($portal_conn->connect_error) {
    die("Connection failed: " . $portal_conn->connect_error);
}
