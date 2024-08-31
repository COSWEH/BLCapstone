<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id'])) {
    header('location: ../document.c.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$civilian_brgy = $_SESSION['user_brgy'];

$query = "SELECT req_id, user_id, req_date, req_fname, req_mname, req_lname, req_contactNo, req_gender, req_brgy, req_purok, req_age, req_dateOfBirth, req_placeOfBirth, req_civilStatus, req_typeOfDoc, req_status, req_reasons
          FROM tbl_requests
          WHERE user_id = '$user_id' && req_brgy = '$civilian_brgy' && req_status = 'Cancelled'
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
    $reasons = $data['req_reasons'];

    $get_Time_And_Day = new DateTime($reqDate);
    $formattedDate = $get_Time_And_Day->format('Y-m-d H:i:s');
?>

    <!-- List of Document Requests -->
    <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-3">
        <div class="card shadow border border-2">
            <div class="card-body">
                <h5 class="card-title mb-3 text-center fw-bold"><?php echo $docType; ?></h5>
                <hr>
                <div class="d-flex flex-column mb-3">
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="font-weight-bold">
                            <i class="bi bi-person-fill me-2">
                                <span class="ms-2">Name:</span>
                            </i>
                            <small>
                                <?php echo $fname . " " . $mname . " " . $lname; ?>
                            </small>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="font-weight-bold">
                            <i class="bi bi-phone-fill me-2">
                                <span class="ms-2">Contact No:</span>
                            </i>
                            <small>
                                <?php echo $contactNo; ?>
                            </small>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="font-weight-bold">
                            <i class="bi bi-gender-ambiguous me-2">
                                <span class="ms-2">Gender:</span>
                            </i>
                            <small>
                                <?php echo $gender; ?>
                            </small>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="font-weight-bold">
                            <i class="bi bi-house-door-fill me-2">
                                <span class="ms-2">Barangay:</span>
                            </i>
                            <small>
                                <?php echo $brgy; ?>
                            </small>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="font-weight-bold">
                            <i class="bi bi-calendar-fill me-2">
                                <span class="ms-2">Date of Birth:</span>
                            </i>
                            <small>
                                <?php echo $dateOfBirth; ?>
                            </small>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="font-weight-bold">
                            <i class="bi bi-geo-alt-fill me-2">
                                <span class="ms-2">Purok:</span>
                            </i>
                            <small>
                                <?php echo $purok; ?>
                            </small>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="font-weight-bold">
                            <i class="bi bi-geo-alt-fill me-2">
                                <span class="ms-2">Place of Birth:</span>
                            </i>
                            <small>
                                <?php echo $req_placeOfBirth; ?>
                            </small>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="font-weight-bold">
                            <i class="bi bi-person-hearts me-2">
                                <span class="ms-2">Civil Status:</span>
                            </i>
                            <small>
                                <?php echo $req_civilStatus; ?>
                            </small>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="font-weight-bold">
                            <i class="bi bi-calendar3 me-2">
                                <span class="ms-2">Age:</span>
                            </i>
                            <small>
                                <?php echo $age; ?> years old
                            </small>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-bold">
                            <i class="bi bi-exclamation-triangle-fill">
                                <span class="ms-2">Status:</span>
                            </i>
                            <small class="text-warning">
                                <?php echo $status; ?>
                            </small>
                        </h6>
                    </div>
                    <?php
                    $reasons = trim($reasons);
                    $reasons = rtrim($reasons, ', ');

                    if (!empty($reasons)) {
                        $reasonsArray = array_map('trim', explode(", ", $reasons));
                        $reasonsArray = array_filter($reasonsArray);

                        echo "<hr>";
                        echo "<h6>Cancellation Reasons:</h6>";
                        echo '<ul>';
                        foreach ($reasonsArray as $reason) {
                            // Escape each reason for safe HTML output
                            $escapedReason = htmlspecialchars($reason, ENT_QUOTES, 'UTF-8');
                            echo "<li><small>$escapedReason</small></li>";
                        }
                        echo '</ul>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
</script>