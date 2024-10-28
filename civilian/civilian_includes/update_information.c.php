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
    $user_purok = $_POST['user_purok'];
    $contactNum = $_POST['contactNum'];
    $dateOfBirth = $_POST['dateOfBirth'];

    $dob = new DateTime($dateOfBirth);
    $now = new DateTime();
    $interval = $now->diff($dob);
    $age = $interval->y;

    $placeOfBirth = $_POST['placeOfBirth'];
    $civilStatus = $_POST['civilStatus'];
    $email = $_POST['email'];
    $username = $_POST['username'];

    $fname = mysqli_real_escape_string($con, $fname);
    $mname = mysqli_real_escape_string($con, $mname);
    $lname = mysqli_real_escape_string($con, $lname);
    $username = mysqli_real_escape_string($con, $username);
    $placeOfBirth = mysqli_real_escape_string($con, $placeOfBirth);

    $currentProfileImage = $_SESSION['user_profile'];
    $newImageName = $_POST['current_profile_image']; // Default to the current image

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        // New image uploaded
        $imageFileType = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
        $newImageName = uniqid() . '.' . $imageFileType; // Generate unique filename

        // Set upload directory
        $targetDir = "../civilian_dbImg/";
        $targetFile = $targetDir . $newImageName;

        // Delete old profile image if it exists and is not the default image
        if (
            !empty($currentProfileImage) && $currentProfileImage != 'male-user.png' && $currentProfileImage != 'female-user.png'
        ) {
            $oldImagePath = $targetDir . $currentProfileImage;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Delete the old image
            }
        }

        // Move uploaded file to the target directory
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
            echo 'file uploaded';
        } else {
            $_SESSION['update_message'] = "Error uploading the new profile image!";
            $_SESSION['update_message_code'] = "Error";
            header('location: ../profile.c.php');
            exit;
        }
    }

    if (
        empty($userid) || empty($fromSanIsidro) || empty($barangay) || empty($fname) || empty($lname) || empty($gender) || empty($user_purok) || empty($contactNum)
        || empty($dateOfBirth)
        || empty($placeOfBirth)
        || empty($civilStatus) || empty($email) || empty($username)
    ) {
        header('location: ../profile.c.php');
        exit;
    }

    $query = "
    UPDATE tbl_useracc 
    SET 
        fromSanIsidro = '$fromSanIsidro',
        user_brgy = '$barangay',
        user_fname = '$fname',
        user_mname = '$mname',
        user_lname = '$lname',
        user_gender = '$gender',
        user_contactNum = '$contactNum',
        dateOfBirth = '$dateOfBirth',
        user_age = '$age',
        placeOfBirth = '$placeOfBirth',
        civilStatus = '$civilStatus',
        user_purok = '$user_purok',
        user_email = '$email',
        username = '$username',
        user_profile = '$newImageName' -- Add the profile image here
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
        $_SESSION['user_contactNum'] = $contactNum;
        $_SESSION['dateOfBirth'] = $dateOfBirth;
        $_SESSION['user_age'] = $age;
        $_SESSION['placeOfBirth'] = $placeOfBirth;
        $_SESSION['civilStatus'] = $civilStatus;
        $_SESSION['user_purok'] = $user_purok;
        $_SESSION['user_email'] = $email;
        $_SESSION['username'] = $username;
        $_SESSION['user_profile'] = $newImageName;

        // add logs
        mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','Account information updated successfully.', CURRENT_TIMESTAMP,'$userid')");

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
