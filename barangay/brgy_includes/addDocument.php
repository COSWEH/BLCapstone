<?php
include('../../includes/conn.inc.php');
session_start();

$adminBrgy = $_SESSION['user_brgy'];

if (isset($_POST['btnAddDocument']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $documentType = ucwords(strtolower($_POST['documentType'] . '(' . $adminBrgy . ')'));
    $documentTemplate = $_FILES['documentTemplate'];
    $brgyDoc = $_SESSION['user_brgy'];

    if (empty($documentType)) {
        $_SESSION['required_add_doc_message'] = "Document Type is required";
        header('Location: ../adminDashboard.php');
        exit;
    }

    // Validate and handle file upload
    $allowedExtensions = ['pdf'];
    $fileExtension = strtolower(pathinfo($documentTemplate['name'], PATHINFO_EXTENSION));

    if (!in_array($fileExtension, $allowedExtensions)) {
        $_SESSION['pdf_only_add_doc_message'] = "Only PDF files are allowed";
        header('Location: ../adminDashboard.php');
        exit;
    }

    // Check for upload errors
    if ($documentTemplate['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['error_upload_add_doc_message'] = "Error uploading file";
        header('Location: ../adminDashboard.php');
        exit;
    }

    // $uploadDir = '../../includes/doc_template/';
    $uploadDir = '../../civilian/civilian_includes/doc_template/';
    $fileName = basename($brgyDoc . "." . $documentTemplate['name']); // Get the file name
    $uploadFile = $uploadDir . $fileName;

    if (!move_uploaded_file($documentTemplate['tmp_name'], $uploadFile)) {
        $_SESSION['failed_add_doc_message'] = "Failed to upload file";
        header('Location: ../adminDashboard.php');
        exit;
    }

    $documentType = mysqli_real_escape_string($con, $documentType);
    $fileName = mysqli_real_escape_string($con, $fileName);

    $checkQuery = mysqli_query($con, "SELECT * FROM `tbl_typedoc` WHERE `brgydoc` = '$brgyDoc' AND `docType` = '$documentType'");
    if (mysqli_num_rows($checkQuery) > 0) {
        // Document type already exists
        $_SESSION['alrExist_add_doc_message'] = "Duplicate entry: Document type already exists for this barangay.";
        header('Location: ../adminDashboard.php');
        exit;
    }

    $query = mysqli_query($con, "INSERT INTO `tbl_typedoc`(`id`, `brgydoc`, `docType`, `doc_template`) VALUES ('', '$brgyDoc', '$documentType', '$fileName')");

    // add logs
    $userid = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','Document added successfully.', CURRENT_TIMESTAMP,'$userid')");

    if ($query) {
        $_SESSION['add_doc_message'] = "Document added successfully.";
        header('Location: ../adminDashboard.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
}
