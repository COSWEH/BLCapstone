<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id'])) {
    header('location: ../superAdminPost.m.php');
    exit;
}

$query = "SELECT * FROM `tbl_logs` ORDER BY `log_date` DESC";

$query = "SELECT l.log_id, l.user_id, l.log_desc, l.log_date, u.user_fname, u.user_mname, u.user_lname, u.username 
          FROM tbl_logs AS l
          INNER JOIN tbl_useracc AS u ON l.user_id = u.user_id
          ORDER BY l.log_date DESC";


$result = mysqli_query($con, $query);

if (!$result) {
    die('Error in query: ' . mysqli_error($con));
}

$rowCount = mysqli_num_rows($result);
if ($rowCount == 0) {
    echo "<p>No logs found.</p>";
} else {
?>
    <div class="table-responsive">
        <table class="table align-middle table-hover text-center text-capitalized">
            <thead class="table-active text-uppercase text-white">
                <tr>
                    <th><small>Log ID</small></th>
                    <th><small>User ID</small></th>
                    <th><small>Username </small></th>
                    <th><small>Log Date</small></th>
                    <th><small>Log Time</small></th>
                    <th><small>Log Description</small></th>
                </tr>

            </thead>
            <tbody>
                <?php
                while ($data = mysqli_fetch_assoc($result)) {
                    // Fetch data from tbl_requests
                    $log_id = $data['log_id'];
                    $user_id = $data['user_id'];
                    $username = $data['username'];
                    $log_desc = $data['log_desc'];
                    $log_date = $data['log_date'];

                    // Separate date and time
                    $get_Time_And_Day = new DateTime($log_date);
                    $formattedDate = $get_Time_And_Day->format('Y-m-d');  // Only date
                    $formattedTime = $get_Time_And_Day->format('h:i:s A');  // Only time
                ?>
                    <tr>
                        <td><small><?php echo htmlspecialchars($log_id); ?></small></td>
                        <td><small><?php echo htmlspecialchars($user_id); ?></small></td>
                        <td><small><?php echo htmlspecialchars($username); ?></small></td>
                        <td><small><?php echo htmlspecialchars($formattedDate); ?></small></td>
                        <td><small><?php echo htmlspecialchars($formattedTime); ?></small></td>
                        <td><small><?php echo htmlspecialchars($log_desc); ?></small></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>


<?php
}
?>