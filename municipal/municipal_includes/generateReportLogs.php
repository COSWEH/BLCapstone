<?php
include('../../includes/conn.inc.php');
session_start();


require __DIR__ . "../../../vendor/autoload.php";

use Dompdf\Dompdf;

$dompdf = new Dompdf;

if (isset($_POST['btnGenerateReportLogs']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
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

    $startDate = date('Y-m-d 00:00:00', strtotime($startDate));
    $endDate = date('Y-m-d 23:59:59', strtotime($endDate));

    // Combine the admin's full name
    $adminFullname = $admin_fname . " " . $admin_mname . " " . $admin_lname;

    $getAllLogsByDate = "SELECT * FROM `tbl_logs` WHERE `log_date` BETWEEN '$startDate' AND '$endDate' ";
    $logsResult = mysqli_query($con, $getAllLogsByDate);

    if (!$logsResult) {
        die('Error in query: ' . mysqli_error($con));
    }
} else {
    header('location: ../superAdminDashboard.php');
    exit;
}

$bootstrapCss = "
.container {
    width: 100%;
    padding: 10px;
    margin: 0 auto;
}
.mt-5 {
    margin-top: 1.5rem;
}
.mb-4 {
    margin-bottom: 1rem;
}
.text-light {
    color: #f8f9fa !important;
}
.bg-success {
    background-color: #28a745 !important;
}
.text-center {
    text-align: center;
}
.rounded {
    border-radius: .2rem;
}
.lead {
    font-size: 1rem;
}
.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, .125);
    border-radius: .2rem;
}
.card-body {
    flex: 1 1 auto;
    padding: 10px;
}
.shadow-sm {
    box-shadow: 0 .1rem .2rem rgba(0, 0, 0, .075) !important;
}

.mb-0 {
    margin-bottom: 0 !important;
}
.mb-3 {
    margin-bottom: .5rem !important;
}
.mt-4 {
    margin-top: .75rem !important;
}
.card-title {
    margin-bottom: .5rem;
}
.display-4 {
    font-size: 2rem;
    font-weight: 300;
    line-height: 1.1;
}
.h5 {
    font-size: 1.1rem;
    font-weight: 500;
    line-height: 1.2;
}
.lead {
    font-size: 1rem;
    font-weight: 300;
    line-height: 1.4;
}
.p-3 {
    padding: .5rem !important;
}
.py-3 {
    padding-top: .5rem !important;
    padding-bottom: .5rem !important;
}
.mb-3 {
    margin-bottom: .5rem !important;
}
.mb-4 {
    margin-bottom: 1rem !important;
}
.list-group-item {
    position: relative;
    display: block;
    padding: .5rem 1rem;
    margin-bottom: -1px;
    background-color: #fff;
    border: 1px solid rgba(0, 0, 0, .125);
}

/* Additional table styling */
.table {
    width: 100%;
    margin-bottom: 1rem;
    color: #212529;
}
.table-bordered {
    border: 1px solid #dee2e6;
}
.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, .05);
}
.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, .075);
}
.table-success {
    color: #155724;
    background-color: #c3e6cb;
}
.text-uppercase {
    text-transform: uppercase;
}
";


$currentDateTime = date('Y-m-d H:i:s');
$currentYear = date('Y');

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

        <div class="table-responsive">
            <table class="table align-middle table-bordered table-striped table-hover text-center text-capitalized">
                <thead class="table-active text-uppercase text-white">
                    <tr>
                        <th><small>Log ID</small></th>
                        <th><small>Log Description</small></th>
                        <th><small>Log Date</small></th>
                        <th><small>User ID</small></th>
                    </tr>
                </thead>
                <tbody>
HTML;

// Process logs and append them to HTML
if (mysqli_num_rows($logsResult) === 0) {
    $html .= "<tr><td colspan='4'>No logs found for the specified date range.</td></tr>";
} else {
    while ($data = mysqli_fetch_assoc($logsResult)) {
        $log_id = htmlspecialchars($data['log_id']);
        $log_desc = htmlspecialchars($data['log_desc']);
        $log_date = htmlspecialchars($data['log_date']);
        $user_id = htmlspecialchars($data['user_id']);

        $html .= "
            <tr>
                <td><small>$log_id</small></td>
                <td><small>$log_desc</small></td>
                <td><small>$log_date</small></td>
                <td><small>$user_id</small></td>
            </tr>
        ";
    }
}

$html .= <<<HTML
                </tbody>
            </table>
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
