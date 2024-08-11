<?php
include('../../includes/conn.inc.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['baBtnDeletePost'])) {
    $post_id =  $_POST['getPostIdToDelete'];
    $img = $_SESSION['getImg'];
    $imgArray = json_decode($img, true);

    // check if success to decode
    if ($imgArray) {
        foreach ($imgArray as $imgFile) {
            $filePath = '../municipal_dbImages/' . $imgFile;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }

    $query = mysqli_query($con, "DELETE FROM `tbl_posts` WHERE `post_id` = '$post_id'");

    if ($query) {
        $_SESSION['delete_message'] = "Post successfully deleted";
        header('Location: ../superAdminPost.m.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
} else {
    header('location: ../superAdminPost.m.php');
    exit;
}