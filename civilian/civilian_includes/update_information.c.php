<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_POST['btnUpdate']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_SESSION['user_id'];
    $fromSanIsidro = $_POST['fromSanIsidro'];
    $barangay = $_POST['barangay'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $contactNum = $_POST['contactNum'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "
    UPDATE tbl_useracc 
    SET 
        fromSanIsidro = '$fromSanIsidro',
        user_brgy = '$barangay',
        user_fname = '$fname',
        user_mname = '$mname',
        user_lname = '$lname',
        user_gender = '$gender',
        user_address = '$address',
        user_contactNum = '$contactNum',
        user_email = '$email',
        username = '$username',
        password = '$password'
    WHERE user_id = '$userid'
";

    if (mysqli_query($con, $query)) {
        // update session variables
        $_SESSION['fromSanIsidro'] = $fromSanIsidro;
        $_SESSION['user_brgy'] = $barangay;
        $_SESSION['user_fname'] = $fname;
        $_SESSION['user_mname'] = $mname;
        $_SESSION['user_lname'] = $lname;
        $_SESSION['user_gender'] = $gender;
        $_SESSION['user_address'] = $address;
        $_SESSION['user_contactNum'] = $contactNum;
        $_SESSION['user_email'] = $email;
        $_SESSION['username'] = $username;

        $_SESSION['update_message'] = "Updated successfully!";
        $_SESSION['update_message_code'] = "Success";
        header('location: ../profile.c.php');
    } else {
        $_SESSION['update_message'] = "Error updating record!";
        $_SESSION['update_message_code'] = "Error";
        header('location: ../profile.c.php');
    }
    exit;
} else {
    header('location: ../post.c.php');
    exit;
}
