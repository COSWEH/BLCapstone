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
                            <a class="nav-link" aria-current="page" href="superAdminPost.m.php">Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active-post" aria-current="page" href="superAdminProfiling.m.php">Profiling</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="logs.php">Logs</a>
                        </li>
                        <?php include('addSuperAdmin.m.php') ?>
                        <li class="nav-item">
                            <button class="btn nav-link " aria-current="page" data-bs-toggle="modal" data-bs-target="#faqsModal">FAQ</button>
                        </li>
                    </ul>
                    <hr>
                </div>


                <button type="button" class="btn mt-3 w-100 rounded-5  mt-auto" data-bs-toggle="modal" data-bs-target="#signoutModal"><i class="bi bi-box-arrow-left"></i> Sign out </button>
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
            </nav>

            <!-- main content -->
            <main class="col-12 col-md-9 content border rounded p-3">
                <div class="form-floating mb-3 shadow border border-3 rounded-3">
                    <input type="text" class="form-control" id="searchByName" name="search" placeholder="Search" required>
                    <label for="search" class="form-label">
                        <small>
                            <i class="bi bi-search"></i>
                            Search resident name...
                        </small>
                    </label>
                </div>
                <hr>

                <div class="card shadow border border-3 rounded-3">
                    <div class="ms-3 mt-3">
                        <h6>Filter Options</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Sex Filter -->
                            <div class="col">
                                <label for="sexFilter" class="form-label">Sex</label>
                                <select class="form-select" id="sexFilter" name="sex">
                                    <option value="">All</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <!-- brgy filter -->
                            <div class="col">
                                <label for="brgyFilter" class="form-label">Barangay</label>
                                <select class="form-select" id="brgyFilter" name="brgy">
                                    <option value="">All</option>
                                    <!-- Add options for barangays -->
                                    <option value="Alua">Alua</option>
                                    <option value="Calaba">Calaba</option>
                                    <option value="Malapit">Malapit</option>
                                    <option value="Mangga">Mangga</option>
                                    <option value="Poblacion">Poblacion</option>
                                    <option value="Pulo">Pulo</option>
                                    <option value="San Roque">San Roque</option>
                                    <option value="Sto Cristo">Sto. Cristo</option>
                                    <option value="Tabon">Tabon</option>
                                </select>
                            </div>

                            <!-- Purok Filter -->
                            <div class="col">
                                <label for="purokFilter" class="form-label">Purok</label>
                                <select class="form-select" id="purokFilter" name="purok">
                                    <option value="">All</option>
                                    <!-- Add options dynamically from your database -->
                                    <option value="1">Purok 1</option>
                                    <option value="2">Purok 2</option>
                                    <option value="3">Purok 3</option>
                                    <option value="4">Purok 4</option>
                                    <option value="5">Purok 5</option>
                                    <option value="6">Purok 6</option>
                                    <option value="7">Purok 7</option>
                                    <option value="8">Purok 8</option>
                                    <option value="9">Purok 9</option>
                                    <option value="10">Purok 10</option>
                                </select>
                            </div>

                            <!-- Age Filter -->
                            <div class="col">
                                <label for="ageFilter" class="form-label">Age</label>
                                <select class="form-select" id="ageFilter" name="age">
                                    <option value="">All</option>
                                    <option value="18-25">18-25</option>
                                    <option value="26-35">26-35</option>
                                    <option value="36-45">36-45</option>
                                    <option value="46-60">46-60</option>
                                    <option value="60+">60+</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-secondary btn-sm" id="clearFilter">Clear filter</button>
                        </div>
                    </div>
                </div>
                <hr>

                <h6 class="ms-1 mb-3">List of residents in your city</h6>
                <div id="showAllResidents" class=" fs-5">

                </div>

            </main>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // show users list
            $.post('municipal_includes/allResidents.php', {}, function(data) {
                $("#showAllResidents").html(data);
            });

            //display user that is searched
            function filterResidents() {
                let searchQuery = $('#searchByName').val(); // Get the search query
                let sexFilter = $('#sexFilter').val(); // Get the sex filter value
                let brgyFilter = $('#brgyFilter').val();
                let purokFilter = $('#purokFilter').val(); // Get the purok filter value
                let ageFilter = $('#ageFilter').val(); // Get the age filter value

                $.ajax({
                    url: 'municipal_includes/searchResult.php', // PHP script to handle search and filtering
                    method: 'POST',
                    data: {
                        query: searchQuery,
                        sex: sexFilter,
                        brgy: brgyFilter,
                        purok: purokFilter,
                        age: ageFilter
                    },
                    success: function(response) {
                        $('#showAllResidents').html(response); // Update the residents list with the response
                    }
                });
            }

            // Trigger the filterResidents function on keyup for the search input
            $('#searchByName').on('keyup', function() {
                filterResidents();
            });

            // Trigger the filterResidents function when any of the select dropdowns change
            $('#sexFilter, #brgyFilter, #purokFilter, #ageFilter').on('change', function() {
                filterResidents();
            });

            // Clear the filters when the "Clear filter" button is clicked
            $('#clearFilter').on('click', function() {
                // Reset the values of the filters
                $('#searchByName').val('');
                $('#sexFilter').val('');
                $('#brgyFilter').val('');
                $('#purokFilter').val('');
                $('#ageFilter').val('');

                // Trigger the filterResidents function to refresh the list
                filterResidents();
            });

        });
    </script>

    <script src="municipalMaterials/script.m.js"></script>
</body>

</html>