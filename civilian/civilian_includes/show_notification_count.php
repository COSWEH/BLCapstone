<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


<?php
include('../../includes/conn.inc.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location: ../post.c.php');
    exit;
}

$getUserid = $_SESSION['user_id'];
$user_role = $_SESSION['role_id'];
$user_brgy = $_SESSION['user_brgy'];

// Validate the user against the database
$checkUser = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `user_id` = '$getUserid' LIMIT 1");
$countUser = mysqli_num_rows($checkUser);

$getReqID = "SELECT r.req_id, r.user_id
          FROM tbl_requests AS r 
          INNER JOIN tbl_useracc AS u ON r.user_id = u.user_id
          WHERE r.user_id = '$getUserid'";

// If user does not exist, sign out
if ($countUser < 1) {
    header('Location: ../signout.php');
    exit;
}

// If user role is not civilian
if ($user_role != 0) {
    header('Location: ../unauthorized.php');
    exit;
}

$reqIDResult = mysqli_query($con, $getReqID);

// Check if the query was successful and fetch the result
if ($reqIDResult) {
    if (mysqli_num_rows($reqIDResult) > 0) {
        $getReqIDdata = mysqli_fetch_assoc($reqIDResult);
        $req_id = $getReqIDdata['req_id'];

        // Only proceed if req_id is not null
        if ($req_id) {
            // Query to check notifications for the given req_id
            $checkNotif = mysqli_query($con, "SELECT * FROM `tbl_notification` WHERE `req_id` = '$req_id' AND `status` = 'unread'");

            // Check if the query was successful
            if ($checkNotif) {
                $countNotif = mysqli_num_rows($checkNotif);

                // Display notification badge if there are unread notifications
                if ($countNotif > 0) {
                    echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">';
                    echo $countNotif;
                    echo '</span>';
                }
            } else {
                // Handle query error (optional)
                echo 'Error fetching notifications: ' . mysqli_error($con);
            }
        }
    }
} else {
    // Handle query error (optional)
    echo 'Error fetching req_id: ' . mysqli_error($con);
}
