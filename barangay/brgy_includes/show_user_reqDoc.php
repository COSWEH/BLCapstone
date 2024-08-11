<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id'])) {
    header('location: ../document.c.php');
    exit;
}

$civilian_brgy = $_SESSION['user_brgy'];

$query = "SELECT req_id, user_id, req_date, req_fname, req_lname, req_contactNo, req_brgy, req_typeOfDoc, req_valid_id, req_password, req_status
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
                        <th>Valid ID</th>
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
                        $req_valid_id = $data['req_valid_id'];
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
                            <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-image-src="../civilian/civilian_dbValidID/<?php echo $req_valid_id; ?>">
                                    <img src="../civilian/civilian_dbValidID/<?php echo $req_valid_id; ?>" class="img-fluid rounded" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                </a>
                            </td>
                            <td><?php echo $status; ?></td>
                            <td>

                                <div class="dropdown-center">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Options
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item aProcess" data-post-id="<?php echo $reqId; ?>" data-bs-toggle="modal" data-bs-target="#processModal">Process</a></li>
                                        <li><a class="dropdown-item aAprrove" data-post-id="<?php echo $reqId; ?>" data-bs-toggle="modal" data-bs-target="#approveModal">Approve</a></li>
                                    </ul>
                                </div>

                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">View Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" class="img-fluid" style="max-width: 100%; height: auto;">
                </div>
            </div>
        </div>
    </div>


    <!-- process modal -->
    <div class="modal fade" id="processModal" tabindex="-1" aria-labelledby="processModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <div class="w-100 text-center">
                        <h4 class="modal-title fw-bold" id="processModalLabel">
                            Process
                        </h4>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="brgy_includes/update_user_reqDoc.php" method="POST">
                        <div class="text-center mb-3">
                            <div class="mb-3">
                                <i class="bi bi-exclamation-circle" style="font-size: 100px;"></i>
                            </div>
                            <h3 class="mb-3">Confirm to process.</h3>
                        </div>
                        <div class="text-center">
                            <input type="hidden" id="getProcessReqDocId" name="getProcessReqDocId">
                            <input type="hidden" name="ifProcessOrApprove" value="Process">
                            <button type="submit" name="btnConfirm" class="btn btn-success me-2 fw-bold">Confirm</button>
                            <button type="button" class="btn btn-danger fw-bold" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
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
                            <input type="hidden" id="getApproveReqDocId" name="getApproveReqDocId">
                            <input type="hidden" name="ifProcessOrApprove" value="Approve">
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
        $(document).on('click', '.aProcess', function() {
            let p_id = $(this).data('post-id');
            $('#getProcessReqDocId').val(p_id);
        });
        $(document).on('click', '.aAprrove', function() {
            let p_id = $(this).data('post-id');
            $('#getApproveReqDocId').val(p_id);
        });

        $('#imageModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var imageSrc = button.data('image-src');
            var modalImage = $(this).find('#modalImage');
            modalImage.attr('src', imageSrc);
        });
    });
</script>