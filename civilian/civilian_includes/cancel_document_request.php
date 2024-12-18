<?php
include('../../includes/conn.inc.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cBtnConfirm'])) {
    $req_id = $_POST['getReqID'];
    //echo $req_id;
    $userId = $_SESSION['user_id'];

    $query = mysqli_query($con, "UPDATE `tbl_requests` SET req_status = 'Cancelled' WHERE `req_id` = '$req_id'");

    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','Document request has been successfully canceled.', CURRENT_TIMESTAMP,'$userId')");

    if ($query) {
        $_SESSION['cancelReq_message'] = "Document request has been successfully canceled.";
        header('Location: ../document.c.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
} else {
    header('location: ../document.c.php');
    exit;
}
