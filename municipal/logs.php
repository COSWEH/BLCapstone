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
    <title>Logs</title>
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
                            <a class="nav-link fw-bold" aria-current="page" href="superAdminPost.m.php">Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-bold active-post" aria-current="page" href="logs.php">Logs</a>
                        </li>
                        <?php include('addSuperAdmin.m.php') ?>
                        <li class="nav-item">
                            <button class="btn nav-link fw-bold" aria-current="page" data-bs-toggle="modal" data-bs-target="#faqsModal">FAQ</button>
                        </li>
                    </ul>

                    <!-- add faqs modal -->
                    <div class="modal fade" id="faqsModal" tabindex="-1" aria-labelledby="faqsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header text-center">
                                    <div class="w-100 text-center">
                                        <h4 class="modal-title fw-bold" id="faqsModalLabel">
                                            Frequently Asked Questions
                                        </h4>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <form action="municipal_includes/addFaqs.m.php" method="POST">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="question" class="form-control" id="question" placeholder="Question" required>
                                            <label for="question" class="form-label">Question</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea name="answer" class="form-control" id="answer" placeholder="Answers" style="height: 100px" required></textarea>
                                            <label for="answer" class="form-label">Answers</label>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-md-4 mb-2">
                                                <button type="submit" name="btnFaqs" class="btn btn-outline-primary fw-bold w-100">Add</button>
                                            </div>
                                            <div class="col-12 col-md-4 mb-2">
                                                <button type="button" class="btn btn-outline-warning fw-bold w-100" data-bs-toggle="modal" data-bs-dismiss="modal" id="editButton">Edit</button>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <button type="button" class="btn btn-outline-danger fw-bold w-100" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- edit faqs modal -->
                    <div class="modal fade" id="editFaqsModal" tabindex="-1" aria-labelledby="editFaqsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <div class="w-100 text-center">
                                        <h4 class="modal-title fw-bold" id="editFaqsModalLabel">
                                            <small>
                                                Edit Frequently Asked Questions
                                            </small>
                                        </h4>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div id="showFaqs" class="modal-body">

                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>

                <button type="button" class="btn mt-3 w-100 rounded-5 fw-bold mt-auto" data-bs-toggle="modal" data-bs-target="#signoutModal"><i class="bi bi-box-arrow-left"></i> Sign out </button>
                <!-- signout modal -->
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

                <div id="showLogs">

                </div>

            </main>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            document.getElementById('editButton').addEventListener('click', function() {
                var faqsModal = new bootstrap.Modal(document.getElementById('faqsModal'));
                var editFaqsModal = new bootstrap.Modal(document.getElementById('editFaqsModal'));

                // Close the current modal
                faqsModal.hide();

                // Open the new modal after a slight delay to ensure proper closing
                setTimeout(function() {
                    editFaqsModal.show();
                }, 300); // Adjust the delay as needed
            });


            function showFaqs() {
                $.post("municipal_includes/edit_faqs.php", {}, function(data) {
                    $("#showFaqs").html(data);
                });

                setTimeout(showFaqs, 30000);
            }

            //load all logs from database
            $.post('municipal_includes/showAllLogs.php', {}, function(data) {
                $("#showLogs").html(data);
            });

            function updateLogs() {
                $.post('municipal_includes/showAllLogs.php', {}, function(data) {
                    $("#showLogs").html(data);
                    setTimeout(updateLogs, 10000);
                });
            }

            // Initial call to load messages
            updateLogs();
            showFaqs();
        });
    </script>

    <script src="municipalMaterials/script.m.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php

// success login
if (isset($_SESSION['success_message'])) {
    echo '<script>
            Swal.fire({
                title: "Success",
                text: "' . $_SESSION['success_message'] . '",
                icon: "success",
            });
        </script>';
    unset($_SESSION['success_message']);
}

?>

</html>