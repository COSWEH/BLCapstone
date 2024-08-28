<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_SESSION['verification_code']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $fromSanIsidro = $_SESSION['fromSanIsidro'];
    $barangay = $_SESSION['user_brgy'];
    $fname = $_SESSION['superAdmin_fname'];
    $mname = $_SESSION['superAdmin_mname'];
    $lname = $_SESSION['superAdmin_lname'];
    $gender = $_SESSION['superAdmin_gender'];
    $address = $_SESSION['superAdmin_address'];
    $contactNum = $_SESSION['superAdmin_contactNum'];
    $email = $_SESSION['superAdmin_email'];
    $username = $_SESSION['superAdmin_username'];
    $password = $_SESSION['superAdmin_password'];
    $role_id = $_SESSION['role_id'];

    echo $userOtp = $_SESSION['verification_code'];
} else {
    header('location: ../superAdminPost.m.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication</title>
    <!-- local css -->
    <link rel="stylesheet" href="indexMaterials/style.im.css">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap icon CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="d-flex justify-content-center align-items-center mt-5">
        <?php
        if (isset($_POST['btnVerify'])) {
            $otp = $_POST['otpv'];

            if ($userOtp != $otp) {
                $_SESSION['otp_error'] = "Invalid OTP";

                if (isset($_SESSION['otp_error'])) {
        ?>
                    <script>
                        Swal.fire({
                            title: "Error",
                            text: "' . $_SESSION['otp_error'] . '",
                            icon: "error",
                        });
                    </script>
        <?php
                    unset($_SESSION['otp_error']);
                }
            } else {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $insert = mysqli_query($con, "INSERT INTO tbl_useracc (user_id, fromSanIsidro, user_brgy, user_fname, user_mname, user_lname, user_gender, user_address, user_contactNum, user_email, username, password, role_id, user_create_at) VALUES ('', '$fromSanIsidro', '$barangay', '$fname', '$mname', '$lname', '$gender', '$address', '$contactNum', '$email', '$username', '$password', '$role_id', CURRENT_TIMESTAMP)");

                if ($insert) {
                    $_SESSION['addAdmin_success_message'] = "Register successfully!";
                    header('Location: ../superAdminPost.m.php');
                    exit;
                }
            }
        }
        ?>
    </div>

    <div class="d-flex justify-content-center align-items-center mt-5 p-3">
        <div class="card shadow-lg" style="width: 24rem;">
            <div class="card-body shadow-lg" style="font-family: Montserrat, Arial;">
                <h4 class=" card-title text-center fw-bold text-dark-emphasis">OTP verification</h4>
                <h6 class="card-subtitle mb-2 text-body-secondary text-center"><small>Your OTP code sent to your email address * <?php echo $email; ?>.</small></h6>

                <form method="POST" class="form-group">
                    <div class="mt-5 mb-3">
                        <div style="position: relative">
                            <input type="text" name="otpv" id="otpv" placeholder="Enter your OTP code" class="form-control mb-3 fs-9">
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-outline-primary btn-sm" id="btnVerify" name="btnVerify">Verify</button>
                    </div>
                    <hr>
                    <div class="text-center mt-3">
                        <a href="../superAdminPost.m.php" class="text-dark-emphasis"><small>Cancel</small></a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>