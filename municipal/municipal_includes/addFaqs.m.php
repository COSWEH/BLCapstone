<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_POST['btnFaqs']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    if (empty($question) || empty($answer)) {
        header('Location: ../superAdminPost.m.php');
        exit;
    }

    $question = mysqli_real_escape_string($con, $question);
    $answer = mysqli_real_escape_string($con, $answer);

    $query = mysqli_query($con, "INSERT INTO `tbl_faqs`(`faq_id`, `faq_question`, `faq_answer`, `faq_created_at`) VALUES ('', '$question', '$answer', CURRENT_TIMESTAMP)");

    if ($query) {
        $_SESSION['faq_message'] = "FAQs successfully addedd";
        header('Location: ../superAdminPost.m.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
}
