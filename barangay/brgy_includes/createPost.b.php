<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_POST['baBtnCreatePost']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    global $imgArray;

    if (!empty($_FILES['bgAddPhotos']['name'][0])) {
        $imgCount = count($_FILES['bgAddPhotos']['name']);
        $imgArray = array();
        $maxSize = 8 * 1024 * 1024; // 8MB in bytes
        $targetDimension = 750;

        for ($i = 0; $i < $imgCount; $i++) {
            $imgName = $_FILES['bgAddPhotos']['name'][$i];
            $tmpName = $_FILES['bgAddPhotos']['tmp_name'][$i];
            $imgSize = $_FILES['bgAddPhotos']['size'][$i];

            // Check if the image size exceeds the maximum allowed size
            if ($imgSize > $maxSize) {
                die('Error: Each image must be 8MB or smaller.');
            }

            $imgExtension = explode('.', $imgName);
            $imgExtension = strtolower(end($imgExtension));

            $imgBaseName = pathinfo($imgName, PATHINFO_FILENAME);
            $newImgName = $imgBaseName . '-[BayanLink-' . uniqid() . '].' . $imgExtension;

            // Load the image
            list($width, $height) = getimagesize($tmpName);
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

            $squareImage = imagecreatetruecolor($targetDimension, $targetDimension);

            $bgColor = imagecolorallocate($squareImage, 18, 18, 20);
            imagefill($squareImage, 0, 0, $bgColor);

            // Determine new width and height to fit the target size
            if ($width > $height) {
                $newWidth = $targetDimension;
                $newHeight = intval($height * ($targetDimension / $width));
            } else {
                $newHeight = $targetDimension;
                $newWidth = intval($width * ($targetDimension / $height));
            }

            // Center the image in the square
            $xOffset = intval(($targetDimension - $newWidth) / 2);
            $yOffset = intval(($targetDimension - $newHeight) / 2);

            // Resize the image and place it in the square canvas
            imagecopyresampled($squareImage, $imageResource, $xOffset, $yOffset, 0, 0, $newWidth, $newHeight, $width, $height);

            // Save the new image to the local folder
            $destination = '../brgy_dbImages/' . $newImgName;
            switch ($imgExtension) {
                case 'jpeg':
                case 'jpg':
                    imagejpeg($squareImage, $destination);
                    break;
                case 'png':
                    imagepng($squareImage, $destination);
                    break;
                case 'gif':
                    imagegif($squareImage, $destination);
                    break;
            }

            // Free memory
            imagedestroy($imageResource);
            imagedestroy($squareImage);

            $imgArray[] = $newImgName;
        }
        $imgArray = json_encode($imgArray);
    } else {
        $imgArray = json_encode([]);
    }

    $userid = $_SESSION['user_id'];
    $post_brgy = $_SESSION['user_brgy'];
    $content = strip_tags($_POST['baTextContent']); // Remove HTML tags
    $content = mysqli_real_escape_string($con, $content); // Escape special characters for SQL

    $query = mysqli_query($con, "INSERT INTO `tbl_posts`(`post_id`, `user_id`, `post_brgy`, `post_content`, `post_img`, `post_date`) VALUES ('', '$userid', '$post_brgy', '$content', '$imgArray', CURRENT_TIMESTAMP)");

    //  add logs
    $username = $_SESSION['username'];
    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $username created a post', CURRENT_TIMESTAMP,'$userid')");


    if ($query) {
        $_SESSION['post_message'] = "Post successfully created";
        header('Location: ../adminPost.b.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
} else {
    header('location: ../adminPost.b.php');
    exit;
}
