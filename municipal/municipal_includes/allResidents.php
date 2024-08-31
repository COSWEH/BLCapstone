<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location: ../superAdminProfiling.m.php');
    exit;
}

$superAdminLoc = $_SESSION['user_city'];

$getUserQuery = "SELECT * FROM `tbl_useracc` WHERE `user_city` = '$superAdminLoc' AND `role_id` != 2";
$result = mysqli_query($con, $getUserQuery);

if (!$result) {
    die('Error in query: ' . mysqli_error($con));
}
?>

<div class="table-responsive ">
    <table class="table table-responsive table-bordered border border-3 table-hover text-center text-capitalized">
        <thead class="table-active text-uppercase text-white">
            <tr>
                <th class="text-light" style="background-color: #ee7ea0;"><small>Full Name</small></th>
                <th class="text-light" style="background-color: #ffaf6e;"><small>Sex</small></th>
                <th class="text-light" style="background-color: #7d8be0;"><small>Barangay</small></th>
                <th class="text-light" style="background-color: #9a81b0;"><small>Purok</small></th>
                <th class="text-light bg-dark"><small>Age</small></th>
                <th class="text-light" style="background-color: #ffaf6e;"><small>Date of Birth</small></th>
                <th class="text-light" style="background-color: #ffaf6e;"><small>Place of Birth</small></th>
                <th class="text-light" style="background-color: #ffaf6e;"><small>Civil Status</small></th>
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