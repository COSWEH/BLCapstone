   
<?php
include('../../includes/conn.inc.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location: ../post.c.php');
    exit;
}
$getUserid = $_SESSION['user_id'];

$reqIDResult = mysqli_query($con, "SELECT req_id FROM `tbl_requests` WHERE user_id = '$getUserid'");
$getReqIDdata = mysqli_fetch_assoc($reqIDResult);
$req_id = $getReqIDdata['req_id'];

$updateNotif = mysqli_query($con, "UPDATE `tbl_notification` SET `status` = 'read' WHERE `req_id` = '$req_id' AND `status` = 'unread'");

if ($updateNotif) {
    echo "Success";
} else {
    echo "Error: " . mysqli_error($con);
}
