<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_POST['btnReqDocument']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['getUserid'];
    $req_fname = $_POST['fName'];
    $req_lname = $_POST['lName'];
    $req_contactNo = $_POST['contNumber'];
    $req_brgy = $_POST['userBrgy'];
    $req_typeOfDoc = $_POST['docType'];
    $req_password = $_POST['password'];
    $req_status = "Pending";

    $checkUser = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `user_id` = '$user_id' LIMIT 1");
    $countUser = mysqli_num_rows($checkUser);

    if ($countUser > 0) {
        $row = mysqli_fetch_assoc($checkUser);
        $dbPassword = $row['password'];

        if (password_verify($req_password, $dbPassword)) {

            $req_password = password_hash($req_password, PASSWORD_DEFAULT);

            $query = mysqli_query($con, "INSERT INTO `tbl_requests`(`req_id`, `user_id`, `req_date`, `req_fname`, `req_lname`, `req_contactNo`, `req_brgy`, `req_typeOfDoc`, `req_password`, `req_status`) VALUES ('', '$user_id', CURRENT_TIMESTAMP, '$req_fname', '$req_lname', '$req_contactNo', '$req_brgy', '$req_typeOfDoc', '$req_password', '$req_status')");

            if ($query) {
                $_SESSION['reqDoc_message'] = "Document submitted";
                header('location: ../document.c.php');
                exit;
            } else {
                die('Error: ' . mysqli_error($con));
            }
        } else {
            $_SESSION['reqDoc_invalid_password'] = "Invalid password!";
            header('location: ../document.c.php');
            exit;
        }
    }
} else {
    header('location: ../document.c.php');
    exit;
}
