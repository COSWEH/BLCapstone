<?php
include('../includes/conn.inc.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role_id'])) {
    header('Location: ../signout.php');
    exit;
}

// echo ".";
$getUserid = $_SESSION['user_id'];
$user_role = $_SESSION['role_id'];
$adminBrgy = $_SESSION['user_brgy'];

// Validate the user against the database
$checkUser = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `user_id` = '$getUserid' LIMIT 1");
$countUser = mysqli_num_rows($checkUser);

$getRegisteredUsers = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `user_brgy` = '$adminBrgy' && `role_id` = 0");
$countGetRegisteredUsers = mysqli_num_rows($getRegisteredUsers);

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

function countMaleFemaleUsers($con, $adminBrgy, $sex)
{
    $getUserSex = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `user_brgy` = '$adminBrgy' && `user_gender` = '$sex' && `role_id` = 0");
    $countGetUserSex = mysqli_num_rows($getUserSex);

    return $countGetUserSex;
}

function countDocumentReleased($con, $adminBrgy, $docType)
{
    $adminBrgy = strtolower($adminBrgy);
    $getDocType = mysqli_query($con, "SELECT * FROM `tbl_requests` WHERE `req_brgy` = '$adminBrgy' && `req_typeOfDoc` = '$docType($adminBrgy)' && `req_status` = 'Approved'");
    $countGetDocType = mysqli_num_rows($getDocType);

    return $countGetDocType;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiling</title>
    <link rel="stylesheet" href="brgyMaterials/style.b.css">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap icon CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top d-lg-none d-md-none">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../img/BayanLinkLogoBlack.png" alt="Logo" width="46" height="40" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="mx-3 mb-3">
                <div class="d-flex align-items-center mt-2">
                    <?php
                    $getGender = $_SESSION['user_gender'];
                    if ($getGender == "Male") {
                        echo '<img src="../img/male-user.png" alt="Profile Picture" class="img-fluid rounded-circle mb-2" style="width: 50px; height: 50px;">';
                    } else {
                        echo '<img src="../img/female-user.png" alt="Profile Picture" class="img-fluid rounded-circle mb-2" style="width: 50px; height: 50px;">';
                    }
                    ?>
                    <p class="mb-0">
                        <?php
                        $fullname = $_SESSION['user_fname'] . " " . $_SESSION['user_mname'] . " " . $_SESSION['user_lname'];
                        echo ucwords($fullname);
                        ?>
                    </p>
                </div>
            </div>

            <div class="mx-3">
                <ul class="navbar-nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="adminPost.b.php">Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="adminDocument.b.php">Document</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="adminProfiling.b.php">Profiling</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active-post" aria-current="page" href="adminDashboard.php">Dashboard</a>
                    </li>
                </ul>
                <hr>
                <button type="button" class="btn w-100 rounded-5 mb-3" data-bs-toggle="modal" data-bs-target="#signoutModal"><i class="bi bi-box-arrow-left"></i> Sign out </button>
            </div>
        </div>
    </nav>

    <div class="container-fluid p-3">
        <div class="row g-3">
            <!-- left -->
            <nav class="col-md-2 d-none d-md-block sidebar border rounded p-3 bg-body-tertiary d-flex flex-column">
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
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="adminPost.b.php">Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="adminDocument.b.php">Document</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  " aria-current="page" href="adminProfiling.b.php">Profiling</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active-document" aria-current="page" href="adminDashboard.php">Dashboard</a>
                        </li>
                        <hr>
                    </ul>
                </div>
                <button type="button" class="btn mt-3 w-100 rounded-5  mt-auto" data-bs-toggle="modal" data-bs-target="#signoutModal"><i class="bi bi-box-arrow-left"></i> Sign out </button>
            </nav>

            <!-- main content -->
            <main class="col-12 col-md-10 content border rounded p-3">

                <!-- number of civilians -->
                <div class="card mb-3 shadow border-0 rounded-3">
                    <div class="row">
                        <div class="col col-lg-4 col-sm-12">
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <h6><i class="bi bi-people-fill fs-1 text-success me-3"></i></h6>
                                <h2 class="fw-bold me-5">
                                    <?php echo $countGetRegisteredUsers; ?>
                                </h2>
                            </div>
                            <h6 class="text-center mb-3">Total Registered Users in Barangay</h6>
                        </div>

                        <div class="col col-lg-4 col-sm-12">
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <h6><i class="bi bi-gender-male fs-1 text-success me-3"></i></h6>
                                <h2 class="fw-bold me-5">
                                    <?php echo countMaleFemaleUsers($con, $adminBrgy, 'Male'); ?>
                                </h2>
                            </div>
                            <h6 class="text-center mb-3">Total Male Users in Barangay</h6>
                        </div>

                        <div class="col col-lg-4 col-sm-12">
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <h6><i class="bi bi-gender-female fs-1 text-success me-3"></i></h6>
                                <h2 class="fw-bold me-5">
                                    <?php echo countMaleFemaleUsers($con, $adminBrgy, 'Female'); ?>
                                </h2>
                            </div>
                            <h6 class="text-center mb-3">Total Female Users in Barangay</h6>
                        </div>
                    </div>

                </div>

                <!-- number of document relased -->
                <div class="card mb-3 shadow border-0 rounded-3 p-2">
                    <div class="row">
                        <div class="col col-lg-3 col-md-6 col-sm-12">
                            <h6 class="mt-3 text-center">Barangay Clearance</h6>
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <h6><i class="bi bi-file-earmark-check-fill fs-2 text-success me-3"></i></h6>
                                <h2 class="fw-bold me-5">
                                    <?php echo countDocumentReleased($con, $adminBrgy, 'Barangay Clearance'); ?>
                                </h2>
                            </div>
                        </div>

                        <div class="col col-lg-3 col-md-6 col-sm-12">
                            <h6 class="mt-3 text-center">Barangay Indigency</h6>
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <h6><i class="bi bi-file-earmark-check-fill fs-2 text-success me-3"></i></h6>
                                <h2 class="fw-bold me-5">
                                    <?php echo countDocumentReleased($con, $adminBrgy, 'Barangay Indigency'); ?>
                                </h2>
                            </div>
                        </div>

                        <div class="col col-lg-3 col-md-6 col-sm-12">
                            <h6 class="mt-3 text-center">Barangay Residency</h6>
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <h6><i class="bi bi-file-earmark-check-fill fs-2 text-success me-3"></i></h6>
                                <h2 class="fw-bold me-5">
                                    <?php echo countDocumentReleased($con, $adminBrgy, 'Barangay Residency'); ?>
                                </h2>
                            </div>
                        </div>

                        <div class="col col-lg-3 col-md-6 col-sm-12">
                            <h6 class="mt-3 text-center">Job Seeker</h6>
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <h6><i class="bi bi-file-earmark-check-fill fs-2 text-success me-3"></i></h6>
                                <h2 class="fw-bold me-5">
                                    <?php echo countDocumentReleased($con, $adminBrgy, 'Job Seeker'); ?>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <h6 class="ms-3 mb-3">Total Document Released</h6>
                </div>

                <div class="card mb-3 shadow border-0 rounded-3">
                    <div class="ms-3 mt-3 me-3 d-flex justify-content-between align-items-center">
                        <h6>Types of documents</h6>
                        <button class="btn btn-sm btn-primary" aria-current="page" data-bs-toggle="modal" data-bs-target="#addDocumentModal">Add document</button>
                    </div>
                    <div class="card-body">

                        <div id="showAllDocuments" class="overflow-auto" style="height: 300px;">

                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
    <!-- add doc modal -->
    <div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-success-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-file-earmark-text text-success" style="font-size: 25px;"></i>
                    </div>

                    <h6 class="my-3 fw-semibold">Add Document</h6>
                    <p class="text-muted">Fill out the form below to add a new document.</p>

                    <div class="container">
                        <form action="brgy_includes/addDocument.php" method="POST" enctype="multipart/form-data">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="documentType" name="documentType" placeholder="Document Type" required>
                                <label for="documentType">Document Type</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="file" class="form-control" id="documentTemplate" name="documentTemplate" placeholder="Document Template" accept=".pdf" required>
                                <label for="documentType">Document Template</label>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" name="btnAddDocument" class="btn btn-primary">
                                    Add Document
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

            $.post('brgy_includes/showAllDocuments.php', {}, function(data) {
                $("#showAllDocuments").html(data);
            });
        });
    </script>
    <script src="brgyMaterials/script.b.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
// Function to display SweetAlert messages
function displaySuccessMessage($sessionKey, $title = "Success", $icon = "success")
{
    if (isset($_SESSION[$sessionKey])) {
        echo '<script>
                Swal.fire({
                    title: "' . $title . '",
                    text: "' . $_SESSION[$sessionKey] . '",
                    icon: "' . $icon . '",
                });
            </script>';
        unset($_SESSION[$sessionKey]);
    }
}

displaySuccessMessage('delete_message');
displaySuccessMessage('delete_docType_message');
displaySuccessMessage('add_doc_message');
displaySuccessMessage('required_add_doc_message', 'Oops', 'warning');
displaySuccessMessage('pdf_only_add_doc_message', 'Oops', 'warning');
displaySuccessMessage('error_upload_add_doc_message', 'Error', 'error');
displaySuccessMessage('failed_add_doc_message', 'Failed', 'error');
displaySuccessMessage('alrExist_add_doc_message', 'Oops', 'warning');

?>