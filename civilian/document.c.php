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
                <h4 class="fw-bold">Document</h4>
                <hr>
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
                <div class="row">
                    <!-- Document Card -->
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-3">
                        <div class="card shadow border border-2">
                            <div class="card-body">
                                <h4 class="card-title mb-3">Barangay Clearance</h4>
                                <hr>
                                <!-- Additional details, initially hidden -->
                                <div class="additional-details d-none">
                                    <div class="d-flex flex-column mb-3">
                                        <div class="d-flex justify-content-between mb-3">
                                            <h6 class="font-weight-bold">
                                                <i class="bi bi-person-fill me-2"></i>
                                                <?php echo $_SESSION['user_fname'] . " " . $_SESSION['user_lname']; ?>
                                            </h6>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h6 class="font-weight-bold">
                                                <i class="bi bi-phone me-2"></i>
                                                <?php echo $_SESSION['user_contactNum']; ?>
                                            </h6>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h6 class="font-weight-bold">
                                                <i class="bi bi-house-door me-2"></i>
                                                <?php echo $_SESSION['user_brgy']; ?>
                                            </h6>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h6 class="font-weight-bold">
                                                <i class="bi bi-file-earmark-text-fill me-2"></i>
                                                Barangay Clearance
                                            </h6>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h6 class="font-weight-bold">
                                                <i class="bi bi-calendar me-2"></i>
                                                Aug. 04, 2024
                                            </h6>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <h6>
                                                <i class="bi bi-check-circle-fill me-2"></i>
                                                <span class="text-warning font-weight-bold">
                                                    Pending
                                                </span>
                                            </h6>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <button class="btn btn-primary w-100 toggle-button">See more</button>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Request Document Modal -->
    <div class="modal fade" id="reqDocModal" tabindex="-1" aria-labelledby="reqDocModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title fw-bold" id="reqDocModalLabel">
                        Request Document
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Request Document Form -->
                    <form id="requestDocumentForm" action="" method="POST">
                        <!-- Document Request Type Radio Buttons in a Row -->
                        <div class="mb-3">
                            <label class="form-label">Request For</label>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-check">
                                        <input id="forYourself" class="form-check-input" type="radio" name="requestType" value="yourself" checked>
                                        <label class="form-check-label fw-bold" for="forYourself">
                                            Yourself
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-check">
                                        <input id="forOthers" class="form-check-input" type="radio" name="requestType" value="others">
                                        <label class="form-check-label fw-bold" for="forOthers">
                                            Others
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Personal Information Fields -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input id="firstName" class="form-control" type="text" placeholder="First Name" disabled value="<?php echo $_SESSION['user_fname']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input id="lastName" class="form-control" type="text" placeholder="Last Name" disabled value="<?php echo $_SESSION['user_lname']; ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contactNumber" class="form-label">Contact Number</label>
                                <input id="contactNumber" class="form-control" type="text" placeholder="Contact Number" disabled value="<?php echo $_SESSION['user_contactNum']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="barangay" class="form-label">Barangay</label>
                                <input id="barangay" class="form-control" type="text" placeholder="Barangay" disabled value="<?php echo $_SESSION['user_brgy']; ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="documentType" class="form-label">Type of Document</label>
                            <select id="documentType" class="form-select" required>
                                <option value="" disabled selected>Select document type</option>
                                <option value="birth_certificate">Birth Certificate</option>
                                <option value="marriage_certificate">Marriage Certificate</option>
                                <option value="passport">Passport</option>
                                <option value="driver_license">Driver's License</option>
                                <option value="id_card">ID Card</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="userPassword" class="form-label">Password</label>
                            <input id="userPassword" class="form-control" type="password" placeholder="Password" required>
                        </div>
                        <button type="submit" name="btnReqDocument" class="btn btn-primary fw-bold w-100">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>






    <script>
        $(document).ready(function() {
            $('.toggle-button').on('click', function() {
                var $cardBody = $(this).closest('.card-body');
                var $additionalDetails = $cardBody.find('.additional-details');
                var isVisible = !$additionalDetails.hasClass('d-none');

                if (isVisible) {
                    $additionalDetails.addClass('d-none');
                    $(this).text('See more');
                } else {
                    $additionalDetails.removeClass('d-none');
                    $(this).text('See less');
                }
            });

            // others selected
            function updateFields() {
                if ($('#forOthers').is(':checked')) {
                    // Clear the fields if "Others" is selected
                    $('#firstName, #lastName, #contactNumber, #barangay').prop('disabled', false).val('');

                } else if ($('#forYourself').is(':checked')) {
                    // Restore values and disable fields if "Yourself" is selected
                    $('#firstName').val('<?php echo $_SESSION['user_fname']; ?>').prop('disabled', true);
                    $('#lastName').val('<?php echo $_SESSION['user_lname']; ?>').prop('disabled', true);
                    $('#contactNumber').val('<?php echo $_SESSION['user_contactNum']; ?>').prop('disabled', true);
                    $('#barangay').val('<?php echo $_SESSION['user_brgy']; ?>').prop('disabled', true);
                }
            }

            // Initial update
            updateFields();

            // Event listeners for radio buttons
            $('#forOthers').on('change', updateFields);
            $('#forYourself').on('change', updateFields);
        });
    </script>
    <script src="civilianMaterials/script.c.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>