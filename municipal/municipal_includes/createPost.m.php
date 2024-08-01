<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_POST['maBtnCreatePost']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    global $imgArray;

    if (!empty($_FILES['mAddPhotos']['name'][0])) {
        $imgCount = count($_FILES['mAddPhotos']['name']);
        $imgArray = array();

        for ($i = 0; $i < $imgCount; $i++) {
            $imgName = $_FILES['mAddPhotos']['name'][$i];
            $tmpName = $_FILES['mAddPhotos']['tmp_name'][$i];

            $imgExtension = explode('.', $imgName);
            $imgExtension = strtolower(end($imgExtension));

            $imgBaseName = pathinfo($imgName, PATHINFO_FILENAME);
            $newImgName = $imgBaseName . '-[BayanLink-' . uniqid() . '].' . $imgExtension;

            // move to the local folder
            move_uploaded_file($tmpName, '../municipal_dbImages/' . $newImgName);
            $imgArray[] = $newImgName;
        }
        $imgArray = json_encode($imgArray);
    } else {
        $imgArray = json_encode([]);
    }

    $userid = $_SESSION['user_id'];
    $post_brgy = 'Municipal';
    $content = strip_tags($_POST['textContent']); // Remove HTML tags
    $content = mysqli_real_escape_string($con, $content); // Escape special characters for SQL

    $query = mysqli_query($con, "INSERT INTO `tbl_posts`(`post_id`, `user_id`, `post_brgy`, `post_content`, `post_img`, `post_date`) VALUES ('', '$userid', '$post_brgy', '$content', '$imgArray', CURRENT_TIMESTAMP)");


    if ($query) {
        $_SESSION['post_message'] = "Post successfully created";
        header('Location: ../superAdminPost.m.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
} else {
    header('location: ../superAdminPost.m.php');
    exit;
}
