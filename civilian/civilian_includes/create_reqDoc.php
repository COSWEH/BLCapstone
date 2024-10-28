<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_POST['btnReqDocument']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['getUserid'];
    $req_fname = ucwords(strtolower($_POST['fName']));
    $req_mname = ucwords(strtolower($_POST['mName']));
    $req_lname = ucwords(strtolower($_POST['lName']));
    $req_contactNo = $_POST['contNumber'];
    $req_gender = ucwords(strtolower($_POST['user_gender']));
    $req_brgy = ucwords(strtolower($_POST['user_brgy']));
    $req_purok = $_POST['purok'];
    $req_age = $_POST['age'];
    $req_dateOfBirth = $_POST['dateOfBirth'];
    $req_placeOfBirth = ucwords(strtolower($_POST['placeOfBirth']));
    $req_civilStatus = ucwords(strtolower($_POST['civilStatus']));
    $req_typeOfDoc = $_POST['docType'];
    $req_status = "Pending";

    $username = $_SESSION['username'];

    $req_fname = mysqli_real_escape_string($con, $req_fname);
    $req_mname = mysqli_real_escape_string($con, $req_mname);
    $req_lname = mysqli_real_escape_string($con, $req_lname);
    $req_placeOfBirth = mysqli_real_escape_string($con, $req_placeOfBirth);

    $forOthers = $_POST['requestType'];

    if (
        empty($user_id) || empty($req_fname) || empty($req_lname) || empty($req_contactNo) || empty($req_gender) ||
        empty($req_brgy) || empty($req_purok) || empty($req_age) || empty($req_dateOfBirth) || empty($req_placeOfBirth) ||
        empty($req_civilStatus) || empty($req_typeOfDoc)
    ) {
        header('location: ../document.c.php');
        exit;
    }

    // File size limit (e.g., 8MB)
    $maxFileSize = 8 * 1024 * 1024; // 8MB in bytes

    // Handle the file upload
    if (isset($_FILES['userValidIDFront']) && isset($_FILES['userValidIDBack']) && isset($_FILES['eSignature'])) {
        $eSignatureFile = $_FILES['eSignature'];
        $validFrontIDFile = $_FILES['userValidIDFront'];
        $validBackIDFile = $_FILES['userValidIDBack'];

        if (isset($forOthers) && $forOthers === 'others') {
            echo $forOthers;

            $authLetter = $_FILES['authLetter'];

            if ($authLetter['error'] !== UPLOAD_ERR_OK) {
                die('Error: Letter of Consent file upload error.');
            }

            if ($authLetter['size'] > $maxFileSize) {
                die('Error: Letter of Consent file size exceeds the limit of 8MB.');
            }

            $authLetterName = $authLetter['name'];
            $authLetterTmpName = $authLetter['tmp_name'];
            $authLetterExtension = strtolower(pathinfo($authLetterName, PATHINFO_EXTENSION));
            $authLetterBaseName = pathinfo($authLetterName, PATHINFO_FILENAME);
            $newauthLetterName = $authLetterBaseName . '-[BayanLink-' . uniqid() . '].' . $authLetterExtension;

            $authLetterPath = '../civilian_dbImg/' . $newauthLetterName;

            if (!move_uploaded_file($authLetterTmpName, $authLetterPath)) {
                die('Error: Failed to move Valid ID file.');
            }
        }



        if ($eSignatureFile['error'] !== UPLOAD_ERR_OK) {
            die('Error: E-Signature file upload error.');
        }

        if ($eSignatureFile['size'] > $maxFileSize) {
            die('Error: E-Signature file size exceeds the limit of 8MB.');
        }

        $eSignatureName = $eSignatureFile['name'];
        $eSignatureTmpName = $eSignatureFile['tmp_name'];
        $eSignatureExtension = strtolower(pathinfo($eSignatureName, PATHINFO_EXTENSION));
        $eSignatureBaseName = pathinfo($eSignatureName, PATHINFO_FILENAME);
        $newESignatureName = $eSignatureBaseName . '-[BayanLink-' . uniqid() . '].' . $eSignatureExtension;


        if ($validFrontIDFile['error'] !== UPLOAD_ERR_OK) {
            die('Error: Valid ID file upload error.');
        }

        if ($validFrontIDFile['size'] > $maxFileSize) {
            die('Error: Valid ID file size exceeds the limit of 8MB.');
        }

        $validFrontIDName = $validFrontIDFile['name'];
        $validFrontIDTmpName = $validFrontIDFile['tmp_name'];
        $validFrontIDExtension = strtolower(pathinfo($validFrontIDName, PATHINFO_EXTENSION));
        $validFrontIDBaseName = pathinfo($validFrontIDName, PATHINFO_FILENAME);
        $newValidFrontIDName = $validFrontIDBaseName . '-[BayanLink-' . uniqid() . '].' . $validFrontIDExtension;

        if ($validBackIDFile['error'] !== UPLOAD_ERR_OK) {
            die('Error: Valid ID file upload error.');
        }

        if ($validBackIDFile['size'] > $maxFileSize) {
            die('Error: Valid ID file size exceeds the limit of 8MB.');
        }

        $validBackIDName = $validBackIDFile['name'];
        $validBackIDTmpName = $validBackIDFile['tmp_name'];
        $validBackIDExtension = strtolower(pathinfo($validBackIDName, PATHINFO_EXTENSION));
        $validBackIDBaseName = pathinfo($validBackIDName, PATHINFO_FILENAME);
        $newValidBackIDName = $validBackIDBaseName . '-[BayanLink-' . uniqid() . '].' . $validBackIDExtension;

        $eSignaturePath = '../civilian_dbImg/' . $newESignatureName;
        $validFrontIDPath = '../civilian_dbImg/' . $newValidFrontIDName;
        $validBackIDPath = '../civilian_dbImg/' . $newValidBackIDName;


        // Check directory existence and create if necessary
        if (!is_dir('../civilian_dbImg')) {
            mkdir(
                '../civilian_dbImg',
                0755,
                true
            );
        }


        if (!move_uploaded_file($eSignatureTmpName, $eSignaturePath)) {
            die('Error: Failed to move E-Signature file.');
        }
        if (!move_uploaded_file($validFrontIDTmpName, $validFrontIDPath)) {
            die('Error: Failed to move Valid ID file.');
        }
        if (!move_uploaded_file($validBackIDTmpName, $validBackIDPath)) {
            die('Error: Failed to move Valid ID file.');
        }

        echo 'Files uploaded successfully.';
    } else {
        die('Error: No files uploaded or there was an upload error.');
    }

    $checkUser = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `user_id` = '$user_id' LIMIT 1");
    $countUser = mysqli_num_rows($checkUser);

    if ($countUser > 0) {

        $query = mysqli_query($con, "INSERT INTO `tbl_requests` (`req_id`, `user_id`, `req_date`, `req_fname`, `req_mname`, `req_lname`, `req_contactNo`, `req_gender`, `req_brgy`, `req_purok`, `req_age`, `req_dateOfBirth`, `req_placeOfBirth`, `req_civilStatus`, `req_eSignature`, `req_typeOfDoc`, `authLetter`, `req_valid_front_id`, `req_valid_back_id`, `req_status`) VALUES ('', '$user_id', CURRENT_TIMESTAMP, '$req_fname', '$req_mname', '$req_lname', '$req_contactNo', '$req_gender', '$req_brgy', '$req_purok', '$req_age', '$req_dateOfBirth', '$req_placeOfBirth', '$req_civilStatus', '$newESignatureName', '$req_typeOfDoc', '$newauthLetterName', '$newValidFrontIDName', '$newValidBackIDName', '$req_status')");

        // add logs
        mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','$req_typeOfDoc request submitted successfully.', CURRENT_TIMESTAMP,'$user_id')");

        if ($query) {
            $_SESSION['reqDoc_message'] = "Document submitted";
            header('location: ../document.c.php');
            exit;
        } else {
            die('Error: ' . mysqli_error($con));
        }
    }
} else {
    header('location: ../document.c.php');
    exit;
}
