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
$user_brgy = $_SESSION['user_brgy'];

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
    <title>Post</title>
    <!-- local css -->
    <link rel="stylesheet" href="civilianMaterials/style.c.css">
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
                                        <h6 class=" mb-0">
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

                    <div class=" text-center">
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
                            <a class="nav-link  active-post" aria-current="page" href="post.c.php">Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="profile.c.php">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="document.c.php">Document</a>
                        </li>
                    </ul>
                    <hr>
                </div>
                <button type="button" class="btn mt-3 w-100 rounded-5  mt-auto" data-bs-toggle="modal" data-bs-target="#signoutModal"><i class="bi bi-box-arrow-left"></i> Sign out </button>
            </nav>

            <!-- main content -->
            <main class="col-12 col-md-9 content border rounded p-3">
                <nav>
                    <div class="nav nav-tabs w-100" id="nav-tab" role="tablist">
                        <button class="nav-link active flex-fill " id="nav-brgy-tab" data-bs-toggle="tab" data-bs-target="#nav-brgy" type="button" role="tab" aria-controls="nav-brgy" aria-selected="true">Barangay</button>
                        <button class="nav-link flex-fill " id="nav-municipal-tab" data-bs-toggle="tab" data-bs-target="#nav-municipal" type="button" role="tab" aria-controls="nav-municipal" aria-selected="false">Municipal</button>
                    </div>
                </nav>
                <div class="tab-content mt-2 p-1" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-brgy" role="tabpanel" aria-labelledby="nav-brgy-tab" tabindex="0">
                        <!-- show all barangay post where you are registered -->
                        <div id="brgyPost">

                        </div>
                    </div>

                    <div class="tab-pane fade " id="nav-municipal" role="tabpanel" aria-labelledby="nav-municipal-tab" tabindex="0">
                        <!-- show all municipal post -->
                        <div id="municipalPost">

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

        //load brgy post and municipal post from database
        $(document).ready(function() {
            $.post('civilian_includes/show_brgyPost.c.php', {}, function(data) {
                $("#brgyPost").html(data);
            });
            $.post('civilian_includes/show_municipalPost.c.php', {}, function(data) {
                $("#municipalPost").html(data);
            });

            $.post('civilian_includes/show_notification.php', {}, function(data) {
                $("#notification-content").html(data);
            });

            $.post('civilian_includes/show_notification_count.php', {}, function(data) {
                $("#count-notification").html(data);
            });

            function updateBrgyPost() {
                $.post('civilian_includes/show_brgyPost.c.php', {}, function(data) {
                    $("#brgyPost").html(data);
                    setTimeout(updateBrgyPost, 30000);
                });
            }

            function updateMunicipalPost() {
                $.post('civilian_includes/show_municipalPost.c.php', {}, function(data) {
                    $("#municipalPost").html(data);
                    setTimeout(updateMunicipalPost, 30000);
                });
            }

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


            // Initial call to load messages
            updateBrgyPost();
            updateMunicipalPost();
            updateNotification();
            showNotificationCount()
        });
    </script>

    <script src="civilianMaterials/script.c.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php
if (isset($_SESSION['success_message'])) {
?>
    <script>
        Swal.fire({
            title: "Success",
            text: "<?php echo $_SESSION['success_message']; ?>",
            icon: "success",
        });
    </script>
<?php
    unset($_SESSION['success_message']);
}
?>

</html>