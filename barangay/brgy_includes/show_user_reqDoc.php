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
} else {
?>
    <!-- Bootstrap Responsive Table -->
    <div class="container">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Document Type</th>
                        <th>Requester</th>
                        <th>Contact Number</th>
                        <th>Barangay</th>
                        <th>Date Requested</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
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
                        <tr>
                            <td><?php echo $docType; ?></td>
                            <td><?php echo $fname . " " . $lname; ?></td>
                            <td><?php echo $contactNo; ?></td>
                            <td><?php echo $brgy; ?></td>
                            <td><?php echo $formattedDate; ?></td>
                            <td><?php echo $status; ?></td>
                            <td>

                                <?php
                                if ($status == "Approved") {
                                ?>
                                    <button type="button" class="btn btn-success btn-sm fw-bold btnApprove" disabled>Approve</button>
                                <?php
                                } else {
                                ?>
                                    <button type="button" class="btn btn-success btn-sm fw-bold btnApprove" data-post-id="<?php echo $reqId; ?>" data-bs-toggle="modal" data-bs-target="#approveModal">Approve</button>
                                <?php
                                }
                                ?>

                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- approve modal -->
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <div class="w-100 text-center">
                        <h4 class="modal-title fw-bold" id="approveModalLabel">
                            Approve
                        </h4>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="brgy_includes/update_user_reqDoc.php" method="POST">
                        <div class="text-center mb-3">
                            <div class="mb-3">
                                <i class="bi bi-exclamation-circle" style="font-size: 100px;"></i>
                            </div>
                            <h3 class="mb-3">Confirm to approve.</h3>
                        </div>
                        <div class="text-center">
                            <input type="hidden" id="getReqDocId" name="getReqDocId">
                            <button type="submit" name="btnConfirm" class="btn btn-success me-2 fw-bold">Confirm</button>
                            <button type="button" class="btn btn-danger fw-bold" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>

<script>
    $(document).ready(function() {
        $(document).on('click', '.btnApprove', function() {
            let p_id = $(this).data('post-id');
            $('#getReqDocId').val(p_id);
        });
    });
</script>