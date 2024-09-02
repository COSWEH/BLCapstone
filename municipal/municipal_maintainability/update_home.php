<?php
include('../../includes/conn.inc.php');
session_start();


function capitalizeSentences($text)
{
    // Convert the entire text to lowercase
    $text = strtolower($text);

    // Capitalize the first letter of the first sentence
    $text = ucfirst($text);

    // Capitalize the first letter after every period followed by a space
    $text = preg_replace_callback('/(?<=[.])\s+(\w)/', function ($matches) {
        return ' ' . strtoupper($matches[1]);
    }, $text);

    return $text;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['btnHomeTitle'])) {
        $home_title_id = $_POST['home_title_id'];
        $home_title = $_POST['home_title'];

        $home_title = ucwords(strtolower($home_title));


        if (empty($home_title)) {
            header('Location: ../superAdminDashboard.php');
            exit;
        }

        $home_title_query = mysqli_query($con, "UPDATE `tbl_home` SET `home_title` = '$home_title' WHERE `home_id` = '$home_title_id'");

        // add logs
        $userid = $_SESSION['user_id'];
        $user_name = $_SESSION['username'];
        mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $user_name changed the home title', CURRENT_TIMESTAMP,'$userid')");

        if ($home_title_query) {
            $_SESSION['update_home_message'] = "Home title successfully updated";
            header('Location: ../superAdminDashboard.php');
            exit;
        } else {
            die('Error: ' . mysqli_error($con));
        }
    } elseif (isset($_POST['btnHomeSubtitle1'])) {
        $home_subtitle1_id = $_POST['home_subtitle1_id'];
        $home_subtitle1 = $_POST['home_subtitle1'];

        $home_subtitle1 = capitalizeSentences($home_subtitle1);

        if (empty($home_subtitle1)) {
            header('Location: ../superAdminDashboard.php');
            exit;
        }

        $home_subtitle1query = mysqli_query($con, "UPDATE `tbl_home` SET `home_subtitleOne` = '$home_subtitle1' WHERE `home_id` = '$home_subtitle1_id'");

        // add logs
        $userid = $_SESSION['user_id'];
        $user_name = $_SESSION['username'];
        mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $user_name changed the first home subtitle', CURRENT_TIMESTAMP,'$userid')");

        if ($home_subtitle1query) {
            $_SESSION['update_home_message'] = "Home first subtitle successfully updated";
            header('Location: ../superAdminDashboard.php');
            exit;
        } else {
            die('Error: ' . mysqli_error($con));
        }
    } elseif (isset($_POST['btnHomeSubtitle2'])) {
        $home_subtitle2_id = $_POST['home_subtitle2_id'];
        $home_subtitle2 = $_POST['home_subtitle2'];

        $home_subtitle2 = capitalizeSentences($home_subtitle2);

        if (empty($home_subtitle2)) {
            header('Location: ../superAdminDashboard.php');
            exit;
        }

        $home_subtitle2query = mysqli_query($con, "UPDATE `tbl_home` SET `home_subtitleTwo` = '$home_subtitle2' WHERE `home_id` = '$home_subtitle2_id'");

        // add logs
        $userid = $_SESSION['user_id'];
        $user_name = $_SESSION['username'];
        mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $user_name changed the second home subtitle', CURRENT_TIMESTAMP,'$userid')");

        if ($home_subtitle2query) {
            $_SESSION['update_home_message'] = "Home second subtitle successfully updated";
            header('Location: ../superAdminDashboard.php');
            exit;
        } else {
            die('Error: ' . mysqli_error($con));
        }
    } elseif (isset($_POST['btnHomeImg'])) {
        // Define the upload directory
        $upload_dir = '../../index_dbImg/';

        // Handling home image file
        $home_img_id = $_POST['home_img_id'];
        $home_img = $_FILES['home_img'];

        // Check if file was uploaded
        if ($home_img['error'] !== UPLOAD_ERR_OK) {
            die('Error: File upload failed with error code ' . $home_img['error']);
        }

        // Move the file to the desired folder
        $temp_name = $home_img['tmp_name'];
        $original_name = $home_img['name'];
        $upload_file = $upload_dir . basename($original_name);

        // Fetch the current image path from the database
        $result = mysqli_query($con, "SELECT `home_img` FROM `tbl_home` WHERE `home_id` = '$home_img_id'");
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $current_img_path = $upload_dir . $row['home_img'];

            // Delete the old image if it exists
            if (file_exists($current_img_path) && $row['home_img'] !== basename($original_name)) {
                unlink($current_img_path);
            }
        } else {
            die('Error: Unable to fetch current image path from database.');
        }

        // Move the new file to the desired folder
        if (move_uploaded_file($temp_name, $upload_file)) {
            // Prepare the new image path for the database
            $home_img_path = basename($original_name);

            // Update the database with the new image path
            $home_imgquery = mysqli_query($con, "UPDATE `tbl_home` SET `home_img` = '$home_img_path' WHERE `home_id` = '$home_img_id'");

            // Add logs
            $userid = $_SESSION['user_id'];
            $user_name = $_SESSION['username'];
            mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $user_name updated the home image', CURRENT_TIMESTAMP,'$userid')");

            if ($home_imgquery) {
                $_SESSION['update_home_message'] = "Home image successfully updated";
                header('Location: ../superAdminDashboard.php');
                exit;
            } else {
                die('Error: ' . mysqli_error($con));
            }
        } else {
            die('Error: Unable to move uploaded file.');
        }
    }
} else {
    header('Location: ../superAdminDashboard.php');
    exit;
}
