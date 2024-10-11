<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location: ../adminDocument.b.php');
    exit;
}

if (isset($_POST['query'])) {
    $query = $_POST['query'];

    // SQL query to search for users by first name or last name
    $sql = "SELECT * FROM tbl_requests WHERE req_fname LIKE '%$query%' OR req_mname LIKE '%$query%' OR req_lname LIKE '%$query%'";
    $result = mysqli_query($con, $sql);

?>

    <div class="table-responsive">
        <table class="table align-middle table-bordered border border-3 table-hover text-center text-capitalized">
            <thead class="table-active text-uppercase text-white">
                <tr>
                    <th class="col-2"><small>Document Type</small></th>
                    <th class="col-2"><small>Requester</small></th>
                    <th class="col-1"><small>Authentication Letter</small></th>
                    <th class="col-3"><small>Identification</small></th>
                    <th class="col-1"><small>Contact No.</small></th>
                    <th class="col-1"><small>Date Requested</small></th>
                    <th><small>Status</small></th>
                    <th class="col-1"><small>Manage</small></th>
                </tr>

            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($data = mysqli_fetch_assoc($result)) {
                        $reqId = $data['req_id'];
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
                        $formattedDate = (new DateTime($data['req_date']))->format('Y-m-d H:i:s');

                        $docTypeWithoutBrgy = preg_replace('/\s*\(.*?\)\s*/', '', $docType);
                ?>
                        <tr>
                            <td><small><?php echo htmlspecialchars($docTypeWithoutBrgy); ?></small></td>
                            <td><small><?php echo htmlspecialchars("$fname $mname $lname"); ?></small></td>
                            <td>
                                <?php if (!empty($authLetter)) { ?>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#esModal<?php echo $status; ?>" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($authLetter); ?>">
                                        <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($authLetter); ?>" class="img-fluid rounded" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                    </a>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if (!empty($data['req_eSignature'])) { ?>
                                    <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($data['req_eSignature']); ?>" class="img-fluid rounded mb-2" style="max-width: 100px; max-height: 100px; object-fit: cover;">

                                <?php } else { ?>
                                    <span>No E-Signature</span>
                                <?php } ?>

                                <!-- Front ID -->
                                <?php if (!empty($data['req_valid_front_id'])) { ?>

                                    <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($data['req_valid_front_id']); ?>" class="img-fluid rounded mb-2" style="max-width: 100px; max-height: 100px; object-fit: cover;">

                                <?php } else { ?>
                                    <span>No Front ID</span>
                                <?php } ?>

                                <!-- Back ID -->
                                <?php if (!empty($data['req_valid_back_id'])) { ?>

                                    <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($data['req_valid_back_id']); ?>" class="img-fluid rounded mb-2" style="max-width: 100px; max-height: 100px; object-fit: cover;">

                                <?php } else { ?>
                                    <span>No Back ID</span>
                                <?php } ?>
                            </td>
                            <td><small><?php echo htmlspecialchars($contactNo); ?></small></td>
                            <td><small><?php echo htmlspecialchars($formattedDate); ?></small></td>
                            <td><small><?php echo htmlspecialchars($status); ?></small></td>
                            <td>
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
                            </td>
                        </tr>

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
                                                <p><strong>Identification</strong></p>
                                                <div class="d-flex flex-wrap align-items-start">
                                                    <!-- E-Signature -->
                                                    <div class="me-3 mb-2">
                                                        <?php if (!empty($req_eSignature)) { ?>
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#esModal<?php echo $status; ?>" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_eSignature); ?>">
                                                                <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_eSignature); ?>" class="img-fluid border rounded shadow-sm" style="max-width: 100px; max-height: 100px; object-fit: cover;" alt="E-Signature">
                                                            </a>
                                                            <p class="text-center mt-1"><small>E-Signature</small></p>
                                                        <?php } else { ?>
                                                            <span class="text-muted">No E-Signature</span>
                                                        <?php } ?>
                                                    </div>

                                                    <!-- Front ID -->
                                                    <div class="me-3 mb-2">
                                                        <?php if (!empty($req_valid_front_id)) { ?>
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#vidModal<?php echo $status; ?>" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_valid_front_id); ?>">
                                                                <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_valid_front_id); ?>" class="img-fluid border rounded shadow-sm" style="max-width: 100px; max-height: 100px; object-fit: cover;" alt="Front ID">
                                                            </a>
                                                            <p class="text-center mt-1"><small>Front ID</small></p>
                                                        <?php } else { ?>
                                                            <span class="text-muted">No Front ID</span>
                                                        <?php } ?>
                                                    </div>

                                                    <!-- Back ID -->
                                                    <div class="mb-2">
                                                        <?php if (!empty($req_valid_back_id)) { ?>
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#vidModal<?php echo $status; ?>" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_valid_back_id); ?>">
                                                                <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_valid_back_id); ?>" class="img-fluid border rounded shadow-sm" style="max-width: 100px; max-height: 100px; object-fit: cover;" alt="Back ID">
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
                                    </div>

                                    <button type="button" class="btn-close position-absolute top-0 end-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
            <?php
                    }
                } else {
                    echo '<tr><td colspan="15">No matching records found.</td></tr>';
                }
            }
            ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
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