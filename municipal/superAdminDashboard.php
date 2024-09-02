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
                        echo '<img src="../img/male-user.png" alt="Profile Picture" class="img-fluid rounded-circle me-3" style="width: 50px; height: 50px;">';
                    } else {
                        echo '<img src="../img/female-user.png" alt="Profile Picture" class="img-fluid rounded-circle me-3" style="width: 50px; height: 50px;">';
                    }
                    ?>
                    <p class="mb-0">
                        <?php
                        $fullname = $fname . " " . $mname . " " . $lname;
                        echo ucwords(strtolower($fullname));
                        ?>
                    </p>
                </div>
            </div>

            <div class="mx-3">
                <h5 class="mb-3">Menu</h5>
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
                <button type="button" class="btn w-100 rounded-5 mb-3" data-bs-toggle="modal" data-bs-target="#signoutModal"><i class="bi bi-box-arrow-left"></i> Sign out </button>
            </div>
        </div>
    </nav>

    <div class="container-fluid p-3">
        <div class="row g-3">
            <nav class="col-md-3 d-none d-md-block sidebar border rounded p-3 bg-body-tertiary d-flex flex-column">
                <div>
                    <button id="theme-toggle" class="btn btn-sm shadow mb-3 theme-toggle">
                        <i class="bi bi-moon-fill moon-icon" id="moon-icon"></i>
                        <i class="bi bi-brightness-high-fill sun-icon" id="sun-icon" style="display:none;"></i>
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

            <!-- Main Content -->
            <main class="col-12 col-md-9 content border rounded p-3">
                <div class="card mb-3 shadow border-0 rounded-3">
                    <div class="ms-3 mt-3">
                        <h6>Super admin account</h6>
                        <button class="btn btn-sm btn-success shadow" aria-current="page" data-bs-toggle="modal" data-bs-target="#addSuperAdminModal">Add account</button>
                    </div>
                    <div class="card-body">
                        <div id="showAllSuperAdmin" class="overflow-auto" style="height: 300px;">
                            <!-- Super admin accounts content -->
                        </div>
                    </div>
                </div>

                <!------maintainability(ewan kung tama spelling)  $('#home-title').text(response.home_title);
                        $('#home-subtitle1').text(response.home_subtitleOne);
                        $('#home-subtitle2').text(response.home_subtitleTwo);
                        $('#home-img').attr('src', 'index_dbImg/' + response.home_img);------>
                <!-- home -->
                <div class="card mb-3 shadow border-0 rounded-3">
                    <div class="ms-3 mt-3">
                        <h6>Home</h6>
                        <div class="row align-items-center mb-4">
                            <!-- Content Section -->
                            <div class="col-md-6 text-center text-md-start px-lg-5">
                                <!-- Title with Edit Button -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h1 id="home-title" class="display-6 mb-0">Loading...</h1>
                                    <button class="btn btn-sm btn-info ms-2" data-bs-toggle="modal" data-bs-target="#home_titleModal">Edit</button>
                                </div>
                                <!-- Subtitle1 with Edit Button -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <p id="home-subtitle1" class="small mb-0">Loading...</p>
                                    <button class="btn btn-sm btn-info ms-2" data-bs-toggle="modal" data-bs-target="#home_subtitle1Modal">Edit</button>
                                </div>
                                <!-- Subtitle2 with Edit Button -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <p id="home-subtitle2" class="small mb-0">Loading...</p>
                                    <button class="btn btn-sm btn-info ms-2" data-bs-toggle="modal" data-bs-target="#home_subtitle2Modal">Edit</button>
                                </div>
                            </div>
                            <!-- Image Section with Edit Button -->
                            <div class="col-md-6 px-lg-5 text-center">
                                <div class="position-relative">
                                    <img id="home-img" src="" width="300" height="200" alt="Bayanlink Overview" class="img-fluid rounded shadow-sm">
                                    <button class="btn btn-sm btn-info position-absolute bottom-0 end-0 m-2" data-bs-toggle="modal" data-bs-target="#home_imgModal">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3 shadow border-0 rounded-3">
                    <div class="ms-3 mt-3">
                        <h6>FAQs</h6>
                        <button class="btn btn-sm btn-success shadow" aria-current="page" data-bs-toggle="modal" data-bs-target="#addFaqsModal">Add faqs</button>
                    </div>
                    <div class="card-body">
                        <div id="showAllFaqs" class="overflow-auto" style="height: 300px;">
                            <!-- FAQs content -->
                        </div>
                    </div>
                </div>

                <div class="card mb-3 shadow border-0 rounded-3">
                    <div class="ms-3 mt-3">
                        <h6>Logs</h6>
                    </div>
                    <div class="card-body">
                        <div id="showLogs" class="overflow-auto" style="height: 300px;">
                            <!-- Logs content -->
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- --------------------------------- -->

    <!-- add super admin account modal -->
    <div class="modal fade" id="addSuperAdminModal" tabindex="-1" aria-labelledby="addSuperAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <!-- Modal Icon -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-success-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-person-plus text-success" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal Title -->
                    <h6 class="my-3 fw-semibold">Add Super Admin Account</h6>
                    <p class="text-muted">Please fill in the necessary information to create a new super admin account.</p>

                    <div class="container">
                        <form action="municipal_includes/addSuperAdminAcc.php" method="POST">

                            <!-- Group 1: Full Name -->
                            <div id="group1" class="form-step">
                                <h4 class="h4 mb-3">Personal Information</h4>
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
                                    <div class="col-12 mb-2">
                                        <button type="button" class="btn btn-primary w-100" id="nextBtn1">
                                            Next <i class="bi bi-arrow-right-square"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Group 2: Sex and Address -->
                            <div id="group2" class="form-step d-none">
                                <h4 class="h4 mb-3">Personal Information</h4>
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
                                        <button type="button" class="btn btn-secondary w-100" id="prevBtn2">
                                            <i class="bi bi-arrow-left-square"></i> Previous
                                        </button>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <button type="button" class="btn btn-primary w-100" id="nextBtn2">
                                            Next <i class="bi bi-arrow-right-square"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Group 3: Additional Information -->
                            <div id="group3" class="form-step d-none">
                                <h4 class="h4 mb-3">Additional Information</h4>
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
                                        <button type="button" class="btn btn-secondary w-100" id="prevBtn3">
                                            <i class="bi bi-arrow-left-square"></i> Previous
                                        </button>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <button type="button" class="btn btn-primary w-100" id="nextBtn4">
                                            Next <i class="bi bi-arrow-right-square"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Group 4: Account Information -->
                            <div id="group4" class="form-step d-none">
                                <h4 class="h4 mb-3">Account Information</h4>
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
                                        <button type="button" class="btn btn-secondary w-100" id="prevBtn4">
                                            <i class="bi bi-arrow-left-square"></i> Previous
                                        </button>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <button type="submit" class="btn btn-primary w-100" name="submit">
                                            Create Account <i class="bi bi-arrow-right-square"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Close Button -->
                <button type="button" class="btn-close position-absolute top-0 end-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- update home title modal -->
    <div class="modal fade" id="home_titleModal" tabindex="-1" aria-labelledby="home_titleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <!-- Icon and subTitle -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-primary-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-pencil-square text-primary" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal Title -->
                    <h4 class="my-3 fw-semibold" id="home_titleModalLabel">Update Home Title</h4>
                    <p class="text-muted">Update the home title below.</p>

                    <!-- Home title form -->
                    <form id="homeTitleForm" action="municipal_maintainability/update_home.php" method="POST">
                        <input type="hidden" id="home_title_id" value="" name="home_title_id">
                        <div class="form-floating mb-3">
                            <input type="text" name="home_title" class="form-control" id="hometitle" placeholder="Home title" required>
                            <label for="hometitle" class="form-label">Home title</label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" name="btnHomeTitle" class="btn btn-primary">Update</button>
                            <button type="button" class="btn border border-2" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- update subtitle 1 modal -->
    <div class="modal fade" id="home_subtitle1Modal" tabindex="-1" aria-labelledby="home_subtitle1ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <!-- Icon and subTitle -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-primary-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-pencil-square text-primary" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal Title -->
                    <h4 class="my-3 fw-semibold" id="home_subtitle1ModalLabel">Update Subtitle 1</h4>
                    <p class="text-muted">Update the home subtitle 1 below.</p>

                    <!-- Home title form -->
                    <form id="homeTitleForm" action="municipal_maintainability/update_home.php" method="POST">
                        <input type="hidden" id="home_subtitle1_id" value="" name="home_subtitle1_id">
                        <div class="form-floating mb-3">
                            <textarea type="text" name="home_subtitle1" class="form-control" id="homesubtitle1" placeholder="Home subtitle 1" style="height: 250px" required> </textarea>
                            <label for="homesubtitle1" class="form-label">Home subtitle 1</label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" name="btnHomeSubtitle1" class="btn btn-primary">Update</button>
                            <button type="button" class="btn border border-2" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- update subtitle 2 modal -->
    <div class="modal fade" id="home_subtitle2Modal" tabindex="-1" aria-labelledby="home_subtitle2ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <!-- Icon and subTitle -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-primary-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-pencil-square text-primary" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal subTitle 2 -->
                    <h4 class="my-3 fw-semibold" id="home_subtitle2ModalLabel">Update Subtitle 2</h4>
                    <p class="text-muted">Update the home subtitle 2 below.</p>

                    <!-- Home title form -->
                    <form id="homeTitleForm" action="municipal_maintainability/update_home.php" method="POST">
                        <input type="hidden" id="home_subtitle2_id" value="" name="home_subtitle2_id">
                        <div class="form-floating mb-3">
                            <textarea type="text" name="home_subtitle2" class="form-control" id="homesubtitle2" placeholder="Home subtitle 2" style="height: 250px" required> </textarea>
                            <label for="homesubtitle2" class="form-label">Home subtitle 2</label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" name="btnHomeSubtitle2" class="btn btn-primary">Update</button>
                            <button type="button" class="btn border border-2" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit home img modal -->
    <div class="modal fade" id="home_imgModal" tabindex="-1" aria-labelledby="home_imgModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <!-- Icon and Image -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-primary-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-image text-primary" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal Title -->
                    <h4 class="my-3 fw-semibold" id="home_imgModalLabel">Edit Home Img</h4>
                    <p class="text-muted">Update the home image below.</p>

                    <!-- Home Image Form -->
                    <form id="homeImgForm" action="municipal_maintainability/update_home.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="home_img_id" name="home_img_id" value="">

                        <div class="mb-3">
                            <label for="homeImg" class="form-label">Home Image</label>
                            <input type="file" name="home_img" class="form-control" id="homeImg" required>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" name="btnHomeImg" class="btn btn-primary">Update</button>
                            <button type="button" class="btn border border-2" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- add faqs modal -->
    <div class="modal fade" id="addFaqsModal" tabindex="-1" aria-labelledby="addFaqsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <!-- Icon and Title -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-primary-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-question-circle text-primary" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal Title -->
                    <h4 class="my-3 fw-semibold" id="addFaqsModalLabel">Frequently Asked Questions</h4>
                    <p class="text-muted">Please fill out the form below to add a new FAQ.</p>

                    <!-- Form -->
                    <form action="municipal_includes/addFaqs.m.php" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" name="question" class="form-control" id="question" placeholder="Question" required>
                            <label for="question" class="form-label">Question</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="answer" class="form-control" id="answer" placeholder="Answers" style="height: 100px" required></textarea>
                            <label for="answer" class="form-label">Answers</label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" name="btnFaqs" class="btn btn-primary">Add</button>
                            <button type="button" class="btn border border-2" data-bs-dismiss="modal">Cancel</button>
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
                <div class="modal-header text-center border border-0">
                    <div class="w-100 text-center">
                        <h4 class="modal-title " id="editFaqsModalLabel">
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

            $.post('municipal_includes/showAllFaqs.php', {}, function(data) {
                $("#showAllFaqs").html(data);
            });

            function updateLogs() {
                $.post('municipal_includes/showAllLogs.php', {}, function(data) {
                    $("#showLogs").html(data);
                    setTimeout(updateLogs, 10000);
                });
            }

            // Initial call to load messages
            updateLogs();

            $.ajax({
                url: '../includes/show_home.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        $('#home_title_id').val(response.home_id);
                        $('#home_subtitle1_id').val(response.home_id);
                        $('#home_subtitle2_id').val(response.home_id);
                        $('#home_img_id').val(response.home_id);
                        $('#home-title').text(response.home_title);
                        $('#home-subtitle1').text(response.home_subtitleOne);
                        $('#home-subtitle2').text(response.home_subtitleTwo);
                        $('#home-img').attr('src', '../index_dbImg/' + response.home_img);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });

            // get super admin info
            function navigateGroups(currentGroup, nextGroup) {
                $(currentGroup).addClass('d-none');
                $(nextGroup).removeClass('d-none');
            }

            $('#nextBtn1').click(function() {
                navigateGroups('#group1', '#group2');
            });

            $('#prevBtn2').click(function() {
                navigateGroups('#group2', '#group1');
            });

            $('#nextBtn2').click(function() {
                navigateGroups('#group2', '#group3');
            });

            $('#prevBtn3').click(function() {
                navigateGroups('#group3', '#group2');
            });

            $('#nextBtn4').click(function() {
                navigateGroups('#group3', '#group4');
            });

            $('#prevBtn4').click(function() {
                navigateGroups('#group4', '#group3');
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
function displaySuccessMessage($sessionKey, $title = "Success")
{
    if (isset($_SESSION[$sessionKey])) {
        echo '<script>
                Swal.fire({
                    title: "' . $title . '",
                    text: "' . $_SESSION[$sessionKey] . '",
                    icon: "success",
                });
            </script>';
        unset($_SESSION[$sessionKey]);
    }
}

displaySuccessMessage('addSuperAdmin_success_message');
displaySuccessMessage('update_home_message');
displaySuccessMessage('faq_message');
displaySuccessMessage('delete_faq_message');
?>