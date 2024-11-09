<?php
// Initialize the session
$url = $_SERVER['REQUEST_URI'];

// Check if the current URL does not contain 'login'
if (strpos($url, 'login') === false) {
    // If the user is not logged in, redirect to the login page
    if (!isset($_SESSION['user_id'])) {
        header("Location:".$admin_url."login");
        exit;
    }
}
// Check if the URL does contain 'login'
elseif (strpos($url, 'login') !== false) {
    // If the user is already logged in, redirect to the admin portal
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        header("Location:".$admin_url);
        exit;
    }
}

?>