<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id'])) {
    header('location: ../document.c.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$civilian_brgy = $_SESSION['user_brgy'];

$query = "SELECT req_id, user_id, req_date, req_fname, req_mname, req_lname, req_contactNo, req_gender, req_brgy, req_purok, req_age, req_dateOfBirth, req_placeOfBirth, req_civilStatus, req_eSignature, req_typeOfDoc, authLetter, req_valid_front_id, req_valid_back_id, req_status, req_reasons
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
    $req_eSignature = $data['req_eSignature'];
    $docType = $data['req_typeOfDoc'];
    $authLetter = $data['authLetter'];
    $req_valid_front_id = $data['req_valid_front_id'];
    $req_valid_back_id = $data['req_valid_back_id'];
    $status = $data['req_status'];
    $reasons = $data['req_reasons'];

    $docTypeWithoutBrgy = preg_replace('/\s*\(.*?\)\s*/', '', $docType);

    $get_Time_And_Day = new DateTime($reqDate);
    $formattedDate = $get_Time_And_Day->format('Y-m-d H:i:s');

    $getDocTemplateQuery = "SELECT doc_template FROM tbl_typedoc WHERE docType = '$docType'";
    $getDtResult = mysqli_query($con, $getDocTemplateQuery);

    if (mysqli_num_rows($getDtResult) > 0) {
        $row = mysqli_fetch_assoc($getDtResult);

        $getDocumentTemplate = $row['doc_template'];
        $pdfFileUrl = 'civilian_includes/doc_template/' . $getDocumentTemplate;
    }
?>

    <!-- List of Document Requests -->
    <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-2">
        <div class="card shadow border border-2">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center text-center ">
                    <h5 class="card-title mb-0 mx-auto"><?php echo $docTypeWithoutBrgy; ?></h5>
                    <a type="button" class="btn btn-sm shadow position-relative btnPreview<?php echo $reqId; ?>" data-doc-type="<?php echo $docTypeWithoutBrgy; ?>" data-bs-toggle="modal" data-bs-target="#docTypePreviewModal<?php echo $reqId; ?>" data-bs-toggle="tooltip" title="Document Preview">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </a>
                    <a type="button" id="editRequestModal<?php echo $reqId; ?>" data-post-id="<?php echo $reqId; ?>" class="btn btn-sm shadow ms-2" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $reqId; ?>" data-bs-toggle="tooltip" title="Edit Request">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                </div>
                <hr>
                <div class="d-flex flex-column mb-2">
                    <div class="d-flex justify-content-between mb-2">
                        <h6>
                            <small>
                                <i class="bi bi-person-fill me-2">
                                    <span class="ms-2">Name:</span>
                                </i>
                            </small>
                            <?php echo $fname . " " . $mname . " " . $lname; ?>
                        </h6>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <h6>
                            <small>
                                <i class="bi bi-phone-fill me-2">
                                    <span class="ms-2">Contact No:</span>
                                </i>
                            </small>
                            <?php echo $contactNo; ?>
                        </h6>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <h6>
                            <i class="bi bi-calendar3 me-2">
                                <span class="ms-2">Age:</span>
                            </i>
                            <small>
                                <?php echo $age; ?> years old
                            </small>
                        </h6>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <h6>
                            <small>
                                <i class="bi bi-house-door-fill me-2">
                                    <span class="ms-2">Barangay:</span>
                                </i>
                            </small>
                            <?php echo $brgy; ?>
                        </h6>
                    </div>

                    <div class="d-flex justify-content-between">
                        <h6>
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

    <!-- doc type preview modal -->
    <div class="modal fade" id="docTypePreviewModal<?php echo $reqId; ?>" tabindex="-1" aria-labelledby="docTypePreviewModal<?php echo $reqId; ?>Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-primary-subtle mx-auto mb-3" style="height: 50px; width: 50px;">
                        <i class="bi bi-eye-fill text-primary" style="font-size: 25px;"></i>
                    </div>

                    <h5 class="fw-semibold">Document Preview</h5>
                    <p class="text-muted mb-4">This is just a template preview. The actual document will be available at the designated pickup location.</p>

                    <!-- Container for PDF.js -->
                    <div id="pdf-container<?php echo $reqId; ?>" class="row"></div>
                </div>

                <!-- Modal Close Button -->
                <button type="button" class="btn-close position-absolute top-0 end-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- edit request modal -->
    <div class="modal fade" id="editModal<?php echo $reqId; ?>" tabindex="-1" aria-labelledby="editModal<?php echo $reqId; ?>Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-body ">
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-success-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-pencil-square text-success" style="font-size: 25px;"></i>
                    </div>
                    <h5 class="fw-semibold text-center mb-3">Edit Document Request</h5>
                    <div class="container">
                        <form action="civilian_includes/edit_request_doc.php" method="POST" enctype="multipart/form-data">
                            <!-- type of doc -->
                            <div class="form-floating mb-2">
                                <select id="documentType<?php echo $reqId; ?>" name="docType" class="form-select">
                                    <!-- show all document type from database -->
                                </select>
                                <label for="documentType<?php echo $reqId; ?>">Document Type</label>
                            </div>

                            <?php
                            if (!empty($authLetter)) {
                            ?>
                                <div class="form-floating mb-2">
                                    <input type="text" name="editFirstName" class="form-control" id="editFirstName" placeholder="First Name" required pattern="^[a-zA-Z\s\-]+$" value="<?php echo $fname; ?>">
                                    <label for="editFirstName">First Name</label>
                                </div>

                                <div class="form-floating mb-2">
                                    <input type="text" name="editMiddleName" class="form-control" id="editMiddleName" placeholder="Middle Name" required pattern="^[a-zA-Z\s\-]+$" value="<?php echo $mname; ?>">
                                    <label for="editMiddleName">Middle Name</label>
                                </div>

                                <div class="form-floating mb-2">
                                    <input type="text" name="editLastName" class="form-control" id="editLastName" placeholder="Last Name" required pattern="^[a-zA-Z\s\-]+$" value="<?php echo $lname; ?>">
                                    <label for="editLastName">Last Name</label>
                                </div>

                                <!-- contact no. -->
                                <div class="form-floating mb-2">
                                    <input type="text" name="contactNum" class="form-control" id="user_contactNum" placeholder="Contact Number" required pattern="^(09\d{9}|639\d{9})$" title="(e.g., 09123456789)" value="<?php echo $contactNo; ?>">
                                    <label for="user_contactNum" class="form-label">Contact Number</label>
                                </div>

                                <!-- Barangay -->
                                <div class="form-floating mb-2">
                                    <select name="barangay" id="user_brgy<?php echo $reqId; ?>" class="form-select">
                                        <option value="" disabled selected>Select Barangay</option>
                                        <option value="Alua">Alua</option>
                                        <option value="Calaba">Calaba</option>
                                        <option value="Malapit">Malapit</option>
                                        <option value="Mangga">Mangga</option>
                                        <option value="Poblacion">Poblacion</option>
                                        <option value="Pulo">Pulo</option>
                                        <option value="San Roque">San Roque</option>
                                        <option value="Sto. Cristo">Sto. Cristo</option>
                                        <option value="Tabon">Tabon</option>
                                    </select>
                                    <label for="user_brgy" class="form-label"><small>Which Barangay are you from?</small></label>
                                </div>

                                <!-- purok -->
                                <?php
                                $selectedPurok = isset($purok) ? $purok : '';
                                ?>
                                <div class="form-floating mb-2">
                                    <select name="user_purok" class="form-select" id="user_purok" required>
                                        <option value="" disabled <?php echo $selectedPurok === '' ? 'selected' : ''; ?>>Select Purok</option>
                                        <option value="Purok 1" <?php echo $selectedPurok === 'Purok 1' ? 'selected' : ''; ?>>Purok 1</option>
                                        <option value="Purok 2" <?php echo $selectedPurok === 'Purok 2' ? 'selected' : ''; ?>>Purok 2</option>
                                        <option value="Purok 3" <?php echo $selectedPurok === 'Purok 3' ? 'selected' : ''; ?>>Purok 3</option>
                                        <option value="Purok 4" <?php echo $selectedPurok === 'Purok 4' ? 'selected' : ''; ?>>Purok 4</option>
                                        <option value="Purok 5" <?php echo $selectedPurok === 'Purok 5' ? 'selected' : ''; ?>>Purok 5</option>
                                        <option value="Purok 6" <?php echo $selectedPurok === 'Purok 6' ? 'selected' : ''; ?>>Purok 6</option>
                                        <option value="Purok 7" <?php echo $selectedPurok === 'Purok 7' ? 'selected' : ''; ?>>Purok 7</option>
                                    </select>
                                    <label for="user_purok" class="form-label">Purok</label>
                                </div>

                                <div class="form-floating mb-2">
                                    <select name="gender" id="user_gender" class="form-select" required>
                                        <option value="" disabled>Select Male or Female</option>
                                        <?php
                                        if (isset($gender)) {
                                            $getGender = $gender;
                                            echo '<option value="Male"' . ($getGender == "Male" ? ' selected' : '') . '>Male</option>';
                                            echo '<option value="Female"' . ($getGender == "Female" ? ' selected' : '') . '>Female</option>';
                                        } else {
                                            echo '<option value="Male">Male</option>';
                                            echo '<option value="Female">Female</option>';
                                        }
                                        ?>
                                    </select>
                                    <label for="user_gender" class="form-label">Sex</label>
                                </div>

                                <div class="form-floating mb-2">
                                    <input id="dateOfBirth<?php echo $reqId; ?>" class="form-control" type="date" name="dateOfBirth" placeholder="Date of Birth" required
                                        value="<?php echo isset($dateOfBirth) ? htmlspecialchars($dateOfBirth) : ''; ?>">
                                    <label for="dateOfBirth">Date of Birth</label>
                                </div>

                                <div class="form-floating mb-2">
                                    <input id="user_age<?php echo $reqId; ?>" class="form-control" type="number" name="age" placeholder="Age" value="<?php echo $age; ?>" required>
                                    <label for="user_age<?php echo $reqId; ?>">Age</label>
                                </div>

                                <div class="form-floating mb-2">
                                    <input id="placeOfBirth" class="form-control" type="text" name="placeOfBirth" placeholder="Place of Birth" required
                                        value="<?php echo isset($req_placeOfBirth) ? htmlspecialchars($req_placeOfBirth) : ''; ?>">
                                    <label for="placeOfBirth">Place of Birth</label>
                                </div>

                                <div class="form-floating mb-2">
                                    <select id="civilStatus" name="civilStatus" class="form-select" required>
                                        <option value="" disabled <?php echo !isset($req_civilStatus) ? 'selected' : ''; ?>>Choose Status</option>
                                        <option value="Single" <?php echo isset($req_civilStatus) && $req_civilStatus == 'Single' ? 'selected' : ''; ?>>Single</option>
                                        <option value="Married" <?php echo isset($req_civilStatus) && $req_civilStatus == 'Married' ? 'selected' : ''; ?>>Married</option>
                                        <option value="Widowed" <?php echo isset($req_civilStatus) && $req_civilStatus == 'Widowed' ? 'selected' : ''; ?>>Widowed</option>
                                        <option value="Divorced" <?php echo isset($req_civilStatus) && $req_civilStatus == 'Divorced' ? 'selected' : ''; ?>>Divorced</option>
                                    </select>
                                    <label for="civilStatus">Civil Status</label>
                                </div>

                                <!-- Current Identification Display -->
                                <?php if (!empty($req_eSignature) && !empty($req_valid_front_id) && !empty($req_valid_back_id) && !empty($authLetter)): ?>
                                    <div class="mb-2">
                                        <label class="form-label">Current Identification:</label>
                                        <div class="row g-2 text-center">
                                            <div class="col-md-3">
                                                <img src="../civilian/civilian_dbImg/<?php echo $authLetter; ?>" alt="E Signature" class="img-fluid rounded border">
                                                <small class="d-block text-muted mt-1">Authentication Letter</small>
                                                <input type="text" name="prevAuthLetter" value="<?php echo $authLetter; ?>" accept=".jpg, jpeg, .png" class="form-control" id="prevAuthLetter" hidden>
                                            </div>

                                            <div class="col-md-3">
                                                <img src="../civilian/civilian_dbImg/<?php echo $req_eSignature; ?>" alt="E Signature" class="img-fluid rounded border">
                                                <small class="d-block text-muted mt-1">E Signature</small>
                                                <input type="text" name="prevESignature" value="<?php echo $req_eSignature; ?>" accept=".jpg, jpeg, .png" class="form-control" id="prevESignature" hidden>
                                            </div>

                                            <div class="col-md-3">
                                                <img src="../civilian/civilian_dbImg/<?php echo $req_valid_front_id; ?>" alt="Valid Front ID" class="img-fluid rounded border">
                                                <small class="d-block text-muted mt-1">Front ID</small>
                                                <input type="text" name="prevFrontValidID" value="<?php echo $req_valid_front_id; ?>" accept=".jpg, jpeg, .png" class="form-control" id="prevFrontValidID" hidden>
                                            </div>

                                            <div class="col-md-3">
                                                <img src="../civilian/civilian_dbImg/<?php echo $req_valid_back_id; ?>" alt="Valid Back ID" class="img-fluid rounded border">
                                                <small class="d-block text-muted mt-1">Back ID</small>
                                                <input type="text" name="prevBackValidID" value="<?php echo $req_valid_back_id; ?>" accept=".jpg, jpeg, .png" class="form-control" id="prevBackValidID" hidden>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- File Uploads -->
                                <label class="form-label">
                                    Upload Identification Documents:
                                    <small class="text-warning d-block"><i class="bi bi-exclamation-circle me-2"></i>Please upload only the incorrect documents that need replacement.</small>
                                </label>

                                <div class="form-floating mb-2">
                                    <input type="file" name="editAuthLetter" accept=".jpg, jpeg, .png" class="form-control" id="editAuthLetter">
                                    <label for="editAuthLetter">Authentication Letter</label>
                                </div>

                                <div class="form-floating mb-2">
                                    <input type="file" name="editESignature" accept=".jpg, jpeg, .png" class="form-control" id="editESignature">
                                    <label for="editESignature">E Signature</label>
                                </div>

                                <div class="form-floating mb-2">
                                    <input type="file" name="editFrontValidID" accept=".jpg, jpeg, .png" class="form-control" id="editFrontValidID">
                                    <label for="editFrontValidID">Front ID</label>
                                </div>

                                <div class="form-floating mb-2">
                                    <input type="file" name="editBackValidID" accept=".jpg, jpeg, .png" class="form-control" id="editBackValidID">
                                    <label for="editBackValidID">Back ID</label>
                                </div>

                                <input type="hidden" id="getSubmitReqDocId<?php echo $reqId; ?>" name="getSubmitReqDocId">
                                <input type="hidden" id="haveAuthLetter" name="haveAuthLetter" value="Yes">
                                <!-- error message -->
                                <div id="showEditReqDocError<?php echo $reqId; ?>"></div>

                                <div class="d-grid gap-2 mt-2">
                                    <button id="sumbitDocRequest<?php echo $reqId; ?>" name="sumbitDocRequest" class="btn btn-success" data-post-id="<?php echo htmlspecialchars($reqId); ?>"><small>Submit Request</small></button>
                                    <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><small>Cancel</small></button>
                                </div>
                            <?php
                            } else {
                            ?>
                                <!-- Current Identification Display -->
                                <?php if (!empty($req_eSignature) && !empty($req_valid_front_id) && !empty($req_valid_back_id)): ?>
                                    <div class="mb-2">
                                        <label class="form-label">Current Identification:</label>
                                        <div class="row g-2 text-center">

                                            <div class="col-md-4">
                                                <img src="../civilian/civilian_dbImg/<?php echo $req_eSignature; ?>" alt="E Signature" class="img-fluid rounded border">
                                                <small class="d-block text-muted mt-1">E Signature</small>
                                                <input type="text" name="prevESignature" value="<?php echo $req_eSignature; ?>" accept=".jpg, jpeg, .png" class="form-control" id="prevESignature" hidden>
                                            </div>

                                            <div class="col-md-4">
                                                <img src="../civilian/civilian_dbImg/<?php echo $req_valid_front_id; ?>" alt="Valid Front ID" class="img-fluid rounded border">
                                                <small class="d-block text-muted mt-1">Front ID</small>
                                                <input type="text" name="prevFrontValidID" value="<?php echo $req_valid_front_id; ?>" accept=".jpg, jpeg, .png" class="form-control" id="prevFrontValidID" hidden>
                                            </div>

                                            <div class="col-md-4">
                                                <img src="../civilian/civilian_dbImg/<?php echo $req_valid_back_id; ?>" alt="Valid Back ID" class="img-fluid rounded border">
                                                <small class="d-block text-muted mt-1">Back ID</small>
                                                <input type="text" name="prevBackValidID" value="<?php echo $req_valid_back_id; ?>" accept=".jpg, jpeg, .png" class="form-control" id="prevBackValidID" hidden>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- File Uploads -->
                                <label class="form-label">
                                    Upload Identification Documents:
                                    <small class="text-warning d-block"><i class="bi bi-exclamation-circle me-2"></i>Please upload only the incorrect documents that need replacement.</small>
                                </label>

                                <div class="form-floating mb-2">
                                    <input type="file" name="editESignature" accept=".jpg, jpeg, .png" class="form-control" id="editESignature">
                                    <label for="editESignature">E Signature</label>
                                </div>

                                <div class="form-floating mb-2">
                                    <input type="file" name="editFrontValidID" accept=".jpg, jpeg, .png" class="form-control" id="editFrontValidID">
                                    <label for="editFrontValidID">Front ID</label>
                                </div>

                                <div class="form-floating mb-2">
                                    <input type="file" name="editBackValidID" accept=".jpg, jpeg, .png" class="form-control" id="editBackValidID">
                                    <label for="editBackValidID">Back ID</label>
                                </div>

                                <input type="hidden" id="getSubmitReqDocId<?php echo $reqId; ?>" name="getSubmitReqDocId">
                                <input type="hidden" id="haveAuthLetter" name="haveAuthLetter" value="No">
                                <!-- error message -->
                                <div id="showEditReqDocError<?php echo $reqId; ?>"></div>


                                <div class="d-grid gap-2 mt-2">
                                    <button id="sumbitDocRequest<?php echo $reqId; ?>" name="sumbitDocRequest" class="btn btn-success" data-post-id="<?php echo htmlspecialchars($reqId); ?>"><small>Submit Request</small></button>
                                    <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><small>Cancel</small></button>
                                </div>
                            <?php
                            }
                            ?>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- submit modal -->
    <!-- <div class="modal fade" id="submitModal<?php echo $reqId; ?>" tabindex="-1" aria-labelledby="submitModal<?php echo $reqId; ?>Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-success-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-check-circle text-success" style="font-size: 25px;"></i>
                    </div>

                    <h6 class="my-3 fw-semibold">Confirm Submit</h6>
                    <p class="text-muted">Please confirm if you wish to submit this document.</p>
                    <form action="" method="POST">
                        <div class="d-grid gap-3 mx-4">
                            <input type="text" id="getSubmitReqDocId<?php echo $reqId; ?>" name="getSubmitReqDocId">
                            <button type="submit" name="btnConfirm" class="btn btn-success">Confirm</button>
                            <button type="button" class="btn border border-2" data-bs-dismiss="modal">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js"></script>

    <script>
        $(document).ready(function() {
            // get document type 
            function getDocumentType() {
                $.ajax({
                    url: 'civilian_includes/getDocTypes.php',
                    type: 'POST',
                    dataType: 'html',
                    success: function(data) {
                        console.log(data);
                        $("#documentType<?php echo $reqId; ?>").html(data);
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + error);
                    }
                });
            }

            getDocumentType();

            $('#editRequestModal<?php echo $reqId; ?>').on('click', function(e) {
                let p_id = $(this).data('post-id');
                console.log(p_id);

                $('#getSubmitReqDocId<?php echo $reqId; ?>').val(p_id);
            });

            $('#editModal<?php echo $reqId; ?> form').on('submit', function(event) {
                console.log('form trigger');

                // Clear any previous error messages
                $('#showEditReqDocError<?php echo $reqId; ?>').empty();

                <?php
                if (!empty($authLetter)) {
                ?>
                    var docType = $('#documentType<?php echo $reqId; ?>').val();
                    var brgy = $('#user_brgy<?php echo $reqId; ?>').val();

                    console.log('Document Type:', docType); // Debugging line
                    console.log('Barangay:', brgy); // Debugging line

                    if (!docType || !brgy) {
                        event.preventDefault(); // Prevent form submission

                        // Create the alert HTML
                        var alertHtml = `
            <div class="alert alert-warning" role="alert">
                Both the Document Type and Barangay must be filled out.
            </div>`;

                        $('#showEditReqDocError<?php echo $reqId; ?>').html(alertHtml);

                        setTimeout(function() {
                            $('#showEditReqDocError<?php echo $reqId; ?>').empty();
                        }, 3000);
                    }
                <?php
                } else {
                ?>
                    var docType = $('#documentType<?php echo $reqId; ?>').val();

                    console.log('Document Type:', docType); // Debugging line

                    if (!docType) {
                        event.preventDefault(); // Prevent form submission

                        // Create the alert HTML
                        var alertHtml = `
            <div class="alert alert-warning" role="alert">
                The Document Type must be filled out.
            </div>`;

                        $('#showEditReqDocError<?php echo $reqId; ?>').html(alertHtml);

                        setTimeout(function() {
                            $('#showEditReqDocError<?php echo $reqId; ?>').empty();
                        }, 3000);
                    }
                <?php
                }
                ?>
            });

            document.querySelectorAll('.btnPreview<?php echo $reqId; ?>').forEach(button => {
                button.addEventListener('click', function() {
                    const reqId = "<?php echo $reqId; ?>";
                    const pdfUrl = "<?php echo $pdfFileUrl; ?>";
                    const container = document.getElementById(`pdf-container${reqId}`);

                    console.log(pdfUrl);

                    // Clear the container in case it has content from previous renders
                    container.innerHTML = '';

                    // Loading the PDF
                    pdfjsLib.getDocument(pdfUrl).promise.then(pdf => {
                        // Loop through each page and render it
                        for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                            pdf.getPage(pageNum).then(page => {
                                const scale = 1.5; // Adjust scale as needed
                                const viewport = page.getViewport({
                                    scale: scale
                                });

                                // Create a canvas element for each page
                                const canvas = document.createElement('canvas');
                                canvas.width = viewport.width;
                                canvas.height = viewport.height;
                                container.appendChild(canvas);

                                const context = canvas.getContext('2d');

                                // Render the page into the canvas context
                                const renderContext = {
                                    canvasContext: context,
                                    viewport: viewport
                                };
                                page.render(renderContext);
                            }).catch(error => {
                                console.error("Error rendering page:", error);
                            });
                        }
                    }).catch(error => {
                        console.error('Error loading PDF:', error);
                    });
                });
            });

            document.getElementById('dateOfBirth<?php echo $reqId; ?>').addEventListener('input', function() {
                const dob = new Date(this.value);
                const today = new Date();
                let age = today.getFullYear() - dob.getFullYear();
                const monthDifference = today.getMonth() - dob.getMonth();

                // Adjust if the birthday hasn't occurred yet this year
                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }

                // Update the age input field
                document.getElementById('user_age<?php echo $reqId; ?>').value = age;
            });
        });
    </script>
<?php
}
?>
</script>
</script>
</script>