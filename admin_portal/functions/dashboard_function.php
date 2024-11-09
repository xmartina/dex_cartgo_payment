<?php
include_once(__DIR__ . '/../../admin_portal/functions/main_function.php');


$get_new_users_sql = "SELECT * FROM students WHERE is_registered = '0' LIMIT 10";
$get_new_users_result = $portal_conn->query($get_new_users_sql);


if (isset($_POST['update_home_about_1'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $button_text = $_POST['button_text'];
    $button_link = $_POST['button_link'];

    // SQL UPDATE query
    $sql = "UPDATE home_about_section SET
                title = '$title',
                content = '$content',
                button_text = '$button_text',
                button_link = '$button_link'
            WHERE id = 1";

    // Execute query and check if it succeeded
    if ($conn->query($sql) === TRUE) { ?>
        <script type="text/javascript">
            window.location.href = "<?= $admin_url ?>pages/home/?success=home_about_updated";
        </script>
    <?php } else { ?>
        <script type="text/javascript">
            window.location.href = "<?= $admin_url ?>pages/home/?error=error_updating_record";
        </script>
    <?php }

    // Close connection
    $conn->close();
}

if (isset($_POST['update_rector_welcome_note'])) {
    // Escape strings to prevent SQL injection
    $sub_title = $conn->real_escape_string($_POST['sub_title']);
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $button_text = $conn->real_escape_string($_POST['button_text']);
    $button_link = $conn->real_escape_string($_POST['button_link']);
    $rec_position = $conn->real_escape_string($_POST['rec_position']);
    $rec_name = $conn->real_escape_string($_POST['rec_name']);

    // Initialize image variables
    $rec_img = $extra_img = "";

    // Handle rector image upload
    if (!empty($_FILES['rec_img']['name'])) {
        $target_dir = "/assets/school_image/staff/";
        $rec_img = basename($_FILES["rec_img"]["name"]);
        $target_file = $target_dir . $rec_img;
        if (!move_uploaded_file($_FILES["rec_img"]["tmp_name"], $target_file)) {
            echo "Sorry, there was an error uploading your rector image.";
            exit;
        }
    }

    // Handle extra image upload
    if (!empty($_FILES['extra_img']['name'])) {
        $target_dir = "/assets/images/";
        $extra_img = basename($_FILES["extra_img"]["name"]);
        $target_file = $target_dir . $extra_img;
        if (!move_uploaded_file($_FILES["extra_img"]["tmp_name"], $target_file)) {
            echo "Sorry, there was an error uploading your extra image.";
            exit;
        }
    }

    // Build SQL query
    $sql = "UPDATE rector_welcome_note SET 
                sub_title = '$sub_title',
                title = '$title',
                content = '$content',
                button_text = '$button_text',
                button_link = '$button_link',
                rec_position = '$rec_position',
                rec_name = '$rec_name'";

    // Append image fields if new images were uploaded
    if (!empty($rec_img)) {
        $sql .= ", rec_img = '$rec_img'";
    }
    if (!empty($extra_img)) {
        $sql .= ", extra_img = '$extra_img'";
    }

    // Specify the record ID
    $sql .= " WHERE id = 1";

    // Execute the query and check for errors
    if ($conn->query($sql) === TRUE) {
        echo "<script type='text/javascript'>
                window.location.href = '{$admin_url}pages/home/?success=rector_note_updated';
              </script>";
    } else {
        echo "Error updating record: " . $conn->error;
        echo "<script type='text/javascript'>
                window.location.href = '{$admin_url}pages/home/?error=error_updating_record';
              </script>";
    }

    // Close connection
    $conn->close();
}



?>
