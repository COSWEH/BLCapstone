<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


<?php
include('../../includes/conn.inc.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location: ../adminPost.b.php');
    exit;
}

$admin_brgy = $_SESSION['user_brgy'];

$query = "SELECT p.post_id, p.user_id, p.post_brgy, p.post_content, p.post_img, p.post_date, u.user_brgy, u.user_fname, u.user_mname, u.user_lname
          FROM tbl_posts AS p 
          INNER JOIN tbl_useracc AS u ON p.user_id = u.user_id
          WHERE p.post_brgy = '$admin_brgy'
          ORDER BY p.post_date DESC";

$result = mysqli_query($con, $query);

if (!$result) {
    die('Error in query: ' . mysqli_error($con));
}

while ($data = mysqli_fetch_assoc($result)) {
    $postId = $data['post_id'];
    $brgy = $data['user_brgy'];
    $fullname = $data['user_fname'] . " " . $data['user_mname'] . " " . $data['user_lname'];
    $fullname = ucwords(strtolower($fullname));
    $content = $data['post_content'];
    $img = $data['post_img'];
    $getTime = $data['post_date'];

    $get_Time_And_Day = new DateTime($getTime);
?>

    <div class="card mb-3 shadow">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <img src="../img/brgyIcon.png" alt="Profile Picture" class="img-fluid rounded-circle me-2" style="width: 50px; height: 50px;">
                <?php echo "<h6 class='fw-bold'>$brgy</h6>"; ?>
                <div class="btn-group dropup ms-auto">
                    <button type="button" class="btn btn-lg" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <button type="button" class="btn btn-sm dropdown-item btnUpdatePost" data-post-id="<?php echo $postId; ?>" data-bs-toggle="modal" data-bs-target="#editPostModal">
                                Edit post
                            </button>
                        </li>
                        <li>
                            <button type="button" class="btn btn-sm dropdown-item btnDeletePost" data-post-id="<?php echo $postId; ?>" data-bs-toggle="modal" data-bs-target="#deletePostModal">
                                Delete post
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <p>
                <small class="fw-bold">
                    <?php echo $get_Time_And_Day->format('h:i A D, M j, Y'); ?>
                </small>
            </p>
            <hr>
            <div class="mb-3">
                <p id="post-text" class="post-text">
                    <?php echo $content; ?>
                </p>
            </div>
            <div class="row">
                <?php
                if (!empty($img)) {
                    $imgArray = json_decode($img, true);

                    if (is_array($imgArray)) {
                        $imgCount = count($imgArray);

                        for ($i = 0; $i < $imgCount; $i++) {
                            $imgName = $imgArray[$i];
                ?>
                            <div class="col-12 col-md-6 col-sm-3 p-2">
                                <img src="../barangay/brgy_dbImages/<?php echo htmlspecialchars($imgName); ?>" class="img-fluid rounded shadow-sm">
                            </div>
                <?php
                        }
                    } else {
                        echo "<div class='col-12 col-md-6 col-sm-3 p-2'>
                                <p class='text-danger'>Error loading images</p>
                              </div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <!-- update modal -->
    <div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="editPostModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center borde border-0">
                    <div class="w-100 text-center">
                        <h4 class="modal-title " id="editPostModalLabel">
                            Edit post
                        </h4>
                    </div>
                </div>
                <div class="modal-body">
                    <form id="updatePostForm" action="brgy_includes/updatePost.b.php" method="POST" enctype="multipart/form-data">
                        <div class="d-flex align-items-center mb-3">
                            <img src="../img/male-user.png" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 75px; height: 75px;">
                            <div>
                                <h6 class="mb-0">
                                    <?php echo $fullname; ?>
                                </h6>
                                <h6 class="text-muted mb-0">
                                    <?php echo "<small>From: Brgy. </small>" . $brgy;
                                    $_SESSION['getAdminBrgy'] = $brgy; ?>
                                </h6>
                            </div>
                        </div>
                        <div class="mb-3">
                            <textarea name="baTextContent" class="form-control" id="postContent" rows="3" placeholder="What's on your mind?"></textarea>
                        </div>
                        <div class="mb-3">
                            <div for="bgUpdatePhotos" class="rounded border bg-light-subtle text-center p-3 d-flex flex-column align-items-center justify-content-center" style="height: 150px; cursor: pointer;">
                                <i class="bi bi-images mb-2"></i>
                                <p class="m-0 ">Add Photos</p>
                                <input type="file" name="bgUpdatePhotos[]" id="bgUpdatePhotos" class="opacity-0 position-absolute" accept=".jpg, jpeg, .png" multiple>
                            </div>
                            <hr>
                            <!-- show photos from db -->
                            <input type="hidden" name="bgDbPhotos" id="bgDbPhotos">
                            <div id="dbPhotos" class="row g-2">

                            </div>
                            <hr>
                            <!-- show selected photos -->
                            <div id="selectedPhotosForUpdate" class="row g-2 mb-2">

                            </div>
                        </div>
                        <input type="hidden" id="getPostIdToUpdate" name="getPostIdToUpdate">
                        <button type="submit" name="baBtnEditPost" class="btn btn-sm btn-primary me-2">Update post</button>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- delete modal -->
    <div class="modal fade" id="deletePostModal" tabindex="-1" aria-labelledby="deletePostModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center borde border-0">
                    <div class="w-100 text-center">
                        <h4 class="modal-title" id="deletePostModalLabel">
                            Delete post
                        </h4>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="brgy_includes/deletePost.b.php" method="POST">
                        <div class="text-center mb-3">
                            <div class="mb-3">
                                <i class="bi bi-exclamation-circle" style="font-size: 100px;"></i>
                            </div>
                            <h4 class="mb-3">Are you sure?</h4>
                            <p>Once deleted, you will not be able to recover it.</p>
                        </div>
                        <div class="text-center">
                            <?php $_SESSION['getImg'] = $img; ?>
                            <input type="hidden" id="getPostIdToDelete" name="getPostIdToDelete">
                            <button type="submit" name="baBtnDeletePost" class="btn btn-primary me-2">Delete</button>
                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
}
?>

<script>
    $(document).ready(function() {
        var selectedImages = [];

        // Handle image file selection
        $('#bgUpdatePhotos').on('change', function(event) {
            const imageFiles = event.target.files;
            const $photoContainer = $('#selectedPhotosForUpdate');

            $.each(imageFiles, function(index, imageFile) {
                selectedImages.push(imageFile);

                console.log("Added image:", imageFile.name); // Log when image is added

                const imageReader = new FileReader();

                imageReader.onload = function(e) {
                    // Create a new container for the image and remove button
                    const $imageWrapper = $('<div></div>')
                        .addClass('col-12 col-md-4 position-relative');

                    const $imageElement = $('<img>')
                        .attr('src', e.target.result)
                        .addClass('img-fluid rounded shadow-sm');

                    // Create a remove button
                    const $deleteButton = $('<button></button>')
                        .addClass('btn bg-dark-subtle position-absolute top-0 end-0 m-2')
                        .html('<i class="bi bi-x"></i>');

                    // Append image and button to the wrapper
                    $imageWrapper.append($imageElement);
                    $imageWrapper.append($deleteButton);

                    // Append the wrapper to the container
                    $photoContainer.append($imageWrapper);

                    // Add event listener to the remove button
                    $deleteButton.on('click', function() {
                        $imageWrapper.remove();
                        selectedImages = selectedImages.filter(f => f !== imageFile);
                        console.log("Removed image:", imageFile.name); // Log when image is removed
                    });
                };

                imageReader.readAsDataURL(imageFile);
            });
        });

        // Handle form submission
        $('#updatePostForm').on('submit', function(event) {
            const dataTransfer = new DataTransfer();
            $.each(selectedImages, function(index, imageFile) {
                dataTransfer.items.add(imageFile);
            });
            $('#bgUpdatePhotos')[0].files = dataTransfer.files;

            console.log("Submitting form with images:", selectedImages.map(f => f.name)); // Log images before submission
        });

        // Load database photos
        function loadDbPhotos(photos) {
            const $photoContainer = $('#dbPhotos');
            if (!$photoContainer.length) {
                console.error("Element with ID 'dbPhotos' not found.");
                return;
            }

            $photoContainer.empty(); // Clear existing content

            if (Array.isArray(photos) && photos.length > 0) {
                dbPhotos = photos;

                $.each(photos, function(index, photo) {
                    if (!photo) {
                        console.error("Invalid photo:", photo);
                        return;
                    }

                    const $photoWrapper = $('<div></div>')
                        .addClass('col-12 col-md-4 position-relative');

                    const $imgElement = $('<img>')
                        .attr('src', `../barangay/brgy_dbImages/${photo}`)
                        .addClass('img-fluid rounded shadow-sm');

                    const $removeButton = $('<button></button>')
                        .addClass('btn bg-dark-subtle position-absolute top-0 end-0 m-2')
                        .html('<i class="bi bi-x"></i>');

                    $photoWrapper.append($imgElement);
                    $photoWrapper.append($removeButton);
                    $photoContainer.append($photoWrapper);

                    $removeButton.on('click', function() {
                        $photoWrapper.remove();
                        dbPhotos = dbPhotos.filter(p => p !== photo);
                        updateHiddenInput();
                        console.log("Removed image from array: ", photo);
                        console.log("Current photos array: ", dbPhotos);
                    });
                });

                updateHiddenInput();
            } else {
                const $noPhotosMessage = $('<p></p>')
                    .text("No photos available.")
                    .addClass('text-muted text-center');
                $photoContainer.append($noPhotosMessage);
            }
        }

        // Update hidden input field
        function updateHiddenInput() {
            const $bgUpdatePhotosInput = $('#bgDbPhotos');
            if (!$bgUpdatePhotosInput.length) {
                console.error("Element with ID 'bgDbPhotos' not found.");
                return;
            }
            $bgUpdatePhotosInput.val(JSON.stringify(dbPhotos));
        }

        // update post
        $(document).on('click', '.btnUpdatePost', function() {
            let p_id = $(this).data('post-id'); // Retrieve post ID from update button
            $('#getPostIdToUpdate').val(p_id);

            console.log(p_id);

            $.post('brgy_includes/getBrgyContent.php', {
                value: p_id
            }, function(data) {
                $("#postContent").html(data);
            });

            $.post('brgy_includes/getBrgyImg.php', {
                value: p_id
            }, function(data) {
                const existingPhotos = JSON.parse(data);
                loadDbPhotos(existingPhotos);
            });
        });

        //delete post
        $(document).on('click', '.btnDeletePost', function() {
            let p_id = $(this).data('post-id'); // Retrieve post ID from update button
            $('#getPostIdToDelete').val(p_id);

            console.log(p_id);

            $.post('brgy_includes/deletePost.b.php', {
                value: p_id
            });
        });
    });
</script>