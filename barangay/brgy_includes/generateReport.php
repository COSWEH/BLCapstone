<?php
include('../../includes/conn.inc.php');
session_start();

require __DIR__ . "../../../vendor/autoload.php";

use Dompdf\Dompdf;

$dompdf = new Dompdf;

if (isset($_POST['btnGenerateReport']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminUserID = $_SESSION['user_id'];

    $getAdminFullname = "SELECT `user_fname`, `user_mname`, `user_lname` FROM `tbl_useracc` WHERE `user_id` = '$adminUserID'";
    $result = mysqli_query($con, $getAdminFullname);

    if (!$result) {
        die('Error in query: ' . mysqli_error($con));
    }

    while ($data = mysqli_fetch_assoc($result)) {
        $admin_fname = $data['user_fname'];
        $admin_mname = $data['user_mname'];
        $admin_lname = $data['user_lname'];
    }

    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $barangay = $_SESSION['user_brgy'];

    // Combine the admin's full name
    $adminFullname = $admin_fname . " " . $admin_mname . " " . $admin_lname;
} else {
    header('location: ../adminDashboard.php');
    exit;
}

function getTotalRegistedUsers($con, $brgy, $startDate, $endDate)
{
    $startDate = date('Y-m-d 00:00:00', strtotime($startDate));
    $endDate = date('Y-m-d 23:59:59', strtotime($endDate));

    if ($brgy === 'All Barangays') {
        $getRegisteredUsers = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `role_id` = 0 AND `user_create_at` BETWEEN '$startDate' AND '$endDate'");
    } else {
        $getRegisteredUsers = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `role_id` = 0 AND `user_brgy` = '$brgy' AND `user_create_at` BETWEEN '$startDate' AND '$endDate'");
    }

    return mysqli_num_rows($getRegisteredUsers);
}

function countAllMaleFemaleUsers($con, $sex, $brgy, $startDate, $endDate)
{
    $startDate = date('Y-m-d 00:00:00', strtotime($startDate));
    $endDate = date('Y-m-d 23:59:59', strtotime($endDate));

    if ($brgy === 'All Barangays') {
        $getUserSex = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `user_gender` = '$sex' AND `role_id` = 0 AND `user_create_at` BETWEEN '$startDate' AND '$endDate'");
    } else {
        $getUserSex = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `user_gender` = '$sex' AND `role_id` = 0 AND `user_brgy` = '$brgy' AND `user_create_at` BETWEEN '$startDate' AND '$endDate'");
    }

    return mysqli_num_rows($getUserSex);
}

function countDocumentReleased($con, $allDocType, $brgy, $startDate, $endDate)
{
    $startDate = date('Y-m-d 00:00:00', strtotime($startDate));
    $endDate = date('Y-m-d 23:59:59', strtotime($endDate));

    $barangays = [
        "Alua",
        "Calaba",
        "Malapit",
        "Mangga",
        "Poblacion",
        "Pulo",
        "San Roque",
        "Sto. Cristo",
        "Tabon"
    ];

    $totalApprovedDocuments = 0;
    // Loop through each barangay
    if ($brgy === 'All Barangays') {
        foreach ($barangays as $barangay) {
            // Query to get the count of approved documents for the current barangay
            $getDocType = mysqli_query($con, "SELECT * FROM `tbl_requests` WHERE `req_typeOfDoc` = '$allDocType($barangay)' AND `req_brgy` = '$barangay' AND `req_status` = 'Approved' AND `req_date` BETWEEN '$startDate' AND '$endDate'");
            $countGetDocType = mysqli_num_rows($getDocType);

            // Store the count in the array
            $totalApprovedDocuments += $countGetDocType;
        }
    } else {
        $getDocType = mysqli_query($con, "SELECT * FROM `tbl_requests` WHERE `req_typeOfDoc` = '$allDocType($brgy)' AND `req_brgy` = '$brgy' AND `req_status` = 'Approved' AND `req_date` BETWEEN '$startDate' AND '$endDate'");
        $totalApprovedDocuments = mysqli_num_rows($getDocType);
    }

    return $totalApprovedDocuments;
}

$totalUsers = getTotalRegistedUsers($con, $barangay, $startDate, $endDate);
$totalMaleUsers = countAllMaleFemaleUsers($con, 'Male', $barangay, $startDate, $endDate);
$totalFemaleUsers = countAllMaleFemaleUsers($con, 'Female', $barangay, $startDate, $endDate);
$totalClearance = countDocumentReleased($con, 'Barangay Clearance', $barangay, $startDate, $endDate);
$totalIndigency = countDocumentReleased($con, 'Barangay Indigency', $barangay, $startDate, $endDate);
$totalResidency = countDocumentReleased($con, 'Barangay Residency', $barangay, $startDate, $endDate);
$totalJobSeeker = countDocumentReleased($con, 'Job Seeker', $barangay, $startDate, $endDate);
$adminFullname = isset($adminFullname) ? $adminFullname : 'Municipal Admin';
$currentYear = date('Y');
$currentDateTime = date('Y-m-d h:i:s A');


$bootstrapCss = "
.container{width:100%;padding:10px;margin:0 auto}.mt-5{margin-top:1.5rem}.mb-4{margin-bottom:1rem}.text-light{color:#f8f9fa!important}.bg-success{background-color:#28a745!important}.text-center{text-align:center}.rounded{border-radius:.2rem}.lead{font-size:1rem}.card{position:relative;display:flex;flex-direction:column;min-width:0;word-wrap:break-word;background-color:#fff;background-clip:border-box;border:1px solid rgba(0,0,0,.125);border-radius:.2rem}.card-body{flex:1 1 auto;padding:10px}.shadow-sm{box-shadow:0 .1rem .2rem rgba(0,0,0,.075)!important}.list-group{margin-bottom:0}.list-group-item{position:relative;display:block;padding:.5rem 1rem;margin-bottom:-1px;background-color:#fff;border:1px solid rgba(0,0,0,.125)}.mb-0{margin-bottom:0!important}.mb-3{margin-bottom:.5rem!important}.mt-4{margin-top:.75rem!important}.card-title{margin-bottom:.5rem}.display-4{font-size:2rem;font-weight:300;line-height:1.1}.h5{font-size:1.1rem;font-weight:500;line-height:1.2}.lead{font-size:1rem;font-weight:300;line-height:1.4}.p-3{padding:.5rem!important}.py-3{padding-top:.5rem!important;padding-bottom:.5rem!important}.mb-3{margin-bottom:.5rem!important}.mb-4{margin-bottom:1rem!important}.list-group-item{position:relative;display:block;padding:.5rem 1rem;margin-bottom:-1px;background-color:#fff;border:1px solid rgba(0,0,0,.125)}
";


$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bayanlink Report</title>
    <style>
        $bootstrapCss
    </style>
</head>
<body>
    <div class="container">
        <header class="bg-success text-light text-center mb-4 py-3 rounded">
            <h1 class="display-4">Bayanlink Report Generation</h1>
            <p class="lead">Generate comprehensive reports for your records</p>
        </header>

        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h2 class="card-title mb-4">Generated Report from $startDate to $endDate</h2>
                <h4>Place: <span>$barangay</span></h4>
                <h4>Total Registered Users: <span>$totalUsers</span></h4>
                <h4>Total Male Users: <span>$totalMaleUsers</span></h4>
                <h4>Total Female Users: <span>$totalFemaleUsers</span></h4>

                <h4>Total Documents Released:</h4>
                <ul class="list-group">
                    <li class="list-group-item">Barangay Clearance: <strong>$totalClearance</strong></li>
                    <li class="list-group-item">Barangay Indigency: <strong>$totalIndigency</strong></li>
                    <li class="list-group-item">Barangay Residency: <strong>$totalResidency</strong></li>
                    <li class="list-group-item">Job Seeker: <strong>$totalJobSeeker</strong></li>
                </ul>
            </div>
        </div>

        <footer class="bg-success text-light text-center mt-4 py-3 rounded">
            <p>Generated by: <strong>$adminFullname</strong></p>
            <p>Generated on: <strong>$currentDateTime</strong></p>
            <p class="mb-0">&copy; $currentYear Bayanlink. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
HTML;

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
header("Content-type: application/pdf");
$dompdf->stream("Bayanlink_Report.pdf", ["Attachment" => false]);
