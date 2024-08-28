<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../phpmailer/src/Exception.php';
require '../../phpmailer/src/PHPMailer.php';
require '../../phpmailer/src/SMTP.php';

include('../../includes/conn.inc.php');
$config = include('../../config/config.php');
session_start();

if (isset($_POST['btnSignup']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $fromSanIsidro = ucwords(strtolower($_SESSION['fromSanIsidro']));
    $barangay = ucwords(strtolower($_SESSION['user_brgy']));
    $fname = ucwords(strtolower($_POST['fname']));
    $mname = ucwords(strtolower($_POST['mname']));
    $lname = ucwords(strtolower($_POST['lname']));
    $gender = $_POST['gender'];
    $address = ucwords(strtolower($_POST['address']));
    $contactNum = $_POST['contactNum'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['signupPassword'];
    $confirmPassword = $_POST['confirmPassword'];


    $_SESSION['superAdmin_fname'] = $fname;
    $_SESSION['superAdmin_mname'] = $mname;
    $_SESSION['superAdmin_lname'] = $lname;
    $_SESSION['superAdmin_gender'] = $gender;
    $_SESSION['superAdmin_address'] = $address;
    $_SESSION['superAdmin_contactNum'] = $contactNum;
    $_SESSION['superAdmin_email'] = $email;
    $_SESSION['superAdmin_username'] = $username;
    $_SESSION['superAdmin_password'] = $password;


    function validateName($name)
    {
        $pattern = "/^[a-zA-Z\s\-]+$/";
        return preg_match($pattern, $name) === 1;
    }

    function validateAddress($address)
    {
        $pattern = "/^[a-zA-Z0-9\s\-.,]+$/";
        return preg_match($pattern, $address) === 1;
    }

    function validatePhoneNumber($phoneNumber)
    {
        $pattern = "/^(09\d{9}|639\d{9})$/";
        return preg_match($pattern, $phoneNumber) === 1;
    }

    function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    function validateUsername($username)
    {
        $pattern = "/^[a-zA-Z]{2}[a-zA-Z0-9.@_\\-\\s]+$/";
        return preg_match($pattern, $username) === 1;
    }

    function validatePassword($password)
    {
        return strlen($password) >= 8; // need at least 8 characters long
    }

    $fname_result = validateName($fname);
    $mname_result = validateName($mname);
    $lname_result = validateName($lname);
    $address_result = validateAddress($address);
    $contactNum_result = validatePhoneNumber($contactNum);
    $email_result = validateEmail($email);
    $username_result = validateUsername($username);
    $password_result = validatePassword($password);

    $errors = [];

    if (!$fname_result) {
        $errors[] = "First Name is invalid.";
    }
    if (!$mname_result) {
        $errors[] = "Middle Name is invalid.";
    }
    if (!$lname_result) {
        $errors[] = "Last Name is invalid.";
    }
    if (!$address_result) {
        $errors[] = "Address is invalid.";
    }
    if (!$contactNum_result) {
        $errors[] = "Phone Number is invalid.";
    }
    if (!$email_result) {
        $errors[] = "Email is invalid.";
    }
    if (!$username_result) {
        $errors[] = "Username is invalid.";
    }
    if (!$password_result) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    if (empty($errors)) {

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //check if the username is already exist
            $checkUsername = mysqli_query($con, "SELECT * FROM tbl_useracc WHERE username = '$username' LIMIT 1");
            $countUsername = mysqli_num_rows($checkUsername);

            //check if the email address is already exist
            $checkEmail = mysqli_query($con, "SELECT * FROM tbl_useracc WHERE user_email = '$email' LIMIT 1");
            $countEmail = mysqli_num_rows($checkEmail);

            if ($countUsername == 1) {
                $_SESSION['addAdmin_error_message'] = "Username already exists!";
                header('location: ../superAdminPost.m.php');
            } elseif ($countEmail == 1) {
                $_SESSION['addAdmin_error_message'] = "Email address already exists!";
                header('location: ../superAdminPost.m.php');
            } elseif ($password != $confirmPassword) {
                $_SESSION['addAdmin_error_message'] = "Password did not match!";
                header('location: ../superAdminPost.m.php');
            } else {
                $verification_code = mt_rand(100000, 999999);

                $message = "<h3>Your OTP number is <span class='fw-bold' style='font-size: 20px'>$verification_code</span></h3>
                <p>Use this code to register your account.</p>
                <br>
                <br>
                <p>With regards,</p>
                <p>BayanLink Team</p>";

                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = $config['email'];
                $mail->Password = $config['password'];
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                $mail->setFrom($config['email'], 'BayanLink');

                $mail->addAddress($email);

                $mail->isHTML(true);

                $mail->Subject = "BayanLink Verification Code";
                $mail->Body = $message;

                $mail->send();

                $_SESSION['verification_code'] = $verification_code;
                echo '
            <form id="redirectForm" action="verify_account.php" method="POST">
                <input type="hidden" name="verification_code" value="' . htmlspecialchars($verification_code) . '">
                <input type="hidden" name="email" value="' . htmlspecialchars($email) . '">
            </form>
            <script>
                document.getElementById("redirectForm").submit();
            </script>
            ';
                exit;
            }
            exit;
        }
    } else {
        // Concatenate error messages into a single string
        $error_message = implode("<br>", $errors);
        $_SESSION['addAdmin_error_message'] = $error_message;
        header('location: ../superAdminPost.m.php');
        exit;
    }
} else {
    header('location: ../superAdminPost.m.php');
    exit;
}