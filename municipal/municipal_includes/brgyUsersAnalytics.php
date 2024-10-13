<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location: ../superAdminDashboard.m.php');
    exit;
}

$brgy = $_POST['brgy'] ?? 'All';

// first
function getTotalRegistedUsers($con, $brgy)
{

    if ($brgy === 'All') {
        // If "All" is selected, return the count of all users
        $getRegisteredUsers = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `role_id` = 0");
    } else {
        // If a specific barangay is selected, return the count of users from that barangay
        $getRegisteredUsers = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `role_id` = 0 AND `user_brgy` = '$brgy'");
    }

    $countGetRegisteredUsers = mysqli_num_rows($getRegisteredUsers);

    return $countGetRegisteredUsers;
}

function countAllMaleFemaleUsers($con, $sex, $brgy)
{
    if ($brgy === 'All') {
        $getUserSex = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `user_gender` = '$sex' AND `role_id` = 0");
    } else {
        $getUserSex = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `user_gender` = '$sex' AND `role_id` = 0 AND `user_brgy` = '$brgy'");
    }

    return mysqli_num_rows($getUserSex);
}

function countDocumentReleased($con, $allDocType, $brgy)
{

    $barangays = [
        "Alua",
        "Calaba",
        "Malapit",
        "Mangga",
        "Poblacion",
        "Pulo",
        "San Roque",
        "Sto. Cristo",
        "Tabon"
    ];

    $totalApprovedDocuments = 0;
    // Loop through each barangay
    if ($brgy === 'All') {
        foreach ($barangays as $barangay) {
            // Query to get the count of approved documents for the current barangay
            $getDocType = mysqli_query($con, "SELECT * FROM `tbl_requests` WHERE `req_typeOfDoc` = '$allDocType($barangay)' AND `req_brgy` = '$barangay' AND `req_status` = 'Approved'");
            $countGetDocType = mysqli_num_rows($getDocType);

            // Store the count in the array
            $totalApprovedDocuments += $countGetDocType;
        }
    } else {
        $getDocType = mysqli_query($con, "SELECT * FROM `tbl_requests` WHERE `req_typeOfDoc` = '$allDocType($brgy)' AND `req_brgy` = '$brgy' AND `req_status` = 'Approved'");
        $totalApprovedDocuments = mysqli_num_rows($getDocType);
    }

    return $totalApprovedDocuments;
}

?>

<div class="card mb-3 shadow border-0 rounded-3">
    <div class="row">
        <div class="col col-lg-4 col-sm-12">
            <div class="card-body d-flex justify-content-center align-items-center">
                <h6><i class="bi bi-people-fill fs-1 text-success me-3"></i></h6>
                <h2 class="fw-bold me-5">
                    <?php echo getTotalRegistedUsers($con, $brgy);
                    ?>
                </h2>
            </div>
            <h6 class="text-center mb-3">Total Registered Users in
                <?php echo ($brgy === 'All') ? 'San Isidro' : 'the Barangay of ' . $brgy; ?>
            </h6>
        </div>

        <div class="col col-lg-4 col-sm-12">
            <div class="card-body d-flex justify-content-center align-items-center">
                <h6><i class="bi bi-gender-male fs-1 text-success me-3"></i></h6>
                <h2 class="fw-bold me-5">
                    <?php echo countAllMaleFemaleUsers($con, 'Male', $brgy); ?>
                </h2>
            </div>
            <h6 class="text-center mb-3">Total Male Users in <?php echo ($brgy === 'All') ? 'San Isidro' : 'the Barangay of ' . $brgy; ?></h6>
        </div>

        <div class="col col-lg-4 col-sm-12">
            <div class="card-body d-flex justify-content-center align-items-center">
                <h6><i class="bi bi-gender-female fs-1 text-success me-3"></i></h6>
                <h2 class="fw-bold me-5">
                    <?php echo countAllMaleFemaleUsers($con, 'Female', $brgy); ?>
                </h2>
            </div>
            <h6 class="text-center mb-3">Total Female Users in <?php echo ($brgy === 'All') ? 'San Isidro' : 'the Barangay of ' . $brgy; ?></h6>
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
                    <?php
                    echo countDocumentReleased($con, 'Barangay Clearance', $brgy);
                    ?>
                </h2>
            </div>
        </div>

        <div class="col col-lg-3 col-md-6 col-sm-12">
            <h6 class="mt-3 text-center">Barangay Indigency</h6>
            <div class="card-body d-flex justify-content-center align-items-center">
                <h6><i class="bi bi-file-earmark-check-fill fs-2 text-success me-3"></i></h6>
                <h2 class="fw-bold me-5">
                    <?php
                    echo countDocumentReleased($con, 'Barangay Indigency', $brgy);
                    ?>
                </h2>
            </div>
        </div>

        <div class="col col-lg-3 col-md-6 col-sm-12">
            <h6 class="mt-3 text-center">Barangay Residency</h6>
            <div class="card-body d-flex justify-content-center align-items-center">
                <h6><i class="bi bi-file-earmark-check-fill fs-2 text-success me-3"></i></h6>
                <h2 class="fw-bold me-5">
                    <?php
                    echo countDocumentReleased($con, 'Barangay Residency', $brgy);
                    ?>
                </h2>
            </div>
        </div>

        <div class="col col-lg-3 col-md-6 col-sm-12">
            <h6 class="mt-3 text-center">Job Seeker</h6>
            <div class="card-body d-flex justify-content-center align-items-center">
                <h6><i class="bi bi-file-earmark-check-fill fs-2 text-success me-3"></i></h6>
                <h2 class="fw-bold me-5">
                    <?php
                    echo countDocumentReleased($con, 'Job Seeker', $brgy);
                    ?>
                </h2>
            </div>
        </div>
    </div>
    <h6 class="ms-3 mb-3">Total Document Released in <?php echo ($brgy === 'All') ? 'all of the Barangay' : 'the Barangay of ' . $brgy; ?></h6>
</div>