<?php
include('includes/conn.inc.php');
session_start();

// add sign out logs
$user_name = $_SESSION['username'];
$userid = $_SESSION['user_id'];

mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $user_name successfully logout', CURRENT_TIMESTAMP,'$userid')");

session_destroy();
header('location: index.php');
