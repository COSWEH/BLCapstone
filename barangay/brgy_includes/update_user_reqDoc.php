<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_POST['btnConfirm']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $req_id = $_POST['getReqDocId'];
    $new_status = "Approved";

    $query = mysqli_query($con, "UPDATE `tbl_requests` SET 
    `req_status` = '$new_status'
    WHERE `req_id` = '$req_id'");

    if ($query) {
        $_SESSION['approved_message'] = "Approved!";
        header('Location: ../adminDocument.b.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
} else {
    header('location: ../adminDocument.b.php');
    exit;
}
