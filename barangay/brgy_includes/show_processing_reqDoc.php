<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id'])) {
    header('location: ../adminDocument.b.php');
    exit;
}

$civilian_brgy = $_SESSION['user_brgy'];

$query = "SELECT req_id, user_id, req_date, req_fname, req_mname, req_lname, req_contactNo, req_gender, req_brgy, req_purok, req_age, req_dateOfBirth, req_placeOfBirth, req_civilStatus, req_eSignature, req_typeOfDoc, req_valid_id, req_status
          FROM tbl_requests
          WHERE req_brgy = '$civilian_brgy' && req_status = 'Processing'
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
            <table class="table table-responsive table-bordered border border-3 table-hover text-center text-capitalized">
                <thead class="table-active text-uppercase text-white">
                    <tr>
                        <th><small>Document Type</small></th>
                        <th><small>Requester</small></th>
                        <th><small>Purok</small></th>
                        <th><small>Age</small></th>
                        <th><small>Date of Birth</small></th>
                        <th><small>Place of Birth</small></th>
                        <th><small>Gender</small></th>
                        <th><small>Civil Status</small></th>
                        <th><small>Contact Number</small></th>
                        <th><small>Barangay</small></th>
                        <th><small>Date Requested</small></th>
                        <th><small>e-Signature</small></th>
                        <th><small>Valid ID</small></th>
                        <th><small>Status</small></th>
                        <th><small>Action</small></th>
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
                        $req_valid_id = $data['req_valid_id'];
                        $get_Time_And_Day = new DateTime($reqDate);
                        $formattedDate = $get_Time_And_Day->format('Y-m-d H:i:s');


                        $_SESSION['getRequesterID'] = $userId;
                    ?>
                        <tr>
                            <td><small><?php echo htmlspecialchars($docType); ?></small></td>
                            <td><small><?php echo htmlspecialchars($fname . " " . $mname . " " . $lname); ?></small></td>
                            <td><small><?php echo htmlspecialchars($purok); ?></small></td>
                            <td><small><?php echo htmlspecialchars($age); ?></small></td>
                            <td><small><?php echo htmlspecialchars($dateOfBirth); ?></small></td>
                            <td><small><?php echo htmlspecialchars($req_placeOfBirth); ?></small></td>
                            <td><small><?php echo htmlspecialchars($gender); ?></small></td>
                            <td><small><?php echo htmlspecialchars($req_civilStatus); ?></small></td>
                            <td><small><?php echo htmlspecialchars($contactNo); ?></small></td>
                            <td><small><?php echo htmlspecialchars($brgy); ?></small></td>
                            <td><small><?php echo htmlspecialchars($formattedDate); ?></small></td>
                            <td>
                                <?php if (!empty($req_eSignature)) { ?>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#esModal<?php echo $status; ?>" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_eSignature); ?>">
                                        <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_eSignature); ?>" class="img-fluid rounded" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                    </a>
                                <?php } else { ?>
                                    <span>No E-Signature</span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if (!empty($req_valid_id)) { ?>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#vidModal<?php echo $status; ?>" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_valid_id); ?>">
                                        <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_valid_id); ?>" class="img-fluid rounded" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                    </a>
                                <?php } else { ?>
                                    <span>No Valid ID</span>
                                <?php } ?>
                            </td>
                            <td><small><?php echo htmlspecialchars($status); ?></small></td>
                            <td>
                                <?php
                                if ($status != 'Cancelled') {
                                ?>
                                    <div class="dropdown-bottom">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Options
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item aCancel" data-post-id="<?php echo htmlspecialchars($reqId); ?>" data-bs-toggle="modal" data-bs-target="#cancelModal<?php echo $status; ?>"><small>Cancel</small></a></li>
                                            <li><a class="dropdown-item aApprove" data-post-id="<?php echo htmlspecialchars($reqId); ?>" data-bs-toggle="modal" data-bs-target="#approveModal<?php echo $status; ?>"><small>Approve</small></a></li>

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


    <!-- es Modal -->
    <div class="modal fade" id="esModal<?php echo $status; ?>" tabindex="-1" aria-labelledby="esModal<?php echo $status; ?>Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="esModal<?php echo $status; ?>Label">View Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="esModalImage<?php echo $status; ?>" class="img-fluid" style="max-width: 100%; height: auto;">
                </div>
            </div>
        </div>
    </div>

    <!-- vid Modal -->
    <div class="modal fade" id="vidModal<?php echo $status; ?>" tabindex="-1" aria-labelledby="vidModal<?php echo $status; ?>Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vidModal<?php echo $status; ?>Label">View Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="vidModalImage<?php echo $status; ?>" class="img-fluid" style="max-width: 100%; height: auto;">
                </div>
            </div>
        </div>
    </div>

    <!-- cancel modal -->
    <div class="modal fade" id="cancelModal<?php echo $status; ?>" tabindex="-1" aria-labelledby="cancelModal<?php echo $status; ?>Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <div class="w-100 text-center">
                        <h4 class="modal-title fw-bold" id="cancelModal<?php echo $status; ?>Label">
                            Cancellation Reason
                        </h4>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="brgy_includes/update_user_reqDoc.php" method="POST">
                        <div class="mb-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="options-base[]" id="option1" value="Incomplete request details">
                                <label class="form-check-label" for="option1">
                                    Incomplete request details
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="options-base[]" id="option2" value="Duplicate submission">
                                <label class="form-check-label" for="option2">
                                    Duplicate submission
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="options-base[]" id="option3" value="Invalid or expired information">
                                <label class="form-check-label" for="option3">
                                    Invalid or expired information
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="options-base[]" id="option4" value="Insufficient supporting documents">
                                <label class="form-check-label" for="option4">
                                    Insufficient supporting documents
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="options-base[]" id="option5" value="User account issue">
                                <label class="form-check-label" for="option5">
                                    User account issue
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="options-base[]" id="option6" value="Document no longer applicable">
                                <label class="form-check-label" for="option6">
                                    Document no longer applicable
                                </label>
                            </div>
                        </div>



                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Leave a comment here" name="options-base[]" id="floatingTextarea2" style="height: 100px"></textarea>
                            <label for="floatingTextarea2">Reason to decline:</label>
                        </div>

                        <div>
                            <input type="hidden" id="getCancelReqDocId<?php echo $status; ?>" name="getCancelReqDocId">
                            <input type="hidden" name="ifProcessOrApprove" value="Cancel">
                            <button type="submit" name="btnConfirm" class="btn btn-success me-2 fw-bold">Confirm</button>
                            <button type="button" class="btn btn-danger fw-bold" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- approve modal -->
    <div class="modal fade" id="approveModal<?php echo $status; ?>" tabindex="-1" aria-labelledby="approveModal<?php echo $status; ?>Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <div class="w-100 text-center">
                        <h4 class="modal-title fw-bold" id="approveModal<?php echo $status; ?>Label">
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
                            <input type="hidden" id="getApproveReqDocId<?php echo $status; ?>" name="getApproveReqDocId">
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
        $(document).on('click', '.aApprove', function() {
            let p_id = $(this).data('post-id');
            console.log(p_id);
            $('#getApproveReqDocId<?php echo $status; ?>').val(p_id);
        });

        $(document).on('click', '.aCancel', function() {
            let p_id = $(this).data('post-id');
            console.log(p_id);
            $('#getCancelReqDocId<?php echo $status; ?>').val(p_id);
        });

        $('#esModal<?php echo $status; ?>').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget);
            let imageSrc = button.data('image-src');
            let modalImage = $(this).find('#esModalImage<?php echo $status; ?>');
            modalImage.attr('src', imageSrc);
        });

        $('#vidModal<?php echo $status; ?>').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget);
            let imageSrc = button.data('image-src');
            let modalImage = $(this).find('#vidModalImage<?php echo $status; ?>');
            modalImage.attr('src', imageSrc);
        });


    });
</script>