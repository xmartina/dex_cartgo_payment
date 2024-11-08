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

// Simple query: select all records from a table named 'users'
$sql = "SELECT * FROM hm2_users ";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Check if there are results and output data
//if ($result->num_rows > 0) {
//    // Output each row
//    while($row = $result->fetch_assoc()) {
//        echo "ID: " . $row["id"]. " - Name: " . $row["name"]. " - Email: " . $row["email"]. "<br>";
//    }
//} else {
//    echo "No results found";
//}

// Close the connection
//$conn->close();
