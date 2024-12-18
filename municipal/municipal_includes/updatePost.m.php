<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_POST['mBtnEditPost']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['getPostIdToUpdate'];
    $userid = $_SESSION['user_id'];
    $post_brgy = $_SESSION['getAdminBrgy'];
    $content = $_POST['textContent'];

    $dbImgArray = [];
    $selectedImgArray = [];
    $maxSize = 8 * 1024 * 1024; // 8MB in bytes

    if (isset($_POST['mDbPhotos'])) {
        $jsonString = $_POST['mDbPhotos'];
        $dbImgArray = json_decode($jsonString, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo 'Error decoding JSON: ' . json_last_error_msg();
        } else {
            echo 'Decoded DB JSON: ';
            print_r($dbImgArray);
        }
    } else {
        echo 'mDbPhotos is not set.';
    }

    if (!empty($_FILES['updatePhotos']['name'][0])) {
        $imgCount = count($_FILES['updatePhotos']['name']);

        for ($i = 0; $i < $imgCount; $i++) {
            $imgName = $_FILES['updatePhotos']['name'][$i];
            $tmpName = $_FILES['updatePhotos']['tmp_name'][$i];
            $imgSize = $_FILES['updatePhotos']['size'][$i];

            // Check if the image size exceeds the maximum allowed size
            if ($imgSize > $maxSize) {
                die('Error: Each image must be 8MB or smaller.');
            }

            $imgExtension = explode('.', $imgName);
            $imgExtension = strtolower(end($imgExtension));

            $imgBaseName = pathinfo($imgName, PATHINFO_FILENAME);
            $newImgName = $imgBaseName . '-[BayanLink-' . uniqid() . '].' . $imgExtension;

            $imageResource = null;

            switch ($imgExtension) {
                case 'jpeg':
                case 'jpg':
                    $imageResource = imagecreatefromjpeg($tmpName);
                    break;
                case 'png':
                    $imageResource = imagecreatefrompng($tmpName);
                    break;
                case 'gif':
                    $imageResource = imagecreatefromgif($tmpName);
                    break;
                default:
                    die('Unsupported image format.');
            }

            $originalWidth = imagesx($imageResource);
            $originalHeight = imagesy($imageResource);

            $newImageResource = imagecreatetruecolor(750, 750);
            $backgroundColor = imagecolorallocate($newImageResource, 18, 18, 20);
            imagefill($newImageResource, 0, 0, $backgroundColor);

            $scale = min(750 / $originalWidth, 750 / $originalHeight);
            $newWidth = (int)($originalWidth * $scale);
            $newHeight = (int)($originalHeight * $scale);

            imagecopyresampled($newImageResource, $imageResource, (750 - $newWidth) / 2, (750 - $newHeight) / 2, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

            // Save the resized image
            switch ($imgExtension) {
                case 'jpeg':
                case 'jpg':
                    imagejpeg($newImageResource, '../municipal_dbImages/' . $newImgName);
                    break;
                case 'png':
                    imagepng($newImageResource, '../municipal_dbImages/' . $newImgName);
                    break;
                case 'gif':
                    imagegif($newImageResource, '../municipal_dbImages/' . $newImgName);
                    break;
            }

            // Free up memory
            imagedestroy($imageResource);
            imagedestroy($newImageResource);

            $selectedImgArray[] = $newImgName;
        }
    } else {
        $selectedImgArray = [];
    }

    if (!is_array($dbImgArray)) {
        $dbImgArray = [];
    }

    if (!is_array($selectedImgArray)) {
        $selectedImgArray = [];
    }

    $combinedImgArray = array_merge($dbImgArray, $selectedImgArray);

    echo '<br><br>Combined Images Array: ';
    print_r($combinedImgArray);

    $combinedImgArrayJson = json_encode($combinedImgArray);

    echo '<br><br>Combined Images Array: ';
    print_r($combinedImgArray);

    $combinedImgArrayJson = json_encode($combinedImgArray);
    $content = strip_tags($content); // Remove HTML tags
    $content = mysqli_real_escape_string($con, $content); // Escape special characters for SQL

    $query = mysqli_query($con, "UPDATE `tbl_posts` SET 
    `user_id` = '$userid', 
    `post_brgy` = '$post_brgy', 
    `post_content` = '$content', 
    `post_img` = '$combinedImgArrayJson', 
    `post_date` = CURRENT_TIMESTAMP 
    WHERE `post_id` = '$post_id'");

    // add logs
    $user_name = $_SESSION['username'];
    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','Post content updated successfully.', CURRENT_TIMESTAMP,'$userid')");

    //Check for success
    if ($query) {
        $_SESSION['post_message'] = "Post successfully updated";
        header('Location: ../superAdminPost.m.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
} else {
    header('location: ../superAdminPost.m.php');
    exit;
}
