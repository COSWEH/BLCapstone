<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location: ../superAdminProfiling.m.php');
    exit;
}

$superAdminLoc = $_SESSION['user_city'];
$query = $_POST['query'] ?? '';
$sex = $_POST['sex'] ?? '';
$brgy = $_POST['brgy'] ?? '';
$purok = $_POST['purok'] ?? '';
$age = $_POST['age'] ?? '';

// Start building the SQL query
$getUserQuery = "SELECT * FROM `tbl_useracc` WHERE `user_city` = '$superAdminLoc' AND `role_id` != 2";

// Apply search filter
if (!empty($query)) {
    $getUserQuery .= " AND (`user_fname` LIKE '%$query%' OR `user_mname` LIKE '%$query%' OR `user_lname` LIKE '%$query%')";
}

// Apply sex filter
if (!empty($sex)) {
    $getUserQuery .= " AND `user_gender` = '$sex'";
}

// Apply brgy filter
if (!empty($brgy)) {
    $getUserQuery .= " AND `user_brgy` = '$brgy'";
}

// Apply purok filter
if (!empty($purok)) {
    $getUserQuery .= " AND `user_purok` = '$purok'";
}

// Apply age filter
if (!empty($age)) {
    switch ($age) {
        case '18-25':
            $getUserQuery .= " AND `user_age` BETWEEN 18 AND 25";
            break;
        case '26-35':
            $getUserQuery .= " AND `user_age` BETWEEN 26 AND 35";
            break;
        case '36-45':
            $getUserQuery .= " AND `user_age` BETWEEN 36 AND 45";
            break;
        case '46-60':
            $getUserQuery .= " AND `user_age` BETWEEN 46 AND 60";
            break;
        case '60+':
            $getUserQuery .= " AND `user_age` >= 60";
            break;
    }
}

$result = mysqli_query($con, $getUserQuery);

if (!$result) {
    die('Error in query: ' . mysqli_error($con));
}
?>

<div class="table-responsive">
    <table class="table align-middle table-hover text-center text-capitalize">
        <thead class="table-active text-uppercase text-white">
            <tr>
                <th style="background-color: #323D42; color: #CBDCED; width: 12.5%;"><small>Full Name</small></th>
                <th style="background-color: #323D42; color: #8FA985; width: 12.5%;"><small>Sex</small></th>
                <th style="background-color: #323D42; color: #85937D; width: 12.5%;"><small>Barangay</small></th>
                <th style="background-color: #323D42; color: #708C69; width: 12.5%;"><small>Purok</small></th>
                <th style="background-color: #323D42; color: #6D8777; width: 12.5%;"><small>Age</small></th>
                <th style="background-color: #323D42; color: #6587A1; width: 12.5%;"><small>Date of Birth</small></th>
                <th style="background-color: #323D42; color: #567CBD; width: 12.5%;"><small>Place of Birth</small></th>
                <th style="background-color: #323D42; color: #3F778C; width: 12.5%;"><small>Civil Status</small></th>
            </tr>

        </thead>
        <tbody>
            <?php
            while ($data = mysqli_fetch_assoc($result)) {
                $fname = $data['user_fname'];
                $mname = $data['user_mname'];
                $lname = $data['user_lname'];
                $fullname = $fname . ' ' . $mname . ' ' . $lname;

                $fullname = strtolower($fullname);
                $fullname = ucwords($fullname);

                $sex = $data['user_gender'];
                $brgy = $data['user_brgy'];
                $purok = $data['user_purok'];
                $age = $data['user_age'];
                $dateOfBirth = $data['dateOfBirth'];
                $placeOfBirth = $data['placeOfBirth'];
                $civilStatus = $data['civilStatus'];
            ?>
                <tr>
                    <td><small><?php echo htmlspecialchars($fullname); ?></small></td>
                    <td><small><?php echo htmlspecialchars($sex); ?></small></td>
                    <td><small><?php echo htmlspecialchars($brgy); ?></small></td>
                    <td><small><?php echo htmlspecialchars($purok); ?></small></td>
                    <td><small><?php echo htmlspecialchars($age); ?></small></td>
                    <td><small><?php echo htmlspecialchars($dateOfBirth); ?></small></td>
                    <td><small><?php echo htmlspecialchars($placeOfBirth); ?></small></td>
                    <td><small><?php echo htmlspecialchars($civilStatus); ?></small></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>