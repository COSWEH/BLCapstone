<?php
include('../../includes/conn.inc.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnDeleteAcc'])) {
    $getSuperAdminID = $_POST['getSuperAdminID'];


    $query = mysqli_query($con, "DELETE FROM `tbl_useracc` WHERE `user_id` = '$getSuperAdminID'");

    // add logs
    $userid = $_SESSION['user_id'];
    $user_name = $_SESSION['username'];
    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','Super Admin account successfully deleted from the system.', CURRENT_TIMESTAMP,'$userid')");

    if ($query) {
        $_SESSION['delete_message'] = "Super Admin account has been successfully deleted.";
        header('Location: ../superAdminDashboard.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
} else {
    header('location: ../superAdminDashboard.php');
    exit;
}
