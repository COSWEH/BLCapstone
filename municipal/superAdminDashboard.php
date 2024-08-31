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
} else {
    while ($row = mysqli_fetch_assoc($checkUser)) {
        $brgy = $row['user_brgy'];
        $fname = $row['user_fname'];
        $mname = $row['user_mname'];
        $lname = $row['user_lname'];
        $gender = $row['user_gender'];
    }
}

// If user role is not super admin
if ($user_role != 2) {
    header('Location: ../unauthorized.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- local css -->
    <link rel="stylesheet" href="municipalMaterials/style.m.css">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap icon CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- jquery ajax cdn -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
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
                            $fullname = $fname . " " . $mname . " " . $lname;
                            echo ucwords(strtolower($fullname));
                            ?>
                        </h6>
                    </div>
                    <hr>
                    <h3 class="mb-3">Menu</h3>
                    <ul class="navbar-nav flex-column mb-3">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="superAdminPost.m.php">Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="superAdminProfiling.m.php">Profiling</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active-post" aria-current="page" href="superAdminDashboard.php">Dashboard</a>
                        </li>
                    </ul>
                    <hr>
                </div>


                <button type="button" class="btn mt-3 w-100 rounded-5 mt-auto" data-bs-toggle="modal" data-bs-target="#signoutModal"><i class="bi bi-box-arrow-left"></i> Sign out </button>
            </nav>

            <!-- main content -->
            <main class="col-12 col-md-9 content border rounded p-3">
                <div class="card mb-3 shadow border-0 rounded-3">
                    <div class="ms-3 mt-3">
                        <h6>Logs</h6>
                    </div>
                    <div class="card-body">
                        <div id="showLogs" class="overflow-auto" style="height: 300px;">

                        </div>
                    </div>
                </div>

                <div class="card mb-3 shadow border-0 rounded-3">
                    <div class="ms-3 mt-3">
                        <h6>Super admin account</h6>
                        <button class="btn btn-sm btn-success" aria-current="page" data-bs-toggle="modal" data-bs-target="#addAdmin">Add account</button>
                    </div>
                    <div class="card-body">

                        <div id="showAllSuperAdmin" class="overflow-auto" style="height: 300px;">

                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- add admin account modal -->
    <div class="modal fade" id="addAdmin" tabindex="-1" aria-labelledby="addAdminLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border border-0">
                    <div class="w-100 text-center">
                        <h4 class="modal-title " id="addAdminLabel">Add Admin Account</h4>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="container p-5 modal-body">
                    <form action="municipal_includes/addSuperAdminAcc.php" method="POST">

                        <!-- Group 1: Full Name -->
                        <div id="group1" class="form-step">
                            <h4 class="h4  mb-3">Personal Information</h4>
                            <div class="form-floating mb-3">
                                <input type="text" name="fname" class="form-control" id="user_fname" placeholder="First Name" required pattern="^[a-zA-Z\s\-]+$">
                                <label for="user_fname" class="form-label">First Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="mname" class="form-control" id="user_mname" placeholder="Middle Name" pattern="^[a-zA-Z\s\-]+$">
                                <label for="user_mname" class="form-label">Middle Name</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" name="lname" class="form-control" id="user_lname" placeholder="Last Name" required pattern="^[a-zA-Z\s\-]+$">
                                <label for="user_lname" class="form-label">Last Name</label>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary  w-100" id="nextBtn1">
                                        Next <i class="bi bi-arrow-right-square"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Group 2: Sex and Address -->
                        <div id="group2" class="form-step d-none">
                            <h4 class="h4  mb-3">Personal Information</h4>
                            <div class="form-floating mb-3">
                                <select id="user_gender" name="gender" class="form-select" required>
                                    <option value="" disabled selected>Select Male or Female</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <label for="user_gender" class="form-label">Sex</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="user_purok" class="form-control" id="user_purok" placeholder="Purok" required>
                                <label for="user_purok" class="form-label">Purok</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" name="contactNum" class="form-control" id="contactNum" placeholder="Contact Number" required pattern="^(09\d{9}|639\d{9})$" title="(e.g., 09123456789 or 639123456789)">
                                <label for="contactNum" class="form-label">Contact Number</label>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-6 mb-2">
                                    <button type="button" class="btn btn-secondary  w-100" id="prevBtn2">
                                        <i class="bi bi-arrow-left-square"></i>
                                        Previous
                                    </button>
                                </div>
                                <div class="col-12 col-md-6">
                                    <button type="button" class="btn btn-primary  w-100" id="nextBtn2">
                                        Next <i class="bi bi-arrow-right-square"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Group 3: Additional Information -->
                        <div id="group3" class="form-step d-none">
                            <h4 class="h4  mb-3">Additional Information</h4>
                            <!-- Date of Birth and Place of Birth -->
                            <div class="form-floating mb-3">
                                <input id="dateOfBirth" class="form-control" type="date" name="dateOfBirth" placeholder="Date of Birth" required>
                                <label for="dateOfBirth">Date of Birth</label>
                            </div>

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

                            <div class="row">
                                <div class="col-12 col-md-6 mb-2">
                                    <button type="button" class="btn btn-secondary  w-100" id="prevBtn3">
                                        <i class="bi bi-arrow-left-square"></i>
                                        Previous
                                    </button>
                                </div>
                                <div class="col-12 col-md-6">
                                    <button type="button" class="btn btn-primary  w-100" id="nextBtn4">
                                        Next <i class="bi bi-arrow-right-square"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Group 4: Account Information -->
                        <div id="group4" class="form-step d-none">
                            <h4 class="h4  mb-3">Account Information</h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="email" name="email" class="form-control" id="user_email" placeholder="Email Address" required title="e.g., juandelacruz143@gmail.com">
                                        <label for="user_email" class="form-label">Email Address</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="username" class="form-control" id="username" placeholder="Username" required pattern="^[a-zA-Z]{2}[a-zA-Z0-9.@_\\-\\s]+$" title="At least three characters and more">
                                        <label for="username" class="form-label">Username</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-floating mb-3 position-relative">
                                        <input type="password" name="signupPassword" class="form-control mb-3" id="signupPassword" placeholder="Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="At least one number, one uppercase letter, one lowercase letter, and at least 8 or more characters">
                                        <span class="icon position-absolute top-50 end-0 translate-middle-y p-3" id="signupShowPasswordIcon"><i class="bi bi-eye-slash-fill"></i></span>
                                        <label for="signupPassword" class="form-label">Password</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3 position-relative">
                                        <input type="password" name="confirmPassword" class="form-control mb-3" id="confirmPassword" placeholder="Confirm Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="At least one number, one uppercase letter, one lowercase letter, and at least 8 or more characters">
                                        <span class="icon position-absolute top-50 end-0 translate-middle-y p-3" id="confirmShowPasswordIcon"><i class="bi bi-eye-slash-fill"></i></span>
                                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6 mb-2">
                                    <button type="button" class="btn btn-secondary  w-100" id="prevBtn4">
                                        <i class="bi bi-arrow-left-square"></i>
                                        Previous
                                    </button>
                                </div>
                                <div class="col-12 col-md-6">
                                    <button type="submit" name="btnSignup" class="btn btn-success  w-100">
                                        Save <i class="bi bi-save"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- signout modal -->
    <div class="modal fade" id="signoutModal" tabindex="-1" aria-labelledby="signoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-warning-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-box-arrow-left text-warning" style="font-size: 25px;"></i>
                    </div>

                    <h6 class="my-3 fw-semibold">Are you sure you want to sign out?</h6>
                    <p class="text-muted">Please confirm if you wish to end your session.</p>
                    <form action="../signout.php" method="POST">
                        <div class="d-grid gap-3 mx-4">
                            <button type="submit" name="btnSignout" class="btn btn-primary">
                                Sign out
                            </button>
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
            //load all logs from database
            $.post('municipal_includes/showAllLogs.php', {}, function(data) {
                $("#showLogs").html(data);
            });

            $.post('municipal_includes/AllSuperAdmin.php', {}, function(data) {
                $("#showAllSuperAdmin").html(data);
            });

            function updateLogs() {
                $.post('municipal_includes/showAllLogs.php', {}, function(data) {
                    $("#showLogs").html(data);
                    setTimeout(updateLogs, 10000);
                });
            }

            // Initial call to load messages
            updateLogs();

            // get admin info
            $('#nextBtn1').click(function() {
                $('#group1').addClass('d-none');
                $('#group2').removeClass('d-none');
            });

            $('#prevBtn2').click(function() {
                $('#group2').addClass('d-none');
                $('#group1').removeClass('d-none');
            });

            $('#nextBtn2').click(function() {
                $('#group2').addClass('d-none');
                $('#group3').removeClass('d-none');
            });

            $('#prevBtn3').click(function() {
                $('#group3').addClass('d-none');
                $('#group2').removeClass('d-none');
            });

            $('#nextBtn4').click(function() {
                $('#group3').addClass('d-none');
                $('#group4').removeClass('d-none');
            });

            $('#prevBtn4').click(function() {
                $('#group4').addClass('d-none');
                $('#group3').removeClass('d-none');
            });


            // Function to toggle password visibility
            function togglePasswordVisibility(inputId, iconId) {
                const passwordInput = document.getElementById(inputId);
                const showPasswordIcon = document.getElementById(iconId);

                showPasswordIcon.addEventListener("click", function() {
                    if (passwordInput.type === "password") {
                        passwordInput.type = "text";
                        showPasswordIcon.innerHTML = '<i class="bi bi-eye-fill"></i>';
                    } else {
                        passwordInput.type = "password";
                        showPasswordIcon.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
                    }
                });
            }

            // Initialize the toggle for each password field
            togglePasswordVisibility("signupPassword", "signupShowPasswordIcon");
            togglePasswordVisibility("confirmPassword", "confirmShowPasswordIcon");
        });
    </script>

    <script src="municipalMaterials/script.m.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
// s.a. deleted
if (isset($_SESSION['delete_message'])) {
?>
    <script>
        Swal.fire({
            title: "Success",
            text: "<?php echo $_SESSION['delete_message']; ?>",
            icon: "success",
        });
    </script>
<?php
    unset($_SESSION['delete_message']);
}

// s.a. registered
if (isset($_SESSION['addSuperAdmin_success_message'])) {
?>
    <script>
        Swal.fire({
            title: "Success",
            text: "<?php echo $_SESSION['addSuperAdmin_success_message']; ?>",
            icon: "success",
        });
    </script>
<?php
    unset($_SESSION['addSuperAdmin_success_message']);
}
?>