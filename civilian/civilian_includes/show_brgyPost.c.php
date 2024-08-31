<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id'])) {
    header('location: ../post.c.php');
    exit;
}

$civilian_brgy = $_SESSION['user_brgy'];

$query = "SELECT p.post_id, p.user_id, p.post_brgy, p.post_content, p.post_img, p.post_date
          FROM tbl_posts AS p
          WHERE p.post_brgy = '$civilian_brgy'
          ORDER BY p.post_date DESC";

$result = mysqli_query($con, $query);

if (!$result) {
    die('Error in query: ' . mysqli_error($con));
}

while ($data = mysqli_fetch_assoc($result)) {
    // $postId = $data['post_id'];
    $brgy = $data['post_brgy'];
    $content = $data['post_content'];
    $img = $data['post_img'];
    $getTime = $data['post_date'];

    $get_Time_And_Day = new DateTime($getTime);
?>

    <div class="card mb-3 shadow">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <img src="../img/brgyIcon.png" alt="Profile Picture" class="img-fluid rounded-circle me-2" style="width: 50px; height: 50px;">
                <?php echo "<h6>$brgy</h6>"; ?>
            </div>
            <p>
                <small>
                    <?php echo $get_Time_And_Day->format('h:i A D, M j, Y'); ?>
                </small>
            </p>
            <hr>
            <div class="mb-3">
                <p id="post-text" class="post-text">
                    <?php echo $content; ?>
                </p>
                <!-- <button id="see-more-btn" class="btn btn-link p-0">See more</button> -->
            </div>
            <!-- if user add photo and get it from database -->
            <div class="row">
                <?php
                if (!empty($img)) {
                    $imgArray = json_decode($img, true);

                    // Ensure $imgArray is an array before calling count()
                    if (is_array($imgArray)) {
                        // Get the count of images
                        $imgCount = count($imgArray);

                        for ($i = 0; $i < $imgCount; $i++) {
                            // Get the image name from the array
                            $imgName = $imgArray[$i];
                ?>
                            <div class="col-12 col-md-6 col-sm-3 p-2">
                                <img src="../barangay/brgy_dbImages/<?php echo htmlspecialchars($imgName); ?>" class="img-fluid rounded shadow-sm">
                            </div>
                <?php
                        }
                    } else {
                        // Handle the case where $imgArray is not an array
                        echo "<div class='col-12 col-md-6 col-sm-3 p-2'>
                <p class='text-danger'>Error loading images</p>
              </div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
<?php
}
?>