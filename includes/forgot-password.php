<?php
include('conn.inc.php');
session_start();

if (isset($_POST['btnForgotPassword']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $fpEmail = $_POST['fpEmail'];
    $fpEmail = htmlspecialchars($fpEmail);

    $_SESSION['fpMessage'] = "We have sent a password reset link to $fpEmail.";
    header('location: ../index.php');
    exit;
}
