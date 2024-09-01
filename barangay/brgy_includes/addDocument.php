<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_POST['btnAddDocument']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $documentType = $_POST['documentType'];

    if (empty($documentType)) {
        header('Location: ../adminDashboard.php');
        exit;
    }

    $documentType = mysqli_real_escape_string($con, $documentType);

    $query = mysqli_query($con, "INSERT INTO `tbl_typedoc`(`id`, `docType`) VALUES ('','$documentType')");

    // add logs
    $userid = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $username added a document', CURRENT_TIMESTAMP,'$userid')");

    if ($query) {
        $_SESSION['add_doc_message'] = "Document successfully addedd";
        header('Location: ../adminDashboard.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
}
