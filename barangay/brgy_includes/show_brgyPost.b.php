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
                            <button class="btn btn-sm dropdown-item edit-post" data-post-id="<?php echo $postId; ?>" data-bs-toggle="modal" data-bs-target="#editPostModal">
                                Edit post
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-sm dropdown-item">Delete post</button>
                        </li>
                    </ul>
                </div>
            </div>
            <p>
                <small class="fw-bold">
                    <?php echo $get_Time_And_Day->format('h:i A D'); ?>
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
                <div class="modal-header text-center">
                    <div class="w-100 text-center">
                        <h4 class="modal-title fw-bold" id="editPostModalLabel">
                            Edit post
                        </h4>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                    <?php echo "<small class='fw-bold'>From: Brgy. </small>" . $brgy;
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
                                <p class="m-0 fw-bold">Add Photos</p>
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
                        <input type="hidden" id="epost_idd" name="getPostId">
                        <button type="submit" name="baBtnEditPost" class="btn btn-sm btn-primary me-2">Save changes</button>
                        <button type="button" class="btn btn-sm btn-warning" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php
}
?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    var selectedImages = [];

    document.getElementById("bgUpdatePhotos").addEventListener("change", function(event) {
        const imageFiles = event.target.files;
        const photoContainer = document.getElementById("selectedPhotosForUpdate");

        for (let i = 0; i < imageFiles.length; i++) {
            const imageFile = imageFiles[i];
            selectedImages.push(imageFile);

            console.log("Added image:", imageFile.name); // Log when image is added

            const imageReader = new FileReader();

            imageReader.onload = function(e) {
                // Create a new container for the image and remove button
                const imageWrapper = document.createElement("div");
                imageWrapper.classList.add("col-12", "col-md-4", "position-relative");

                const imageElement = document.createElement("img");
                imageElement.src = e.target.result;
                imageElement.classList.add("img-fluid", "rounded", "shadow-sm");

                // Create a remove button
                const deleteButton = document.createElement("button");
                deleteButton.classList.add(
                    "btn",
                    "bg-dark-subtle",
                    "position-absolute",
                    "top-0",
                    "end-0",
                    "m-2"
                );
                deleteButton.innerHTML = '<i class="bi bi-x"></i>';
                // Append image and button to the wrapper
                imageWrapper.appendChild(imageElement);
                imageWrapper.appendChild(deleteButton);
                // Append the wrapper to the container
                photoContainer.appendChild(imageWrapper);
                // Add event listener to the remove button
                deleteButton.addEventListener("click", function() {
                    photoContainer.removeChild(imageWrapper);
                    selectedImages = selectedImages.filter(f => f !== imageFile);
                    console.log("Removed image:", imageFile.name); // Log when image is removed
                });
            };

            imageReader.readAsDataURL(imageFile);
        }
    });


    document.getElementById("updatePostForm").addEventListener("submit", function(event) {
        const dataTransfer = new DataTransfer();
        selectedImages.forEach(imageFile => dataTransfer.items.add(imageFile));
        document.getElementById("bgUpdatePhotos").files = dataTransfer.files;

        console.log("Submitting form with images:", selectedImages.map(f => f.name)); // Log images before submission
    });


    var dbPhotos = [];

    function loadDbPhotos(photos) {
        const photoContainer = document.getElementById("dbPhotos");
        if (!photoContainer) {
            console.error("Element with ID 'dbPhotos' not found.");
            return;
        }

        photoContainer.innerHTML = ''; // Clear existing content

        if (Array.isArray(photos) && photos.length > 0) {
            dbPhotos = photos;

            photos.forEach(photo => {
                if (!photo) {
                    console.error("Invalid photo:", photo);
                    return;
                }

                const photoWrapper = document.createElement("div");
                photoWrapper.classList.add("col-12", "col-md-4", "position-relative");

                const imgElement = document.createElement("img");
                imgElement.src = `../barangay/brgy_dbImages/${photo}`;
                imgElement.classList.add("img-fluid", "rounded", "shadow-sm");

                const removeButton = document.createElement("button");
                removeButton.classList.add("btn", "bg-dark-subtle", "position-absolute", "top-0", "end-0", "m-2");
                removeButton.innerHTML = '<i class="bi bi-x"></i>';

                photoWrapper.appendChild(imgElement);
                photoWrapper.appendChild(removeButton);
                photoContainer.appendChild(photoWrapper);

                removeButton.addEventListener("click", function() {
                    photoContainer.removeChild(photoWrapper);
                    dbPhotos = dbPhotos.filter(p => p !== photo);
                    updateHiddenInput();
                    console.log("Removed image from array: ", photo);
                    console.log("Current photos array: ", dbPhotos);
                });
            });

            updateHiddenInput();
        } else {
            const noPhotosMessage = document.createElement("p");
            noPhotosMessage.textContent = "No photos available.";
            noPhotosMessage.classList.add("text-muted", "text-center");
            photoContainer.appendChild(noPhotosMessage);
        }
    }

    function updateHiddenInput() {
        const bgUpdatePhotosInput = document.getElementById("bgDbPhotos");
        if (!bgUpdatePhotosInput) {
            console.error("Element with ID 'bgDbPhotos' not found.");
            return;
        }
        bgUpdatePhotosInput.value = JSON.stringify(dbPhotos);
    }


    $(document).ready(function() {
        $(document).on('click', '.edit-post', function() {
            let p_id = $(this).data('post-id'); // Retrieve post ID from data attribute
            console.log(p_id); // Print post id
            $('#epost_idd').val(p_id);

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
    });
</script>