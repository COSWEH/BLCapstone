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
    <title>Municipal</title>
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
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link fw-bold active-post" aria-current="page" href="superAdminPost.m.php">Post</a>
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
                <nav>
                    <div class="nav nav-tabs w-100" id="nav-tab" role="tablist">
                        <button class="nav-link active flex-fill fw-bold" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">Municipal</button>
                        <button class="nav-link flex-fill fw-bold" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="false">Barangay</button>
                    </div>
                </nav>
                <div class="tab-content mt-2 p-1" id="nav-tabContent">
                    <!-- municipal -->
                    <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                        <!-- create post -->
                        <div class="card mb-3 shadow p-3">
                            <div class="d-flex align-items-center">
                                <!-- Profile Image -->
                                <?php
                                $getGender = $_SESSION['user_gender'];
                                if ($getGender == "Male") {
                                    echo '<img src="../img/male-user.png" alt="Profile Picture" class="img-fluid rounded-circle mb-2" style="width: 75px; height: 75px;">';
                                } else {
                                    echo '<img src="../img/female-user.png" alt="Profile Picture" class="img-fluid rounded-circle mb-2" style="width: 75px; height: 75px;">';
                                }
                                ?>
                                <button type="button" class="btn btn-lg ms-3 fw-bold rounded-5 w-100 bg-light-subtle" data-bs-toggle="modal" data-bs-target="#postModal">
                                    <i class="bi bi-images me-2"></i>
                                    Create post
                                </button>
                            </div>
                            <hr>
                        </div>
                        <!-- show all municipal post -->
                        <div id="municipalPost">

                        </div>
                    </div>

                    <!-- barangay -->
                    <div class="tab-pane fade" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                        <!-- show all barangay post -->
                        <div id="brgyPost">

                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- create post modal -->
    <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <div class="w-100 text-center">
                        <h4 class="modal-title fw-bold" id="postModalLabel">
                            Create post
                        </h4>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Post Content Form -->
                    <form id="createPostForm" action="municipal_includes/createPost.m.php" method="POST" enctype="multipart/form-data">
                        <div class="d-flex align-items-center mb-3">
                            <img src="../img/male-user.png" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 75px; height: 75px;">
                            <div>
                                <h6 class="mb-0">
                                    <?php
                                    $fullname = ucwords(strtolower($fullname));
                                    echo $fullname;
                                    ?>
                                </h6>
                                <h6 class="text-muted mb-0">
                                    <?php
                                    echo "<small class='fw-bold'>From: </small>" . $brgy;
                                    ?>
                                </h6>
                            </div>
                        </div>
                        <div class="mb-3">
                            <textarea name="textContent" class="form-control" id="postContent" rows="3" required placeholder="What's on your mind?"></textarea>
                        </div>
                        <div class="mb-3">
                            <div for="mAddPhotos" class="rounded border bg-light-subtle text-center p-3 d-flex flex-column align-items-center justify-content-center" style="height: 150px; cursor: pointer;">
                                <i class="bi bi-images mb-2"></i>
                                <p class="m-0 fw-bold">Add Photos</p>
                                <!-- change to file -->
                                <input type="file" name="mAddPhotos[]" id="mAddPhotos" class="opacity-0 position-absolute" accept=".jpg, jpeg, .png" multiple>
                            </div>
                            <hr>
                            <!-- Show selected photos with equal layout -->
                            <div id="selectedPhotosForCreate" class="row g-2">
                                <!-- Selected photos will be added here -->
                            </div>
                        </div>
                        <button type="submit" name="maBtnCreatePost" class="btn btn-primary w-100">Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedFiles = [];

        document.getElementById("mAddPhotos").addEventListener("change", function(event) {
            const files = event.target.files;
            const photoContainer = document.getElementById("selectedPhotosForCreate");

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                selectedFiles.push(file);

                console.log("Added image:", file.name); // Log when image is added

                const reader = new FileReader();

                reader.onload = function(e) {
                    // Create a new container for the image and remove button
                    const photoWrapper = document.createElement("div");
                    photoWrapper.classList.add("col-12", "col-md-4", "position-relative");

                    const imgElement = document.createElement("img");
                    imgElement.src = e.target.result;
                    imgElement.classList.add("img-fluid", "rounded", "shadow-sm");

                    // Create a remove button
                    const removeButton = document.createElement("button");
                    removeButton.classList.add(
                        "btn",
                        "bg-dark-subtle",
                        "position-absolute",
                        "top-0",
                        "end-0",
                        "m-2"
                    );
                    removeButton.innerHTML = '<i class="bi bi-x"></i>';
                    // Append image and button to the wrapper
                    photoWrapper.appendChild(imgElement);
                    photoWrapper.appendChild(removeButton);
                    // Append the wrapper to the container
                    photoContainer.appendChild(photoWrapper);
                    // Add event listener to the remove button
                    removeButton.addEventListener("click", function() {
                        photoContainer.removeChild(photoWrapper);
                        selectedFiles = selectedFiles.filter(f => f !== file);
                        console.log("Removed image:", file.name); // Log when image is removed
                    });
                };

                reader.readAsDataURL(file);
            }
        });

        document.getElementById("createPostForm").addEventListener("submit", function(event) {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            document.getElementById("mAddPhotos").files = dataTransfer.files;

            console.log("Submitting form with images:", selectedFiles.map(f => f.name)); // Log images before submission
        });

        //load all brgy post from database
        $(document).ready(function() {
            // brgy post
            $.post('municipal_includes/show_brgyPost.m.php', {}, function(data) {
                $("#brgyPost").html(data);
            });

            // municipalPost
            $.post('municipal_includes/show_municipalPost.m.php', {}, function(data) {
                $("#municipalPost").html(data);
            });

            function updateBrgyPost() {
                $.post('municipal_includes/show_brgyPost.m.php', {}, function(data) {
                    $("#brgyPost").html(data);
                    setTimeout(updateBrgyPost, 300);
                });
            }

            function updateMunicpalPost() {
                $.post('municipal_includes/show_municipalPost.m.php', {}, function(data) {
                    $("#municipalPost").html(data);
                });
            }

            // Initial call to load brgy post
            updateBrgyPost();
            updateMunicpalPost();

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

// success post
if (isset($_SESSION['post_message'])) {
    echo '<script>
            Swal.fire({
                title: "Success",
                text: "' . $_SESSION['post_message'] . '",
                icon: "success",
            });
        </script>';
    unset($_SESSION['post_message']);
}

//delete post
if (isset($_SESSION['delete_message'])) {
    echo '<script>
            Swal.fire({
                title: "Success",
                text: "' . $_SESSION['delete_message'] . '",
                icon: "success",
            });
        </script>';
    unset($_SESSION['delete_message']);
}
?>

</html>