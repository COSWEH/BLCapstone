<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_POST['btnDelete']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $faq_id = $_POST['faqid'];

    if (empty($faq_id)) {
        header('Location: ../superAdminPost.m.php');
        exit;
    }

    $query = mysqli_query($con, "DELETE FROM `tbl_faqs` WHERE `faq_id` = '$faq_id'");

    if ($query) {
        $_SESSION['delete_faq_message'] = "FAQ successfully deleted";
        header('Location: ../superAdminPost.m.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
}
