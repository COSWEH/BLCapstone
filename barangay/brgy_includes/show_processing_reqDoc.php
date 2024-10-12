<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id'])) {
    header('location: ../adminDocument.b.php');
    exit;
}

$civilian_brgy = $_SESSION['user_brgy'];

$query = "SELECT req_id, user_id, req_date, req_fname, req_mname, req_lname, req_contactNo, req_gender, req_brgy, req_purok, req_age, req_dateOfBirth, req_placeOfBirth, req_civilStatus, req_eSignature, req_typeOfDoc, authLetter, req_valid_front_id, req_valid_back_id, req_status
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
    <div class="table-responsive">
        <table class="table align-middle table-bordered border border-3 table-hover text-center text-capitalized">
            <thead class="table-active text-uppercase text-white">
                <tr>
                    <th class="col-1"><small>Document Type</small></th>
                    <th class="col-1"><small>Requester</small></th>
                    <th class="col-4"><small>Supporting Documents</small></th>
                    <th class="col-2"><small>Contact No.</small></th>
                    <th class="col-2"><small>Date Requested</small></th>
                    <th class="col-1"><small>Status</small></th>
                    <th class="col-1"><small>Manage</small></th>
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
                    $authLetter = $data['authLetter'];
                    $req_valid_front_id = $data['req_valid_front_id'];
                    $req_valid_back_id = $data['req_valid_back_id'];
                    $status = $data['req_status'];
                    $get_Time_And_Day = new DateTime($reqDate);
                    $formattedDate = $get_Time_And_Day->format('Y-m-d H:i:s');


                    $_SESSION['getRequesterID'] = $userId;

                    $docTypeWithoutBrgy = preg_replace('/\s*\(.*?\)\s*/', '', $docType);
                ?>
                    <tr>
                        <td><small><?php echo htmlspecialchars($docTypeWithoutBrgy); ?></small></td>
                        <td><small><?php echo htmlspecialchars($fname . " " . $mname . " " . $lname); ?></small></td>
                        <td aria-current="page"
                            data-bs-toggle="modal"
                            data-bs-target="#supportingDocsModal<?php echo $reqId; ?>">
                            <div class="row g-2">
                                <!-- Auth Letter -->
                                <div class="col text-center">
                                    <?php if (!empty($authLetter)) { ?>
                                        <a href="#" class="supporting-doc" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($data['authLetter']); ?>">
                                            <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($authLetter); ?>" class="img-fluid rounded" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                        </a>
                                    <?php } ?>
                                </div>

                                <!-- E-Signature -->
                                <div class="col text-center">
                                    <?php if (!empty($data['req_eSignature'])) { ?>
                                        <a href="#" class="supporting-doc" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($data['req_eSignature']); ?>">
                                            <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($data['req_eSignature']); ?>" class="img-fluid rounded" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                        </a>
                                    <?php } else { ?>
                                        <span>No E-Signature</span>
                                    <?php } ?>
                                </div>

                                <!-- Front ID -->
                                <div class="col text-center">
                                    <?php if (!empty($data['req_valid_front_id'])) { ?>
                                        <a href="#" class="supporting-doc" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($data['req_valid_front_id']); ?>">
                                            <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($data['req_valid_front_id']); ?>" class="img-fluid rounded" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                        </a>
                                    <?php } else { ?>
                                        <span>No Front ID</span>
                                    <?php } ?>
                                </div>

                                <!-- Back ID -->
                                <div class="col text-center">
                                    <?php if (!empty($data['req_valid_back_id'])) { ?>
                                        <a href="#" class="supporting-doc" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($data['req_valid_back_id']); ?>">
                                            <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($data['req_valid_back_id']); ?>" class="img-fluid rounded" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                        </a>
                                    <?php } else { ?>
                                        <span>No Back ID</span>
                                    <?php } ?>
                                </div>
                            </div>
                        </td>
                        <td><small><?php echo htmlspecialchars($contactNo); ?></small></td>
                        <td><small><?php echo htmlspecialchars($formattedDate); ?></small></td>
                        <td><small><?php echo htmlspecialchars($status); ?></small></td>
                        <td>
                            <?php
                            if ($status != 'Cancelled') {
                            ?>
                                <button class="btn btn-sm btn-secondary"
                                    type="button"
                                    aria-current="page"
                                    data-bs-toggle="modal"
                                    data-bs-target="#seeMoreModal<?php echo $reqId; ?>"
                                    data-gender="<?php echo htmlspecialchars($gender); ?>"
                                    data-brgy="<?php echo htmlspecialchars($brgy); ?>"
                                    data-purok="<?php echo htmlspecialchars($purok); ?>"
                                    data-age="<?php echo htmlspecialchars($age); ?>"
                                    data-dob="<?php echo htmlspecialchars($dateOfBirth); ?>"
                                    data-placeofbirth="<?php echo htmlspecialchars($req_placeOfBirth); ?>"
                                    data-civilstatus="<?php echo htmlspecialchars($req_civilStatus); ?>"

                                    data-esignature=" <?php echo htmlspecialchars($req_eSignature); ?>"
                                    data-frontid="<?php echo htmlspecialchars($req_valid_front_id); ?>"
                                    data-backid="<?php echo htmlspecialchars($req_valid_back_id); ?>"
                                    title="See more details">

                                    See more
                                </button>
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

                    <!-- see more modal -->
                    <div class="modal fade" id="seeMoreModal<?php echo $reqId; ?>" tabindex="-1" aria-labelledby="seeMoreModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-info-subtle mx-auto mb-3" style="height: 50px; width: 50px;">
                                        <i class="bi bi-info-circle text-info" style="font-size: 25px;"></i>
                                    </div>
                                    <h5 class="modal-title mb-3 text-center">Request Details</h5>
                                    <div class="row">
                                        <!-- Name -->
                                        <div class="col-12">
                                            <p><strong>Name:</strong> <span><?php echo htmlspecialchars($fname . " " . $mname . " " . $lname); ?></span></p>
                                        </div>
                                        <!-- Contact Number -->
                                        <div class="col-12">
                                            <p><strong>Contact Number:</strong> <span><?php echo htmlspecialchars($contactNo); ?></span></p>
                                        </div>
                                        <!-- Gender -->
                                        <div class="col-6">
                                            <p><strong>Sex:</strong> <span class="modal-gender"></span></p>
                                        </div>
                                        <!-- Barangay -->
                                        <div class="col-6">
                                            <p><strong>Barangay:</strong> <span class="modal-brgy"></span></p>
                                        </div>
                                        <!-- Purok -->
                                        <div class="col-6">
                                            <p><strong>Purok:</strong> <span class="modal-purok"></span></p>
                                        </div>
                                        <!-- Age -->
                                        <div class="col-6">
                                            <p><strong>Age:</strong> <span class="modal-age"></span></p>
                                        </div>
                                        <!-- Date of Birth -->
                                        <div class="col-6">
                                            <p><strong>Date of Birth:</strong> <span class="modal-dob"></span></p>
                                        </div>
                                        <!-- Place of Birth -->
                                        <div class="col-6">
                                            <p><strong>Place of Birth:</strong> <span class="modal-placeofbirth"></span></p>
                                        </div>
                                        <!-- Civil Status -->
                                        <div class="col-6">
                                            <p><strong>Civil Status:</strong> <span class="modal-civilstatus"></span></p>
                                        </div>
                                        <!-- Document Type -->
                                        <div class="col-12">
                                            <p><strong>Document Type:</strong> <span><?php echo htmlspecialchars($docTypeWithoutBrgy); ?></span></p>
                                        </div>

                                        <div class="col-12">
                                            <p><strong>Supporting Documents</strong></p>
                                            <div class="row row-cols-2 row-cols-md-4 g-3">
                                                <!-- Authentication Letter -->
                                                <div class="col">
                                                    <?php if (!empty($authLetter)) { ?>
                                                        <a href="#" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($authLetter); ?>">
                                                            <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($authLetter); ?>" class="img-fluid rounded" style="max-width: 100%; max-height: 100px; object-fit: cover;">
                                                        </a>
                                                        <p class="text-center mt-1"><small>Authentication Letter</small></p>
                                                    <?php } ?>
                                                </div>

                                                <!-- E-Signature -->
                                                <div class="col">
                                                    <?php if (!empty($req_eSignature)) { ?>
                                                        <a href="#" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_eSignature); ?>">
                                                            <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_eSignature); ?>" class="img-fluid border rounded shadow-sm" style="max-width: 100%; max-height: 100px; object-fit: cover;" alt="E-Signature">
                                                        </a>
                                                        <p class="text-center mt-1"><small>E-Signature</small></p>
                                                    <?php } else { ?>
                                                        <span class="text-muted">No E-Signature</span>
                                                    <?php } ?>
                                                </div>

                                                <!-- Front ID -->
                                                <div class="col">
                                                    <?php if (!empty($req_valid_front_id)) { ?>
                                                        <a href="#" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_valid_front_id); ?>">
                                                            <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_valid_front_id); ?>" class="img-fluid border rounded shadow-sm" style="max-width: 100%; max-height: 100px; object-fit: cover;" alt="Front ID">
                                                        </a>
                                                        <p class="text-center mt-1"><small>Front ID</small></p>
                                                    <?php } else { ?>
                                                        <span class="text-muted">No Front ID</span>
                                                    <?php } ?>
                                                </div>

                                                <!-- Back ID -->
                                                <div class="col">
                                                    <?php if (!empty($req_valid_back_id)) { ?>
                                                        <a href="#" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_valid_back_id); ?>">
                                                            <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_valid_back_id); ?>" class="img-fluid border rounded shadow-sm" style="max-width: 100%; max-height: 100px; object-fit: cover;" alt="Back ID">
                                                        </a>
                                                        <p class="text-center mt-1"><small>Back ID</small></p>
                                                    <?php } else { ?>
                                                        <span class="text-muted">No Back ID</span>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Request Date -->
                                        <div class="col-12">
                                            <p><strong>Request Date:</strong> <span><?php echo htmlspecialchars($formattedDate); ?></span></p>
                                        </div>
                                        <!-- Status -->
                                        <div class="col-12">
                                            <p><strong>Status:</strong> <span><?php echo htmlspecialchars($status); ?></span></p>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-success aApprove" data-post-id="<?php echo htmlspecialchars($reqId); ?>" data-bs-toggle="modal" data-bs-target="#approveModal<?php echo $status; ?>"><small>Approve Document</small></button>
                                        <button class="btn btn-danger aCancel" data-post-id="<?php echo htmlspecialchars($reqId); ?>" data-bs-toggle="modal" data-bs-target="#cancelModal<?php echo $status; ?>"><small>Cancel Document</small></button>

                                    </div>
                                </div>

                                <button type="button" class="btn-close position-absolute top-0 end-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>

                    <!-- Supporting Docs Modal -->
                    <div class="modal fade" id="supportingDocsModal<?php echo $reqId; ?>" tabindex="-1" aria-labelledby="supportingDocsModal<?php echo $reqId; ?>Label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-info-subtle mx-auto mb-3" style="height: 50px; width: 50px;">
                                        <i class="bi bi-info-circle text-info" style="font-size: 25px;"></i>
                                    </div>
                                    <h5 class="modal-title mb-3 text-center">View Supporting Documents</h5>

                                    <div class="step<?php echo $reqId; ?>">
                                        <p>Authentication Letter</p>
                                        <?php if (!empty($authLetter)) { ?>
                                            <a href="#" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($authLetter); ?>">
                                                <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($authLetter); ?>" class="img-fluid rounded" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                                            </a>
                                        <?php } ?>
                                        <div class="row mt-2">
                                            <div class="col-12 mb-2">
                                                <button type="button" class="btn btn-primary w-100" id="nextBtn1<?php echo $reqId; ?>">
                                                    Next <i class="bi bi-arrow-right-square"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="step<?php echo $reqId; ?>" style="display: none;">
                                        <p><small>E-Signature</small></p>
                                        <?php if (!empty($req_eSignature)) { ?>
                                            <a href="#" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_eSignature); ?>">
                                                <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_eSignature); ?>" class="img-fluid border rounded shadow-sm" style="max-width: 100%; max-height: 100%; object-fit: cover;" alt="E-Signature">
                                            </a>
                                        <?php } else { ?>
                                            <span class="text-muted">No E-Signature</span>
                                        <?php } ?>
                                        <div class="row mt-2">
                                            <div class="col-12 col-md-6 mb-2">
                                                <button type="button" class="btn btn-secondary w-100" id="prevBtn1<?php echo $reqId; ?>">
                                                    <i class="bi bi-arrow-left-square"></i> Previous
                                                </button>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <button type="button" class="btn btn-primary w-100" id="nextBtn2<?php echo $reqId; ?>">
                                                    Next <i class="bi bi-arrow-right-square"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="step<?php echo $reqId; ?>" style="display: none;">
                                        <p class="mt-1"><small>Front ID</small></p>
                                        <?php if (!empty($req_valid_front_id)) { ?>
                                            <a href="#" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_valid_front_id); ?>">
                                                <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_valid_front_id); ?>" class="img-fluid border rounded shadow-sm" style="max-width: 100%; max-height: 100%; object-fit: cover;" alt="Front ID">
                                            </a>
                                        <?php } else { ?>
                                            <span class="text-muted">No Front ID</span>
                                        <?php } ?>
                                        <div class="row mt-2">
                                            <div class="col-12 col-md-6 mb-2">
                                                <button type="button" class="btn btn-secondary w-100" id="prevBtn2<?php echo $reqId; ?>">
                                                    <i class="bi bi-arrow-left-square"></i> Previous
                                                </button>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <button type="button" class="btn btn-primary w-100" id="nextBtn3<?php echo $reqId; ?>">
                                                    Next <i class="bi bi-arrow-right-square"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="step<?php echo $reqId; ?>" style="display: none;">
                                        <p class="mt-1"><small>Back ID</small></p>
                                        <?php if (!empty($req_valid_back_id)) { ?>
                                            <a href="#" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_valid_back_id); ?>">
                                                <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_valid_back_id); ?>" class="img-fluid border rounded shadow-sm" style="max-width: 100%; max-height: 100%; object-fit: cover;" alt="Back ID">
                                            </a>
                                        <?php } else { ?>
                                            <span class="text-muted">No Back ID</span>
                                        <?php } ?>
                                        <div class="row mt-2">
                                            <div class="col-12 mb-2">
                                                <button type="button" class="btn btn-secondary w-100" id="prevBtn3<?php echo $reqId; ?>">
                                                    <i class="bi bi-arrow-left-square"></i> Previous
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <button type="button" class="btn-close position-absolute top-0 end-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>

                    <script>
                        $(document).ready(function() {
                            <?php

                            if (!empty($authLetter)) {
                                echo 'let currentStep = 0;';
                            } else {
                                echo 'let currentStep = 1;';
                            }

                            ?>

                            const steps = document.querySelectorAll('.step<?php echo $reqId; ?>');

                            function showStep(step) {
                                steps.forEach((s, index) => {
                                    s.style.display = (index === step) ? 'block' : 'none';
                                });
                            }

                            function nextStep() {
                                if (currentStep < steps.length - 1) {
                                    currentStep++;
                                    showStep(currentStep);
                                }
                            }

                            function prevStep() {
                                if (currentStep > 0) {
                                    currentStep--;
                                    showStep(currentStep);
                                }
                            }

                            document.getElementById('nextBtn1<?php echo $reqId; ?>').addEventListener('click', nextStep);
                            document.getElementById('nextBtn2<?php echo $reqId; ?>').addEventListener('click', nextStep);
                            document.getElementById('nextBtn3<?php echo $reqId; ?>').addEventListener('click', nextStep);

                            document.getElementById('prevBtn1<?php echo $reqId; ?>').addEventListener('click', prevStep);
                            document.getElementById('prevBtn2<?php echo $reqId; ?>').addEventListener('click', prevStep);
                            document.getElementById('prevBtn3<?php echo $reqId; ?>').addEventListener('click', prevStep);

                            // Show the first step initially
                            showStep(currentStep);
                        });
                    </script>

                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- cancel modal -->
    <div class="modal fade" id="cancelModal<?php echo $status; ?>" tabindex="-1" aria-labelledby="cancelModal<?php echo $status; ?>Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center text-center border border-0">
                    <div class="w-100 text-center">
                        <h4 class="modal-title" id="cancelModal<?php echo $status; ?>Label">
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

                        <div class="d-grid gap-3">
                            <input type="hidden" id="getCancelReqDocId<?php echo $status; ?>" name="getCancelReqDocId">
                            <input type="hidden" name="ifProcessOrApprove" value="Cancel">
                            <button type="submit" name="btnConfirm" class="btn btn-success">Confirm</button>
                            <button type="button" class="btn border border-2" data-bs-dismiss="modal">
                                Cancel
                            </button>
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
                <div class="modal-body text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-success-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-check-circle text-success" style="font-size: 25px;"></i>
                    </div>

                    <h6 class="my-3 fw-semibold">Confirm Approval</h6>
                    <p class="text-muted">Please confirm if you wish to approve this document.</p>
                    <form action="brgy_includes/update_user_reqDoc.php" method="POST">
                        <div class="d-grid gap-3 mx-4">
                            <input type="hidden" id="getApproveReqDocId<?php echo $status; ?>" name="getApproveReqDocId">
                            <input type="hidden" name="ifProcessOrApprove" value="Approve">
                            <button type="submit" name="btnConfirm" class="btn btn-success">Confirm</button>
                            <button type="button" class="btn border border-2" data-bs-dismiss="modal">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

            const seeMoreLinks = document.querySelectorAll('[data-bs-target^="#seeMoreModal"]');

            seeMoreLinks.forEach(link => {
                link.addEventListener('click', function() {
                    // Get the data attributes
                    const gender = this.getAttribute('data-gender');
                    const brgy = this.getAttribute('data-brgy');
                    const purok = this.getAttribute('data-purok');
                    const age = this.getAttribute('data-age');
                    const dob = this.getAttribute('data-dob');
                    const placeOfBirth = this.getAttribute('data-placeofbirth');
                    const civilStatus = this.getAttribute('data-civilstatus');

                    // Populate the modal with the data
                    const modalId = this.getAttribute('data-bs-target');
                    document.querySelector(modalId + ' .modal-gender').textContent = gender;
                    document.querySelector(modalId + ' .modal-brgy').textContent = brgy;
                    document.querySelector(modalId + ' .modal-purok').textContent = purok;
                    document.querySelector(modalId + ' .modal-age').textContent = age;
                    document.querySelector(modalId + ' .modal-dob').textContent = dob;
                    document.querySelector(modalId + ' .modal-placeofbirth').textContent = placeOfBirth;
                    document.querySelector(modalId + ' .modal-civilstatus').textContent = civilStatus;
                });
            });

        });
    </script>

<?php
}
?>