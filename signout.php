<?php
include('includes/conn.inc.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = $_SESSION['username'];
    $userid = $_SESSION['user_id'];

    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','Successfully logged out.', CURRENT_TIMESTAMP,'$userid')");

    session_destroy();
    header('location: index.php');
} else {
    header('location: index.php');
    exit;
}
