<?php
include('../includes/conn.inc.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role_id'])) {
    header('Location: ../signout.php');
    exit;
}

echo ".";
$getUserid = $_SESSION['user_id'];
$user_role = $_SESSION['role_id'];

// Validate the user against the database
$checkUser = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `user_id` = '$getUserid' LIMIT 1");
$countUser = mysqli_num_rows($checkUser);

// If user does not exist, sign out
if ($countUser < 1) {
    header('Location: ../signout.php');
    exit;
}

// If user role is not civilian
if ($user_role != 0) {
    header('Location: ../unauthorized.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="civilianMaterials/style.c.css">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap icon CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jquery ajax cdn -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
    <div class="container-fluid p-3">
        <div class="row g-3">
            <!-- left -->
            <nav class="col-12 col-md-3 sidebar border rounded p-3 bg-body-tertiary d-flex flex-column">
                <div>
                    <button id="theme-toggle" class="btn btn-sm shadow mb-3">
                        <i class="bi bi-moon-fill" id="moon-icon"></i>
                        <i class="bi bi-brightness-high-fill" id="sun-icon" style="display:none;"></i>
                    </button>
                    <div class="text-center">
                        <?php
                        $getGender = $_SESSION['user_gender'];
                        if ($getGender == "Male") {
                            echo '<img src="../img/male-user.png" alt="Profile Picture" class="img-fluid rounded-circle mb-2" style="width: 100px; height: 100px;">';
                        } else {
                            echo '<img src="../img/female-user.png" alt="Profile Picture" class="img-fluid rounded-circle mb-2" style="width: 100px; height: 100px;">';
                        }
                        ?>
                        <h6 class="mb-3">
                            <?php
                            $fullname = $_SESSION['user_fname'] . " " . $_SESSION['user_mname'] . " " . $_SESSION['user_lname'];
                            echo ucwords($fullname);
                            ?>
                        </h6>
                    </div>
                    <hr>
                    <h3 class="mb-3">Menu</h3>
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link fw-bold" aria-current="page" href="post.c.php">Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-bold" aria-current="page" href="profile.c.php">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-bold active-document" aria-current="page" href="document.c.php">Document</a>
                        </li>
                        <hr>
                    </ul>
                </div>
                <button type="button" class="btn mt-3 w-100 rounded-5 fw-bold mt-auto" data-bs-toggle="modal" data-bs-target="#signoutModal"><i class="bi bi-box-arrow-left"></i> Sign out </button>
                <!-- delete modal -->
                <div class="modal fade" id="signoutModal" tabindex="-1" aria-labelledby="signoutModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <div class="w-100 text-center">
                                    <h4 class="modal-title fw-bold" id="signoutModalLabel">
                                        Sign out
                                    </h4>
                                </div>
                            </div>
                            <div class="modal-body">
                                <form action="../signout.php" method="POST">
                                    <div class="text-center mb-3">
                                        <div class="mb-3">
                                            <i class="bi bi-exclamation-circle" style="font-size: 100px;"></i>
                                        </div>
                                        <h3 class="mb-3">Confirm to sign out.</h3>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" name="btnSignout" class="btn btn-primary me-2 fw-bold">Confirm</button>
                                        <button type="button" class="btn btn-danger fw-bold" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- main content -->
            <main class="col-12 col-md-9 content border rounded p-3">
                <!-- <h4 class="fw-bold">Document</h4> -->
                <!-- <hr> -->
                <!-- create post section-->
                <div class="card mb-3 shadow p-3">
                    <div class="d-flex align-items-center">
                        <!-- Profile Image -->
                        <?php
                        $getGender = $_SESSION['user_gender'];
                        if ($getGender == "Male") {
                            echo '<img src="../img/male-user.png" alt="Profile Picture" class="img-fluid rounded-circle mb-2" style="width: 75px; height: 75px;">';
                        } else {
                            echo '<img src="../img/female-user.png" alt="Profile Picture" class="img-fluid rounded-circle mb-2" style="width: 75px; height: 75px;">';
                        }
                        ?>
                        <button type="button" class="btn btn-lg ms-3 fw-bold rounded-5 w-100 bg-light-subtle" data-bs-toggle="modal" data-bs-target="#reqDocModal">
                            <i class="bi bi-file-earmark-text-fill me-2"></i>
                            Request document
                        </button>
                    </div>
                </div>

                <!-- List of Document Requests -->
                <div id="show_brgy_reqDoc" class="row">

                </div>

            </main>
        </div>
    </div>


    <!-- Request Document Modal -->
    <div class="modal fade" id="reqDocModal" tabindex="-1" aria-labelledby="reqDocModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <div class="w-100 text-center">
                        <h4 class="modal-title fw-bold" id="reqDocModalLabel">Request Document</h4>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="container p-5 modal-body">
                    <!-- Request Document Form -->
                    <form id="requestDocumentForm" action="civilian_includes/create_reqDoc.php" method="POST" enctype="multipart/form-data">
                        <!-- Step 1: Request For and Document Type -->
                        <div id="step1" class="form-step">
                            <label class="form-label">Request For</label>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input id="forYourself" class="form-check-input" type="radio" name="requestType" value="yourself" checked>
                                        <label class="form-check-label fw-bold" for="forYourself">Yourself</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input id="forOthers" class="form-check-input" type="radio" name="requestType" value="others">
                                        <label class="form-check-label fw-bold" for="forOthers">Others</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mb-3">
                                <select id="documentType" name="docType" class="form-select" required>
                                    <option value="" disabled selected>Select Document</option>
                                    <option value="Barangay Clearance">Barangay Clearance</option>
                                    <option value="Barangay Indigency">Barangay Indigency</option>
                                    <option value="Cedula">Cedula</option>
                                    <option value="Job Seeker">Job Seeker</option>
                                    <option value="Job Seeker">Business Permit</option>
                                </select>
                                <label for="documentType">Document Type</label>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary fw-bold w-100" id="nextBtn1">Next
                                        <i class="bi bi-arrow-right-square"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: First, Middle, and Last Name -->
                        <div id="step2" class="form-step d-none">
                            <h4 class="h4 fw-bold mb-3">Full Name</h4>
                            <input type="hidden" name="getUserid" value="<?php echo $getUserid; ?>">
                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input id="firstName" class="form-control" type="text" name="fName" placeholder="First Name" value="<?php echo $_SESSION['user_fname']; ?>" required>
                                        <label for="firstName">First Name</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input id="middleName" class="form-control" type="text" name="mName" placeholder="Middle Name" value="<?php echo $_SESSION['user_mname']; ?>" required>
                                        <label for="middleName">Middle Name</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input id="lastName" class="form-control" type="text" name="lName" placeholder="Last Name" value="<?php echo $_SESSION['user_lname']; ?>" required>
                                        <label for="lastName">Last Name</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <button type="button" class="btn btn-secondary fw-bold w-100" id="prevBtn1">
                                        <i class="bi bi-arrow-left-square"></i> Previous
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary fw-bold w-100" id="nextBtn2">
                                        Next <i class="bi bi-arrow-right-square"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Contact No, Gender, and Barangay -->
                        <div id="step3" class="form-step d-none">
                            <h4 class="h4 fw-bold mb-3">Contact Information</h4>
                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input id="contactNumber" class="form-control" type="text" name="contNumber" placeholder="Contact Number" value="<?php echo $_SESSION['user_contactNum']; ?>" required>
                                        <label for="contactNumber">Contact Number</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select id="user_gender" name="user_gender" class="form-select" required>
                                            <option value="" disabled selected>Select Male or Female</option>
                                            <?php
                                            if (isset($_SESSION['user_gender'])) {
                                                $getGender = $_SESSION['user_gender'];
                                                echo '<option value="Male"' . ($getGender == "Male" ? ' selected' : '') . '>Male</option>';
                                                echo '<option value="Female"' . ($getGender == "Female" ? ' selected' : '') . '>Female</option>';
                                            } else {
                                                echo '<option value="Male">Male</option>';
                                                echo '<option value="Female">Female</option>';
                                            }
                                            ?>
                                        </select>
                                        <label for="user_gender" class="form-label">Gender</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input id="barangay" class="form-control" type="text" name="user_brgy" placeholder="Barangay" value="<?php echo $_SESSION['user_brgy']; ?>" required>
                                        <label for="barangay">Barangay</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <button type="button" class="btn btn-secondary fw-bold w-100" id="prevBtn2">
                                        <i class="bi bi-arrow-left-square"></i> Previous
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary fw-bold w-100" id="nextBtn3">
                                        Next <i class="bi bi-arrow-right-square"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Purok, Age, and Date of Birth -->
                        <div id="step4" class="form-step d-none">
                            <h4 class="h4 fw-bold mb-3">Additional Information</h4>
                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input id="purok" class="form-control" type="text" name="purok" placeholder="Purok" value="<?php ?>" required>
                                        <label for="purok">Purok</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input id="age" class="form-control" type="text" name="age" placeholder="Age" value="<?php ?>" required>
                                        <label for="age">Age</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input id="dateOfBirth" class="form-control" type="date" name="dateOfBirth" placeholder="Date of Birth" required>
                                        <label for="dateOfBirth">Date of Birth</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <button type="button" class="btn btn-secondary fw-bold w-100" id="prevBtn3">
                                        <i class="bi bi-arrow-left-square"></i> Previous
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary fw-bold w-100" id="nextBtn4">
                                        Next <i class="bi bi-arrow-right-square"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Step 5: Place of Birth, Civil Status, and e-Signature -->
                        <div id="step5" class="form-step d-none">
                            <h4 class="h4 fw-bold mb-3">Additional Information</h4>
                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input id="placeOfBirth" class="form-control" type="text" name="placeOfBirth" placeholder="Place of Birth" required>
                                        <label for="placeOfBirth">Place of Birth</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select id="civilStatus" name="civilStatus" class="form-select" required>
                                            <option value="" disabled selected>Choose Status</option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Widowed">Widowed</option>
                                            <option value="Divorced">Divorced</option>
                                        </select>
                                        <label for="civilStatus">Civil Status</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input id="eSignature" class="form-control" type="file" name="eSignature" accept=".jpg, jpeg, .png" required>
                                        <label for="eSignature" class="form-label">E-Signature</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <button type="button" class="btn btn-secondary fw-bold w-100" id="prevBtn4">
                                        <i class="bi bi-arrow-left-square"></i> Previous
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary fw-bold w-100" id="nextBtn5">
                                        Next <i class="bi bi-arrow-right-square"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Step 6: Valid ID, Password -->
                        <div id="step6" class="form-step d-none">
                            <h4 class="h4 fw-bold mb-3">Final Information</h4>
                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input id="userValidID" class="form-control" type="file" name="userValidID" accept=".jpg, jpeg, .png" required>
                                        <label for="userValidID" class="form-label">Valid ID</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input id="userPassword" class="form-control" type="password" name="password" placeholder="Password" required>
                                        <label for="userPassword" class="form-label">Password</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <button type="button" class="btn btn-secondary fw-bold w-100" id="prevBtn5">
                                        <i class="bi bi-arrow-left-square"></i> Previous
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" name="btnReqDocument" class="btn btn-success fw-bold w-100">
                                        Submit <i class="bi bi-check-square"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            $.post('civilian_includes/show_brgy_reqDoc.php', {}, function(data) {
                $("#show_brgy_reqDoc").html(data);
            });

            function updateReqDoc() {
                $.post('civilian_includes/show_brgy_reqDoc.php', {}, function(data) {
                    $("#show_brgy_reqDoc").html(data);
                    setTimeout(updateReqDoc, 30000);
                });
            }

            updateReqDoc();

            // others selected
            function updateFields() {
                if ($('#forOthers').is(':checked')) {
                    // Clear the fields if "Others" is selected
                    $('#firstName, #lastName, #middleName, #contactNumber, #user_gender, #barangay').prop('disabled', false).val('');

                } else if ($('#forYourself').is(':checked')) {
                    // Restore values and disable fields if "Yourself" is selected
                    $('#firstName').val('<?php echo $_SESSION['user_fname']; ?>').prop('disabled', true);
                    $('#middleName').val('<?php echo $_SESSION['user_mname']; ?>').prop('disabled', true);
                    $('#lastName').val('<?php echo $_SESSION['user_lname']; ?>').prop('disabled', true);
                    $('#contactNumber').val('<?php echo $_SESSION['user_contactNum']; ?>').prop('disabled', true);
                    $('#user_gender').val('<?php echo $_SESSION['user_gender']; ?>').prop('disabled', true);
                    $('#barangay').val('<?php echo $_SESSION['user_brgy']; ?>').prop('disabled', true);
                }

                $('#btnReqDocument').on('click', function() {
                    $('#firstName, #lastName, #middlename, #contactNumber, #barangay').prop('disabled', false);
                });
            }

            updateFields();

            // Event listeners for radio buttons
            $('#forOthers').on('change', updateFields);
            $('#forYourself').on('change', updateFields);

            // Get the buttons and steps
            const nextBtn1 = document.getElementById('nextBtn1');
            const prevBtn1 = document.getElementById('prevBtn1');
            const nextBtn2 = document.getElementById('nextBtn2');
            const prevBtn2 = document.getElementById('prevBtn2');
            const nextBtn3 = document.getElementById('nextBtn3');
            const prevBtn3 = document.getElementById('prevBtn3');
            const nextBtn4 = document.getElementById('nextBtn4');
            const prevBtn4 = document.getElementById('prevBtn4');
            const nextBtn5 = document.getElementById('nextBtn5'); // Added
            const prevBtn5 = document.getElementById('prevBtn5'); // Added

            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            const step3 = document.getElementById('step3');
            const step4 = document.getElementById('step4');
            const step5 = document.getElementById('step5');
            const step6 = document.getElementById('step6'); // Added

            // Function to show a specific step
            function showStep(stepToShow) {
                [step1, step2, step3, step4, step5, step6].forEach(step => {
                    step.classList.add('d-none');
                });
                stepToShow.classList.remove('d-none');
            }

            // Event listeners for navigation buttons
            nextBtn1.addEventListener('click', function() {
                showStep(step2);
            });

            prevBtn1.addEventListener('click', function() {
                showStep(step1);
            });

            nextBtn2.addEventListener('click', function() {
                showStep(step3);
            });

            prevBtn2.addEventListener('click', function() {
                showStep(step2);
            });

            nextBtn3.addEventListener('click', function() {
                showStep(step4);
            });

            prevBtn3.addEventListener('click', function() {
                showStep(step3);
            });

            nextBtn4.addEventListener('click', function() {
                showStep(step5);
            });

            prevBtn4.addEventListener('click', function() {
                showStep(step4);
            });

            nextBtn5.addEventListener('click', function() {
                showStep(step6);
            });

            prevBtn5.addEventListener('click', function() {
                showStep(step5);
            });

            // Initialize with the first step
            showStep(step1);

        });
    </script>
    <script src="civilianMaterials/script.c.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php
// success post
if (isset($_SESSION['reqDoc_message'])) {
    echo '<script>
            Swal.fire({
                title: "Success",
                text: "' . $_SESSION['reqDoc_message'] . '",
                icon: "success",
            });
        </script>';
    unset($_SESSION['reqDoc_message']);
}
// reqDoc_invalid_password
if (isset($_SESSION['reqDoc_invalid_password'])) {
    echo '<script>
            Swal.fire({
                title: "Error",
                text: "' . $_SESSION['reqDoc_invalid_password'] . '",
                icon: "error",
            });
        </script>';
    unset($_SESSION['reqDoc_invalid_password']);
}
?>

</html>