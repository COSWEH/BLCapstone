<?php
include('includes/conn.inc.php');
session_start();

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $token_hash = hash("sha256", $token);

    $_SESSION['getHashedToken'] = $token;

    $checkToken = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `reset_token_hash` = '$token_hash'");
    $countToken = mysqli_num_rows($checkToken);

    // If user does not exist, sign out
    if ($countToken < 1) {
        header('Location: signout.php');
        exit;
    }

    while ($row = mysqli_fetch_assoc($checkToken)) {
        $userid = $row['user_id'];
        $expiration = strtotime($row['reset_token_expires_at']);
    }

    if ($expiration <= time()) {
        die('Token has expired');
    }
} else {
    header('Location: signout.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap icon CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Reset Password</h4>
                    </div>
                    <div class="card-body">
                        <form action="includes/process-password-reset.php" method="POST">
                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password" required pattern=".{8,}">
                                <label for="new_password" class="form-label">New Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm New Password" required pattern=".{8,}">
                                <label for="confirm_password" class="form-label">Confirm New Password</label>
                            </div>
                            <button type="submit" name="btnResetPassword" class="btn btn-primary w-100 fw-bold">Reset Password</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="index.php" class="btn btn-secondary w-100">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php
if (isset($_SESSION['reset_pass_message'])) {
    echo '<script>
            Swal.fire({
                title: "Error",
                text: "' . $_SESSION['reset_pass_message'] . '",
                icon: "error",
            });
        </script>';
    unset($_SESSION['reset_pass_message']);
}
?>

</html>