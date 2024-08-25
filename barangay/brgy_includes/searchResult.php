<ul class="list-group">
    <?php
    include('../../includes/conn.inc.php');
    session_start();

    if (empty($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
        header('location: ../adminProfiling.b.php');
        exit;
    }

    if (isset($_POST['query'])) {
        $query = $_POST['query'];

        $civilian_brgy = $_SESSION['user_brgy'];

        $getUserQuery = "SELECT * FROM `tbl_useracc` WHERE (`user_fname` LIKE '%$query%' OR `user_mname` LIKE '%$query%' OR `user_lname` LIKE '%$query%') AND `user_brgy` = '$civilian_brgy'";


        $result = mysqli_query($con, $getUserQuery);

        if (!$result) {
            die('Error in query: ' . mysqli_error($con));
        }

        while ($data = mysqli_fetch_assoc($result)) {
            $fname = $data['user_fname'];
            $mname = $data['user_mname'];
            $lname = $data['user_lname'];
            $fullname = $fname . ' ' . $mname . ' ' . $lname;

            $fullname = strtolower($fullname);
            $fullname = ucwords($fullname);
    ?>

            <li class=" list-group-item">
                <?php echo $fullname; ?>
            </li>
    <?php
        }
    }
    ?>
</ul>