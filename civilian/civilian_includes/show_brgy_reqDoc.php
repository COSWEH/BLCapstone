<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id'])) {
    header('location: ../document.c.php');
    exit;
}

$civilian_brgy = $_SESSION['user_brgy'];

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

    <!-- List of Document Requests -->
    <!-- Document Card -->
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
                        <h6>
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?php
                            if ($status == "Approved") {
                            ?>
                                <span class="badge fw-bold text-bg-success" style="width: 6rem;">
                                    <?php echo $status; ?>
                                </span>
                            <?php
                            } elseif ($status == "Processing") {
                            ?>
                                <span class="badge fw-bold text-bg-primary" style="width: 6rem;">
                                    <?php echo $status; ?>
                                </span>
                            <?php
                            } else {
                            ?>
                                <span class="text-bg-warning badge fw-bold" style="width: 6rem;">
                                    <?php echo $status; ?>
                                </span>
                            <?php
                            }
                            ?>

                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>