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

// If user role is not brgy admin
if ($user_role != 1) {
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
    <link rel="stylesheet" href="brgyMaterials/style.b.css">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap icon CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jquery ajax cdn -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

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
                            $fullname = $_SESSION['user_fname'] . " " . $_SESSION['user_mname'] . " " . $_SESSION['user_lname'];
                            echo ucwords($fullname);
                            ?>
                        </h6>
                    </div>
                    <hr>
                    <h3 class="mb-3">Menu</h3>
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="adminPost.b.php">Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  active-document" aria-current="page" href="adminDocument.b.php">Document</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="adminProfiling.b.php">Profiling</a>
                        </li>
                        <?php include('addAdmin.b.php') ?>
                        <hr>
                    </ul>
                </div>
                <button type="button" class="btn mt-3 w-100 rounded-5  mt-auto" data-bs-toggle="modal" data-bs-target="#signoutModal"><i class="bi bi-box-arrow-left"></i> Sign out </button>
            </nav>

            <!-- main content -->
            <main class="col-12 col-md-9 content border rounded p-3">
                <div class="form-floating mb-3 shadow border border-3 rounded-3">
                    <input type="text" class="form-control" id="searchByName" name="search" placeholder="Search" required>
                    <label for="search" class="form-label">
                        <small>
                            <i class="bi bi-search"></i>
                            Search by name...
                        </small>
                    </label>
                </div>

                <nav>
                    <div class="nav nav-tabs w-100" id="nav-tab" role="tablist">
                        <button class="nav-link active flex-fill " id="nav-pending-tab" data-bs-toggle="tab" data-bs-target="#nav-pending" type="button" role="tab" aria-controls="nav-pending" aria-selected="true">Pending</button>
                        <button class="nav-link flex-fill " id="nav-processing-tab" data-bs-toggle="tab" data-bs-target="#nav-processing" type="button" role="tab" aria-controls="nav-processing" aria-selected="false">Processing</button>
                        <button class="nav-link flex-fill " id="nav-approved-tab" data-bs-toggle="tab" data-bs-target="#nav-approved" type="button" role="tab" aria-controls="nav-approved" aria-selected="false">Approved</button>
                        <button class="nav-link flex-fill " id="nav-cancelled-tab" data-bs-toggle="tab" data-bs-target="#nav-cancelled" type="button" role="tab" aria-controls="nav-cancelled" aria-selected="false">Cancelled</button>
                    </div>
                </nav>

                <div class="tab-content mt-2 p-1" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab" tabindex="0">
                        <!-- show all pending document requests -->
                        <div id="show_pending_reqDoc" class="row">
                            <!-- Content for pending requests -->
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-processing" role="tabpanel" aria-labelledby="nav-processing-tab" tabindex="0">
                        <!-- show all processing document requests -->
                        <div id="show_processing_reqDoc" class="row">
                            <!-- Content for processing requests -->
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-approved" role="tabpanel" aria-labelledby="nav-approved-tab" tabindex="0">
                        <!-- show all approved document requests -->
                        <div id="show_approved_reqDoc" class="row">
                            <!-- Content for approved requests -->
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-cancelled" role="tabpanel" aria-labelledby="nav-cancelled-tab" tabindex="0">
                        <!-- show all cancelled document requests -->
                        <div id="show_cancelled_reqDoc" class="row">
                            <!-- Content for cancelled requests -->
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- signout modal -->
    <div class="modal fade" id="signoutModal" tabindex="-1" aria-labelledby="signoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <div class="w-100 text-center">
                        <h4 class="modal-title " id="signoutModalLabel">
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
                            <button type="submit" name="btnSignout" class="btn btn-primary me-2 ">Confirm</button>
                            <button type="button" class="btn btn-danger " data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let activeTab = 'pending';

            $('#nav-pending-tab').on('click', function() {
                activeTab = 'pending';
                loadRequestDocs(activeTab);
            });

            $('#nav-processing-tab').on('click', function() {
                activeTab = 'processing';
                loadRequestDocs(activeTab);
            });

            $('#nav-approved-tab').on('click', function() {
                activeTab = 'approved';
                loadRequestDocs(activeTab);
            });

            $('#nav-cancelled-tab').on('click', function() {
                activeTab = 'cancelled';
                loadRequestDocs(activeTab);
            });

            function loadRequestDocs(status) {
                $.post(`brgy_includes/show_${status}_reqDoc.php`, {}, function(data) {
                    $(`#show_${status}_reqDoc`).html(data);
                });
            }

            function updateReqDocs() {
                const statuses = ['pending', 'processing', 'approved', 'cancelled'];

                statuses.forEach(status => {
                    loadRequestDocs(status);
                });

                setTimeout(updateReqDocs, 30000);
            }

            $('#searchByName').on('keyup', function() {
                let searchQuery = $(this).val(); // Get the search query

                console.log(searchQuery);

                $.ajax({
                    url: 'brgy_includes/search_user.php', // PHP script to handle search
                    method: 'POST',
                    data: {
                        query: searchQuery
                    },
                    success: function(response) {
                        $(`#show_${activeTab}_reqDoc`).html(response);
                    }
                });
            });

            // Initial load
            updateReqDocs();

        });
    </script>
    <script src="brgyMaterials/script.b.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php
if (isset($_SESSION['processing_message'])) {
    echo '<script>
            Swal.fire({
                title: "Processing",
                text: "' . $_SESSION['processing_message'] . '",
                icon: "success",
            });
        </script>';
    unset($_SESSION['processing_message']);
}

if (isset($_SESSION['approved_message'])) {
    echo '<script>
            Swal.fire({
                title: "Approved",
                text: "' . $_SESSION['approved_message'] . '",
                icon: "success",
            });
        </script>';
    unset($_SESSION['approved_message']);
}

if (isset($_SESSION['cancelled_message'])) {
    echo '<script>
            Swal.fire({
                title: "Cancelled",
                text: "' . $_SESSION['cancelled_message'] . '",
                icon: "success",
            });
        </script>';
    unset($_SESSION['cancelled_message']);
}
?>

</html>