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
    <title>Profile</title>
    <!-- local css -->
    <link rel="stylesheet" href="civilianMaterials/style.c.css">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap icon CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- JQUERY CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid p-3">
        <div class="row g-3">
            <!-- left -->
            <nav class="col-12 col-md-3 sidebar border rounded p-3 bg-body-tertiary d-flex flex-column">
                <div>
                    <div class="d-flex justify-content-between mb-3">
                        <button id="theme-toggle" class="btn shadow">
                            <i class="bi bi-moon-fill" id="moon-icon"></i>
                            <i class="bi bi-brightness-high-fill" id="sun-icon" style="display:none;"></i>
                        </button>
                        <div class="dropdown">
                            <button class="btn shadow position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="notificationButton">
                                <i class="bi bi-bell-fill"></i>
                                <div id="count-notification">
                                </div>
                            </button>
                            <ul class="dropdown-menu">
                                <div class="card border border-0" style="width: 300px;">
                                    <!-- Notification Header -->
                                    <div class="card-header bg-info text-light">
                                        <h6 class="fw-bold mb-0">
                                            Notifications
                                        </h6>
                                    </div>
                                    <li>
                                        <div id="notification-content" class="p-3">
                                            <!-- Your notification content here -->
                                        </div>

                                    </li>
                                </div>
                            </ul>
                        </div>
                    </div>


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
                            <a class="nav-link fw-bold active-profile" aria-current="page" href="profile.c.php">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-bold" aria-current="page" href="document.c.php">Document</a>
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
                <h2 class="mb-3 fw-bold">Personal Information</h2>
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <p class="card-text"><strong>From San Isidro?:</strong> <span id="fromSanIsidro"><?php echo $_SESSION['fromSanIsidro']; ?></span></p>
                    </div>
                </div>
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <p class="card-text"><strong>Barangay:</strong> <span id="barangay"><?php echo $_SESSION['user_brgy']; ?></span></p>
                    </div>
                </div>
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <p class="card-text"><strong>Fullname:</strong> <span id="fullname">
                                <?php
                                $fullname = $_SESSION['user_fname'] . ' ' . $_SESSION['user_mname'] . ' ' . $_SESSION['user_lname'];
                                echo ucwords($fullname);
                                ?></span></p>
                    </div>
                </div>
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <p class="card-text"><strong>Gender:</strong> <span id="gender">
                                <?php
                                $gender = $_SESSION['user_gender'];
                                echo ucwords($gender);
                                ?></span></p>
                    </div>
                </div>
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <p class="card-text"><strong>Address:</strong> <span id="address"><?php echo $_SESSION['user_address']; ?></span></p>
                    </div>
                </div>
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <p class="card-text"><strong>Contact Number:</strong> <span id="contactNum"><?php echo $_SESSION['user_contactNum']; ?></span></p>
                    </div>
                </div>
                <hr>
                <h2 class="mb-3 fw-bold">Account Information</h2>
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <p class="card-text"><strong>Email:</strong> <span id="email"><?php echo $_SESSION['user_email']; ?></span></p>
                    </div>
                </div>
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <p class="card-text"><strong>Username:</strong> <span id="username"><?php echo $_SESSION['username']; ?></span></p>
                    </div>
                </div>
                <div class="card mb-3 shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <p class="card-text mb-0"><strong>Password:</strong> ********</p>
                        <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change Password</button>
                    </div>
                </div>
                <hr>
                <button type="button" class="btn btn-warning fw-bold" data-bs-toggle="modal" data-bs-target="#updateModal">Update Information</button>
            </main>
        </div>
    </div>
    <!-- change password modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="w-100 text-center">
                        <h4 class="modal-title fw-bold" id="changePasswordModalLabel">Change Password</h4>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="container p-5 modal-body">
                    <!-- Password Change Form -->
                    <form action="civilian_includes/change_password.c.php" method="POST">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Current Password" required pattern=".{8,}">
                            <label for="currentPassword" class="form-label">Current Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New Password" required pattern=".{8,}">
                            <label for="newPassword" class="form-label">New Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" placeholder="Confirm New Password" required pattern=".{8,}">
                            <label for="confirmNewPassword" class="form-label">Confirm New Password</label>
                        </div>
                        <button type="submit" name="btnChangePass" class="btn btn-primary w-100">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Information Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="w-100 text-center">
                        <h4 class="modal-title fw-bold" id="updateModalLabel">Update information</h4>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="container p-5 modal-body">
                    <form action="civilian_includes/update_information.c.php" method="POST">
                        <h4 class="h4 fw-bold">Personal Information</h4>
                        <!-- Dropdown for San Isidro -->
                        <div class="form-floating mb-3">
                            <?php
                            $selectedValue = isset($_SESSION['fromSanIsidro']) ? $_SESSION['fromSanIsidro'] : '';
                            ?>
                            <select id="fromSanIsidroYN" name="fromSanIsidro" class="form-select" required>
                                <option value="" disabled <?php echo $selectedValue === '' ? 'selected' : ''; ?>>Select Yes or No</option>
                                <option value="Yes" <?php echo $selectedValue === 'Yes' ? 'selected' : ''; ?>>Yes</option>
                                <option value="No" <?php echo $selectedValue === 'No' ? 'selected' : ''; ?>>No</option>
                            </select>
                            <label for="fromSanIsidroYN" class="form-label">Are you from San Isidro?</label>
                        </div>

                        <!-- Barangay -->
                        <div class="form-floating mb-3">
                            <?php
                            $selectedBarangay = isset($_SESSION['user_brgy']) ? $_SESSION['user_brgy'] : '';
                            ?>
                            <select name="barangay" id="user_brgy" class="form-select" required>
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
                            <label for="user_brgy" class="form-label">Which Barangay are you from?</label>
                        </div>
                        <hr>

                        <!-- Full Name -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" name="fname" class="form-control" id="user_fname" placeholder="First Name" required pattern="^[a-zA-Z\s\-]+$" value="<?php echo $_SESSION['user_fname']; ?>">
                                    <label for="user_fname" class="form-label">First Name</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" name="mname" class="form-control" id="user_mname" placeholder="Middle Name" pattern="^[a-zA-Z\s\-]+$" value="<?php echo $_SESSION['user_mname']; ?>">
                                    <label for="user_mname" class="form-label">Middle Name</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" name="lname" class="form-control" id="user_lname" placeholder="Last Name" pattern="^[a-zA-Z\s\-]+$" required value="<?php echo $_SESSION['user_lname']; ?>">
                                    <label for="user_lname" class="form-label">Last Name</label>
                                </div>
                            </div>
                        </div>

                        <!-- gender -->
                        <div class="form-floating mb-3">
                            <select name="gender" id="user_gender" class="form-select" required>
                                <option value="" disabled>Select Male or Female</option>
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

                        <!-- Address and Contact Number -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="address" class="form-control" id="user_address" placeholder="Address" required pattern="^[a-zA-Z0-9\s\-.,]+$" value="<?php echo $_SESSION['user_address']; ?>">
                                    <label for="user_address" class="form-label">Address</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" name="contactNum" class="form-control" id="user_contactNum" placeholder="Contact Number" required pattern="^(09\d{9}|639\d{9})$" title="(e.g., 09123456789 or 639123456789)" value="<?php echo $_SESSION['user_contactNum']; ?>">
                                    <label for="user_contactNum" class="form-label">Contact Number</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h4 class="h4 fw-bold">Account Information</h4>
                        <!-- Email and Username -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" name="email" class="form-control" id="user_email" placeholder="Email Address" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="e.g., juandelacruz143@gmail.com" value="<?php echo $_SESSION['user_email']; ?>">
                                    <label for="user_email" class="form-label">Email Address</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="username" class="form-control" id="username" placeholder="Username" required required pattern="^[a-zA-Z]{2}[a-zA-Z0-9.@_\\-\\s]+$" title="At least three characters and more" value="<?php echo $_SESSION['username']; ?>">
                                    <input type="hidden" name="password" value="<?php echo $_SESSION['password']; ?>">
                                    <label for="username" class="form-label">Username</label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="btnUpdate" class="btn btn-warning fw-bold w-100">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="civilianMaterials/script.c.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // update status to read
        document.getElementById("notificationButton").addEventListener("click", function() {
            // Get the notification count element
            var notificationCountElement = document.querySelector("#count-notification .badge");

            // Check if the notification count is not empty
            if (notificationCountElement && notificationCountElement.innerText.trim() !== "") {
                // AJAX request to update notifications status to "read"
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "civilian_includes/update_notifications.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        console.log("All notifications updated to read");
                        // Clear the notification count badge
                        document.getElementById("count-notification").innerHTML = '';
                    }
                };
                xhr.send();
            } else {
                console.log("No unread notifications to update.");
            }
        });

        $(document).ready(function() {
            $.post('civilian_includes/show_notification.php', {}, function(data) {
                $("#notification-content").html(data);
            });

            $.post('civilian_includes/show_notification_count.php', {}, function(data) {
                $("#count-notification").html(data);
            });

            function updateNotification() {
                $.post('civilian_includes/show_notification.php', {}, function(data) {
                    $("#notification-content").html(data);
                    setTimeout(updateNotification, 500);
                });
            }

            function showNotificationCount() {
                $.post('civilian_includes/show_notification_count.php', {}, function(data) {
                    $("#count-notification").html(data);
                    setTimeout(showNotificationCount, 500);
                });
            }

            updateNotification();
            showNotificationCount()


            const barangayOptions = [
                "Alua", "Calaba", "Malapit", "Mangga", "Poblacion",
                "Pulo", "San Roque", "Sto. Cristo", "Tabon"
            ];

            const $barangaySelect = $('#user_brgy');
            const $fromSanIsidroSelect = $('#fromSanIsidroYN');

            // Function to update the barangay select options
            function updateBarangayOptions() {
                const selectedValue = $fromSanIsidroSelect.val();
                $barangaySelect.empty(); // Clear existing options

                if (selectedValue === "Yes") {
                    $barangaySelect.append('<option value="" disabled selected>Select Barangay</option>');
                    barangayOptions.forEach(option => {
                        $barangaySelect.append(`<option value="${option}">${option}</option>`);
                    });
                } else if (selectedValue === "No") {
                    $barangaySelect.append('<option value="N/A" selected>N/A</option>');
                }
            }

            // Update options when selection changes
            $fromSanIsidroSelect.change(function() {
                updateBarangayOptions();
            });

            // Initial load
            updateBarangayOptions();
        });
    </script>
</body>

<?php
if (isset($_SESSION['password_message'])) {
    echo '<script>
            Swal.fire({
                title: "' . $_SESSION['password_message_code'] . '",
                text: "' . $_SESSION['password_message'] . '",
                icon: "' . strtolower($_SESSION['password_message_code']) . '",
            });
        </script>';
    unset($_SESSION['password_message']);
}

if (isset($_SESSION['update_message'])) {
    echo '<script>
            Swal.fire({
                title: "' . $_SESSION['update_message_code'] . '",
                text: "' . $_SESSION['update_message'] . '",
                icon: "' . strtolower($_SESSION['update_message_code']) . '",
            });
        </script>';
    unset($_SESSION['update_message']);
}
?>

</html>