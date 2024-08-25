<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../phpmailer/src/Exception.php';
require '../../phpmailer/src/PHPMailer.php';
require '../../phpmailer/src/SMTP.php';

include('../../includes/conn.inc.php');
$config = include('../../config/config.php');
session_start();

$admin_brgy = $_SESSION['user_brgy'];
$get_Time_And_Day = new DateTime();
$formattedDate = $get_Time_And_Day->format('h:i A D, M j, Y');


if (isset($_POST['btnConfirm']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $ifProcessOrApprove = $_POST['ifProcessOrApprove'];

    if ($ifProcessOrApprove == "Process") {
        $process_req_id = $_POST['getProcessReqDocId'];
        $process_status = "Processing";

        $getRequesterID = mysqli_query($con, "SELECT `user_id` FROM `tbl_requests` WHERE `req_id` = $process_req_id");
        $getResult = mysqli_fetch_assoc($getRequesterID);
        $civilianID = $getResult['user_id'];

        $getCivilianEmail = mysqli_query($con, "SELECT `user_email` FROM `tbl_useracc` WHERE `user_id` = $civilianID");
        $getCivilianResult = mysqli_fetch_assoc($getCivilianEmail);
        $civilianEmail = $getCivilianResult['user_email'];


        $query = mysqli_query($con, "UPDATE `tbl_requests` SET `req_status` = '$process_status' WHERE `req_id` = '$process_req_id'");

        $notify_query = mysqli_query($con, "INSERT INTO `tbl_notification`(`notify_id`, `req_id`, `description`, `status`, `notify_date`) VALUES ('', '$process_req_id', 'Processed', 'unread', CURRENT_TIMESTAMP)");

        $message = "<h3>Admin of $admin_brgy</h3>
                <p>Processed your Document.</p>
                <p>$formattedDate</p>
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

        $mail->addAddress($civilianEmail);

        $mail->isHTML(true);

        $mail->Subject = "BayanLink Document Request";
        $mail->Body = $message;

        $mail->send();

        if ($query) {
            $_SESSION['processing_message'] = "Processing!";
            header('Location: ../adminDocument.b.php');
            exit;
        } else {
            die('Error: ' . mysqli_error($con));
        }
    } elseif ($ifProcessOrApprove == "Approve") {
        //echo "approve";
        $approve_req_id = $_POST['getApproveReqDocId'];
        $approve_status = "Approved";

        $getRequesterID = mysqli_query($con, "SELECT `user_id` FROM `tbl_requests` WHERE `req_id` = $approve_req_id");
        $getResult = mysqli_fetch_assoc($getRequesterID);
        $civilianID = $getResult['user_id'];

        $getCivilianEmail = mysqli_query($con, "SELECT `user_email` FROM `tbl_useracc` WHERE `user_id` = $civilianID");
        $getCivilianResult = mysqli_fetch_assoc($getCivilianEmail);
        $civilianEmail = $getCivilianResult['user_email'];

        $query = mysqli_query($con, "UPDATE `tbl_requests` SET `req_status` = '$approve_status' WHERE `req_id` = '$approve_req_id'");

        $notify_query = mysqli_query($con, "INSERT INTO `tbl_notification`(`notify_id`, `req_id`, `description`, `status`, `notify_date`) VALUES ('', '$approve_req_id', 'Approved', 'unread', CURRENT_TIMESTAMP)");

        $message = "<h3>Admin of $admin_brgy</h3>
                <p>Approved your Document.</p>
                <p>$formattedDate</p>
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

        $mail->addAddress($civilianEmail);

        $mail->isHTML(true);

        $mail->Subject = "BayanLink Document Request";
        $mail->Body = $message;

        $mail->send();

        if ($query) {
            $_SESSION['approved_message'] = "Approved!";
            header('Location: ../adminDocument.b.php');
            exit;
        } else {
            die('Error: ' . mysqli_error($con));
        }
    } elseif ($ifProcessOrApprove == "Cancel") {
        $cancel_req_id = $_POST['getCancelReqDocId'];
        $cancel_status = "Cancelled";

        $cancellationReason = implode(", ", $_POST['options-base']);

        $getRequesterID = mysqli_query($con, "SELECT `user_id` FROM `tbl_requests` WHERE `req_id` = $cancel_req_id");
        $getResult = mysqli_fetch_assoc($getRequesterID);
        $civilianID = $getResult['user_id'];

        $getCivilianEmail = mysqli_query($con, "SELECT `user_email` FROM `tbl_useracc` WHERE `user_id` = $civilianID");
        $getCivilianResult = mysqli_fetch_assoc($getCivilianEmail);
        $civilianEmail = $getCivilianResult['user_email'];

        $query = mysqli_query($con, "UPDATE `tbl_requests` SET `req_status` = '$cancel_status', `req_reasons` = '$cancellationReason' WHERE `req_id` = '$cancel_req_id'");

        $notify_query = mysqli_query($con, "INSERT INTO `tbl_notification`(`notify_id`, `req_id`, `description`, `status`, `notify_date`) VALUES ('', '$cancel_req_id', 'Cancelled', 'unread', CURRENT_TIMESTAMP)");

        $cancellationReason = trim($cancellationReason);
        $cancellationReason = rtrim($cancellationReason, ', ');

        $reasonList = ''; // Initialize the variable to store the HTML list

        if (!empty($cancellationReason)) {
            // Convert the comma-separated string into an array and clean up
            $cancellationReasonArray = array_map('trim', explode(", ", $cancellationReason));
            $cancellationReasonArray = array_filter($cancellationReasonArray);

            // Create the HTML list of reasons
            $reasonList = "<hr>
                   <h6>Cancellation Reasons:</h6>
                   <ul>";
            foreach ($cancellationReasonArray as $reason) {
                // Escape each reason for safe HTML output
                $escapedReason = htmlspecialchars($reason, ENT_QUOTES, 'UTF-8');
                $reasonList .= "<li><small>$escapedReason</small></li>";
            }
            $reasonList .= '</ul>';
        }

        // Create the message with cancellation reasons included
        $message = "<h3>Admin of $admin_brgy</h3>
            <p>Cancelled your Document.</p>
            <p>$formattedDate</p>
            $reasonList
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

        $mail->addAddress($civilianEmail);

        $mail->isHTML(true);

        $mail->Subject = "BayanLink Document Request";
        $mail->Body = $message;

        $mail->send();

        if ($query) {
            $_SESSION['cancelled_message'] = "Cancelled!";
            header('Location: ../adminDocument.b.php');
            exit;
        } else {
            die('Error: ' . mysqli_error($con));
        }
    }
} else {
    header('location: ../adminDocument.b.php');
    exit;
}
