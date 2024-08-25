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
                            $status = $data['req_status'];
                            $req_valid_id = $data['req_valid_id'];
                            $formattedDate = (new DateTime($data['req_date']))->format('Y-m-d H:i:s');
                    ?>
                            <tr>
                                <td><small><?php echo htmlspecialchars($docType); ?></small></td>
                                <td><small><?php echo htmlspecialchars("$fname $mname $lname"); ?></small></td>
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
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_eSignature); ?>">
                                            <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_eSignature); ?>" class="img-fluid rounded" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                        </a>
                                    <?php } else { ?>
                                        <span>No E-Signature</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if (!empty($req_valid_id)) { ?>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_valid_id); ?>">
                                            <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_valid_id); ?>" class="img-fluid rounded" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                        </a>
                                    <?php } else { ?>
                                        <span>No Valid ID</span>
                                    <?php } ?>
                                </td>
                                <td><small><?php echo htmlspecialchars($status); ?></small></td>
                                <td>
                                    <?php if ($status != 'Cancelled') { ?>
                                        <div class="dropdown-bottom">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Options
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item aCancel" data-post-id="<?php echo htmlspecialchars($reqId); ?>" data-bs-toggle="modal" data-bs-target="#cancelModal"><small>Cancel</small></a></li>
                                                <li><a class="dropdown-item aProcess" data-post-id="<?php echo htmlspecialchars($reqId); ?>" data-bs-toggle="modal" data-bs-target="#processModal"><small>Process</small></a></li>
                                                <li><a class="dropdown-item aApprove" data-post-id="<?php echo htmlspecialchars($reqId); ?>" data-bs-toggle="modal" data-bs-target="#approveModal"><small>Approve</small></a></li>
                                            </ul>
                                        </div>
                                    <?php } else { ?>
                                        <button class="btn btn-sm btn-secondary dropdown-toggle disabled" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Options
                                        </button>
                                    <?php } ?>
                                </td>
                            </tr>
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
    </div>