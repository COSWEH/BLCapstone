<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_POST['btnConfirm']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $ifProcessOrApprove = $_POST['ifProcessOrApprove'];

    if ($ifProcessOrApprove == "Process") {
        //echo "Process";
        $process_req_id = $_POST['getProcessReqDocId'];
        $process_status = "Processing";

        $query = mysqli_query($con, "UPDATE `tbl_requests` SET `req_status` = '$process_status' WHERE `req_id` = '$process_req_id'");

        if ($query) {
            $_SESSION['processing_message'] = "Processing!";
            header('Location: ../adminDocument.b.php');
            exit;
        } else {
            die('Error: ' . mysqli_error($con));
        }
    } elseif ($ifProcessOrApprove == "Approve") {
        //echo "approve";
        $approve_req_id = $_POST['getApproveReqDocId'];
        $approve_status = "Approved";

        $query = mysqli_query($con, "UPDATE `tbl_requests` SET `req_status` = '$approve_status' WHERE `req_id` = '$approve_req_id'");

        if ($query) {
            $_SESSION['approved_message'] = "Approved!";
            header('Location: ../adminDocument.b.php');
            exit;
        } else {
            die('Error: ' . mysqli_error($con));
        }
    }
} else {
    header('location: ../adminDocument.b.php');
    exit;
}
