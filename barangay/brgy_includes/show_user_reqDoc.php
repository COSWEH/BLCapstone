<style>
    .table-header {
        width: 100px;
        height: 50px;
        vertical-align: middle;
    }
</style>

<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id'])) {
    header('location: ../document.c.php');
    exit;
}

$civilian_brgy = $_SESSION['user_brgy'];

$query = "SELECT req_id, user_id, req_date, req_fname, req_mname, req_lname, req_contactNo, req_gender, req_brgy, req_purok, req_age, req_dateOfBirth, req_placeOfBirth, req_civilStatus, req_eSignature, req_typeOfDoc, req_valid_id, req_password, req_status
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
            <table class="table table-sm table-striped table-bordered border-secondary table-hover">
                <thead>
                    <tr>
                        <th class="p-2 text-center table-header">Document Type</th>
                        <th class="p-2 text-center table-header">Requester</th>
                        <th class="p-2 text-center table-header">Purok</th>
                        <th class="p-2 text-center table-header">Age</th>
                        <th class="p-2 text-center table-header">Date of Birth</th>
                        <th class="p-2 text-center table-header">Place of Birth</th>
                        <th class="p-2 text-center table-header">Gender</th>
                        <th class="p-2 text-center table-header">Civil Status</th>
                        <th class="p-2 text-center table-header">Contact Number</th>
                        <th class="p-2 text-center table-header">Barangay</th>
                        <th class="p-2 text-center table-header">Date Requested</th>
                        <th class="p-2 text-center table-header">e-Signature</th>
                        <th class="p-2 text-center table-header">Valid ID</th>
                        <th class="p-2 text-center table-header">Status</th>
                        <th class="p-2 text-center table-header">Action</th>
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
                        $req_eSignature = $data['req_eSignature'];
                        $docType = $data['req_typeOfDoc'];
                        $status = $data['req_status'];
                        $req_valid_id = $data['req_valid_id']; // Ensure this is fetched correctly

                        $get_Time_And_Day = new DateTime($reqDate);
                        $formattedDate = $get_Time_And_Day->format('Y-m-d H:i:s');
                    ?>
                        <tr>
                            <td class="p-2 text-center"><?php echo htmlspecialchars($docType); ?></td>
                            <td class="p-2 text-center"><?php echo htmlspecialchars($fname . " " . $mname . " " . $lname); ?></td>
                            <td class="p-2 text-center"><?php echo htmlspecialchars($purok); ?></td>
                            <td class="p-2 text-center"><?php echo htmlspecialchars($age); ?></td>
                            <td class="p-2 text-center"><?php echo htmlspecialchars($dateOfBirth); ?></td>
                            <td class="p-2 text-center"><?php echo htmlspecialchars($req_placeOfBirth); ?></td>
                            <td class="p-2 text-center"><?php echo htmlspecialchars($gender); ?></td>
                            <td class="p-2 text-center"><?php echo htmlspecialchars($req_civilStatus); ?></td>
                            <td class="p-2 text-center"><?php echo htmlspecialchars($contactNo); ?></td>
                            <td class="p-2 text-center"><?php echo htmlspecialchars($brgy); ?></td>
                            <td class="p-2 text-center"><?php echo htmlspecialchars($formattedDate); ?></td>
                            <td class="p-2">
                                <?php if (!empty($req_eSignature)) { ?>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_eSignature); ?>">
                                        <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_eSignature); ?>" class="img-fluid rounded" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                    </a>
                                <?php } else { ?>
                                    <span>No E-Signature</span>
                                <?php } ?>
                            </td>
                            <td class="p-2">
                                <?php if (!empty($req_valid_id)) { ?>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_valid_id); ?>">
                                        <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_valid_id); ?>" class="img-fluid rounded" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                    </a>
                                <?php } else { ?>
                                    <span>No Valid ID</span>
                                <?php } ?>
                            </td>
                            <td class="p-2 text-center"><?php echo htmlspecialchars($status); ?></td>
                            <td class="p-2">
                                <?php
                                if ($status != 'Cancelled') {
                                ?>
                                    <div class="dropdown-center">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Options
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item aProcess" data-post-id="<?php echo htmlspecialchars($reqId); ?>" data-bs-toggle="modal" data-bs-target="#processModal">Process</a></li>
                                            <li><a class="dropdown-item aApprove" data-post-id="<?php echo htmlspecialchars($reqId); ?>" data-bs-toggle="modal" data-bs-target="#approveModal">Approve</a></li>
                                        </ul>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <button class="btn btn-sm btn-secondary dropdown-toggle disabled" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Options
                                    </button>
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