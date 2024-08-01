<?php
include('includes/conn.inc.php');
session_start();

if (isset($_POST['btnSignup']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $fromSanIsidro = ucwords(strtolower($_POST['fromSanIsidro']));
    $barangay = ucwords(strtolower($_POST['barangay']));
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
    $role_id = 0;

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
                $_SESSION['signup_error_message'] = "Username already exists!";
                header('Location: index.php');
            } elseif ($countEmail == 1) {
                $_SESSION['signup_error_message'] = "Email address already exists!";
                header('Location: index.php');
            } elseif ($password != $confirmPassword) {
                $_SESSION['signup_error_message'] = "Password did not match!";
                header('Location: index.php');
            } else {
                //if non is existed, proceed to insert
                $password = password_hash($password, PASSWORD_DEFAULT);
                $insert = mysqli_query($con, "INSERT INTO tbl_useracc (user_id, fromSanIsidro, user_brgy, user_fname, user_mname, user_lname, user_gender, user_address, user_contactNum, user_email, username, password, role_id) VALUES ('', '$fromSanIsidro', '$barangay', '$fname', '$mname', '$lname', '$gender', '$address', '$contactNum', '$email', '$username', '$password', '$role_id')");

                if ($insert) {
                    $_SESSION['signup_success_message'] = "Register successfully!";
                    header('Location: index.php');
                    exit;
                }
                exit;
            }
            exit;
        }
    } else {
        // Concatenate error messages into a single string
        $error_message = implode("<br>", $errors);
        $_SESSION['signup_error_message'] = $error_message;
        header('Location: index.php');
    }
}
