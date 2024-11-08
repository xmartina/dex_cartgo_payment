<?php
include_once ( __DIR__ . '/../../admin_portal/include/config.php');
//General Settings
$sql = "SELECT * FROM general_settings"; // Adjust the table name if different
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$site_name = $row["site_name"];
$site_title = $row["site_title"];
$site_dec = $row["site_dec"];
$siteUrl = $row["site_url"];
$site_phone = $row["site_phone"];
$site_email = $row["site_email"];
$site_address = $row["site_address"];
$logo = $row["logo"];
$footer_logo = $row["footer_logo"];
$favicon = $row["favicon"];
$footer_dec = $row["footer_dec"];
$footer_copyright = $row["footer_copyright"];
$site_url = $siteUrl;
$admin_url = $site_url . 'admin_portal/';
$login_url = $admin_url. 'auth/login';
$register_url = $admin_url. 'auth/register';
$logout_url = $admin_url. 'auth/logout';
$forgotten_password_url = $admin_url. 'auth/forgotten_password';
$site_logo = 'TMIT';
$sitelogo = $site_logo;

include_once __DIR__.'/../../admin_portal/functions/auth/session.php';
if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];

    $select_user_sql = "SELECT * FROM users WHERE id = '$id'";
    $select_user_result = $conn->query($select_user_sql);

    if ($select_user_result && $select_user_result->num_rows > 0) {
        $row = $select_user_result->fetch_assoc();

        $f_name = $row['fname'];
        $l_name = $row['lname'];
        $useremail = $row['useremail'];
        $username = $row['username'];
        $phone_number = $row['phone_number'];
        $profile_img = $row['profile_img'];
        $token = $row['token'];
        $role = $row['role'];
    } else {
        echo "No user found with the specified ID.";
    }
    $full_name = $f_name . ' ' . $l_name;
    if ($role = 1) {
        $user_role = 'Super Administrator';
    } elseif ($role = 2) {
        $user_role = 'Administrator';
    } elseif ($role = 3) {
        $user_role = 'Moderator';
    }
}