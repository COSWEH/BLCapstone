<?php
include('includes/conn.inc.php');
session_start();

$_SESSION['user_id'] = 3;
$_SESSION['role_id'] = 0;

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role_id'])) {
    header('Location: signout.php');
    exit;
}

echo ".";
$getUserid = $_SESSION['user_id'];
$user_role = $_SESSION['role_id'];

// Validate the user against the database
$checkUser = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `user_id` = '$getUserid' LIMIT 1");
$countUser = mysqli_num_rows($checkUser);

// If user does not exist, sign out
if ($countUser < 1) {
    header('Location: signout.php');
    exit;
}

// If user role is not civilian
if ($user_role != 0) {
    header('Location: unauthorized.php');
    exit;
}

$civilian_brgy = "Malapit";

$query = "SELECT req_id, user_id, req_date, req_fname, req_lname, req_contactNo, req_brgy, req_typeOfDoc, req_password, req_status
          FROM tbl_requests
          WHERE req_brgy = '$civilian_brgy'
          ORDER BY req_date DESC";


$result = mysqli_query($con, $query);

if (!$result) {
    die('Error in query: ' . mysqli_error($con));
}

$rowCount = mysqli_num_rows($result);
if ($rowCount == 0) {
    echo "<p>No document requests found.</p>";
}

while ($data = mysqli_fetch_assoc($result)) {
    // Fetch data from tbl_requests
    $reqId = $data['req_id'];
    $userId = $data['user_id'];
    $reqDate = $data['req_date'];
    $fname = $data['req_fname'];
    $lname = $data['req_lname'];
    $contactNo = $data['req_contactNo'];
    $brgy = $data['req_brgy'];
    $docType = $data['req_typeOfDoc'];
    $status = $data['req_status'];

    $get_Time_And_Day = new DateTime($reqDate);
    $formattedDate = $get_Time_And_Day->format('Y-m-d H:i:s');
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <!-- Bootstrap CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <!-- Bootstrap icon CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <!-- SweetAlert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- jquery ajax cdn -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-3">
                    <div class="card shadow border border-2">
                        <div class="card-body">
                            <h4 class="card-title mb-3"><?php echo $docType; ?></h4>
                            <hr>
                            <div class="d-flex flex-column mb-3">
                                <div class="d-flex justify-content-between mb-3">
                                    <h6 class="font-weight-bold">
                                        <i class="bi bi-person-fill me-2"></i>
                                        <?php echo $fname . " " . $lname; ?>
                                    </h6>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <h6 class="font-weight-bold">
                                        <i class="bi bi-phone me-2"></i>
                                        <?php echo $contactNo; ?>
                                    </h6>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <h6 class="font-weight-bold">
                                        <i class="bi bi-house-door me-2"></i>
                                        <?php echo $brgy; ?>
                                    </h6>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <h6 class="font-weight-bold">
                                        <i class="bi bi-file-earmark-text-fill me-2"></i>
                                        <?php echo $docType; ?>
                                    </h6>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <h6 class="font-weight-bold">
                                        <i class="bi bi-calendar me-2"></i>
                                        <?php echo $formattedDate; ?>
                                    </h6>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <?php
                                    if ($status == "Approved") {
                                        $percentage = 100;
                                    } elseif ($status == "Processing") {
                                        $percentage = 50;
                                    } else {
                                        $percentage = 0;
                                    }
                                    ?>
                                    <div class="container ">

                                        <div class="progress" role="progressbar" aria-label="Success striped example" style="width: 100%;" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" style="width: <?php echo $percentage; ?>%"></div>
                                        </div>

                                        <div class="d-flex justify-content-between mt-2">
                                            <div class="text-center position-relative">
                                                <?php
                                                if ($percentage >= 0) {
                                                    echo '<i class="bi bi-check-circle-fill text-success"></i>';
                                                    echo '<div><small>Pending</small></div>';
                                                } else {
                                                    echo '<i class="bi bi-check-circle"></i>';
                                                    echo '<div><small>Pending</small></div>';
                                                }
                                                ?>
                                            </div>
                                            <div class="text-center position-relative">
                                                <?php
                                                if ($percentage >= 50) {
                                                    echo '<i class="bi bi-check-circle-fill text-success"></i>';
                                                    echo '<div><small>Processing</small></div>';
                                                } else {
                                                    echo '<i class="bi bi-check-circle"></i>';
                                                    echo '<div><small>Processing</small></div>';
                                                }
                                                ?>
                                            </div>
                                            <div class="text-center position-relative">
                                                <?php
                                                if ($percentage >= 100) {
                                                    echo '<i class="bi bi-check-circle-fill text-success"></i>';
                                                    echo '<div><small>Approved</small></div>';
                                                } else {
                                                    echo '<i class="bi bi-check-circle"></i>';
                                                    echo '<div><small>Approved</small></div>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php
}
    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>