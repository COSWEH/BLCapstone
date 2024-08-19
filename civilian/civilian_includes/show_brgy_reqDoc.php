<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id'])) {
    header('location: ../document.c.php');
    exit;
}

$civilian_brgy = $_SESSION['user_brgy'];

$query = "SELECT req_id, user_id, req_date, req_fname, req_mname, req_lname, req_contactNo, req_gender, req_brgy, req_purok, req_age, req_dateOfBirth, req_placeOfBirth, req_civilStatus, req_typeOfDoc, req_password, req_status
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
    $mname = $data['req_mname'];
    $lname = $data['req_lname'];
    $contactNo = $data['req_contactNo'];
    $gender = $data['req_gender'];
    $brgy = $data['req_brgy'];
    $purok = $data['req_purok'];
    $age = $data['req_age'];
    $dateOfBirth = $data['req_dateOfBirth'];
    $req_placeOfBirth = $data['req_placeOfBirth'];
    $req_civilStatus = $data['req_civilStatus'];
    $docType = $data['req_typeOfDoc'];
    $status = $data['req_status'];

    $get_Time_And_Day = new DateTime($reqDate);
    $formattedDate = $get_Time_And_Day->format('Y-m-d H:i:s');
?>

    <!-- List of Document Requests -->
    <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-3">
        <div class="card shadow border border-2">
            <div class="card-body">
                <h4 class="card-title mb-3"><?php echo $docType; ?></h4>
                <hr>
                <div class="d-flex flex-column mb-3">
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="font-weight-bold">
                            <i class="bi bi-person-fill me-2"></i>
                            <?php echo $fname . " " . $mname . " " . $lname; ?>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="font-weight-bold">
                            <i class="bi bi-phone-fill me-2"></i>
                            <?php echo $contactNo; ?>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="font-weight-bold">
                            <i class="bi bi-gender-ambiguous me-2"></i>
                            <?php echo $gender; ?>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="font-weight-bold">
                            <i class="bi bi-house-door-fill me-2"></i>
                            <?php echo $brgy; ?>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="font-weight-bold">
                            <i class="bi bi-calendar-fill me-2"></i>
                            <?php echo $dateOfBirth; ?>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="font-weight-bold">
                            <i class="bi bi-geo-alt-fill me-2"></i>
                            Purok
                            <?php echo $purok; ?>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="font-weight-bold">
                            <i class="bi bi-geo-alt-fill me-2"></i>
                            <?php echo $req_placeOfBirth; ?>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="font-weight-bold">
                            <i class="bi bi-person-hearts me-2"></i>
                            <?php echo $req_civilStatus; ?>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="font-weight-bold">
                            <i class="bi bi-calendar3 me-2"></i>
                            Age: <?php echo $age; ?>
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
                        <div class="container">
                            <div class="progress" role="progressbar" aria-label="Progress bar" style="width: 100%;" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" style="width: <?php echo $percentage; ?>%"></div>
                            </div>

                            <div class="d-flex justify-content-between mt-2">
                                <div class="text-center position-relative">
                                    <?php
                                    if ($percentage >= 0) {
                                        echo '<i class="bi bi-check-circle-fill text-success"></i>';
                                        echo '<div><small class="text-success">Pending</small></div>';
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
                                        echo '<div><small class="text-success">Processing</small></div>';
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
                                        echo '<div><small class="text-success">Approved</small></div>';
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

<?php
}
?>