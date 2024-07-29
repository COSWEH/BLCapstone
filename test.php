<?php
// Database connection
// $conn = mysqli_connect('localhost', 'root', '', 'test1');

// Check connection
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }

// Query to fetch all post details along with pictures and user
// $sql = "
//     SELECT
//         p.post_id,
//         p.post_content,
//         u.username,
//         pic.picture_url
//     FROM
//         tbl_post p
//     JOIN
//         tbl_useracc u ON p.useracc_id = u.useracc_id
//     LEFT JOIN
//         tbl_picture pic ON p.post_id = pic.post_id
// ";

// // Execute query
// $result = mysqli_query($conn, $sql);

// // Check if the query was successful
// if (!$result) {
//     die("Query failed: " . mysqli_error($conn));
// }

// // Array to hold posts and their pictures
// $posts = [];

// // Fetch results
// while ($row = mysqli_fetch_assoc($result)) {
//     $post_id = $row['post_id'];

//     // Initialize post entry if not already set
//     if (!isset($posts[$post_id])) {
//         $posts[$post_id] = [
//             'post_content' => htmlspecialchars($row['post_content']),
//             'username' => htmlspecialchars($row['username']),
//             'pictures' => []
//         ];
//     }

//     // Add picture URL to the post
//     if ($row['picture_url']) {
//         $posts[$post_id]['pictures'][] = htmlspecialchars($row['picture_url']);
//     }
// }

// // Display posts
// foreach ($posts as $post_id => $post) {
//     echo "<h2>Post by " . $post['username'] . "</h2>";
//     echo "<p>" . $post['post_content'] . "</p>";

//     // Display all pictures for the post
//     if (!empty($post['pictures'])) {
//         foreach ($post['pictures'] as $picture_url) {
//             echo "<img src='" . $picture_url . "' alt='Post Picture' style='max-width: 100%; height: auto;'>";
//         }
//     }

//     echo "<hr>"; // Adds a horizontal line between posts for clarity
// }

// // Close connection
// mysqli_free_result($result);
// mysqli_close($conn);
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Modal Example</title>
    <!-- Bootstrap CSS -->
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap icon CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<style>
    .upload-card {
        border: 2px dashed #dee2e6;
        background-color: #f8f9fa;
        cursor: pointer;
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .upload-card i {
        font-size: 2rem;
    }

    .upload-card input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
</style>


<body>

    <!-- Create Post Button -->
    <div class="card mb-3 shadow p-3">
        <div class="d-flex align-items-center mb-3">
            <!-- Profile Image -->
            <img src="../img/p1.png" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 75px; height: 75px;">
            <!-- Create a Post Button -->
            <button type="button" class="btn btn-primary ms-3 rounded-5" data-bs-toggle="modal" data-bs-target="#postModal">
                Create a Post
            </button>
        </div>
        <hr>

        <!-- show text content, full name of user who post, barangay name, and the photos picked-->
        <div>

        </div>
    </div>

    <!-- Modal -->
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
                    <form>
                        <div class="d-flex align-items-center mb-3">
                            <img src="img/p1.png" alt="Profile Picture" class="img-fluid rounded-circle me-2" style="width: 75px; height: 75px;">
                            <div>
                                <h6 class="mb-0">Paolo Marvel Ramos</h6>
                                <h6 class="text-muted mb-0">Barangay Name</h6>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input class="form-control" placeholder="Title">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" id="postContent" rows="3" placeholder="What's on your mind?"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="fileInput" class="upload-card rounded border bg-light text-center p-4 d-flex align-items-center justify-content-center">
                                <i class="bi bi-images me-2"></i>
                                <p class="m-0 fw-bold">Add Photos</p>
                                <input type="file" id="fileInput" accept="image/*" multiple>
                            </label>
                            <hr>
                            <!-- Show selected photos with equal layout -->
                            <div id="selectedPhotos" class="row g-2">
                                <!-- Selected photos will be added here -->
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary w-100">Post</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('fileInput').addEventListener('change', function(event) {
            const files = event.target.files;
            const photoContainer = document.getElementById('selectedPhotos');

            // Clear existing photos
            photoContainer.innerHTML = '';

            // Loop through each selected file
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Create a new container for the image and remove button
                    const photoWrapper = document.createElement('div');
                    photoWrapper.classList.add('col-12', 'col-md-4', 'position-relative');

                    const imgElement = document.createElement('img');
                    imgElement.src = e.target.result;
                    imgElement.classList.add('img-fluid', 'rounded', 'shadow-sm');

                    // Create a remove button
                    const removeButton = document.createElement('button');
                    removeButton.classList.add('btn', 'bg-dark-subtle', 'position-absolute', 'top-0', 'end-0', 'm-2');
                    removeButton.innerHTML = '<i class="bi bi-x"></i>';

                    // Append image and button to the wrapper
                    photoWrapper.appendChild(imgElement);
                    photoWrapper.appendChild(removeButton);

                    // Append the wrapper to the container
                    photoContainer.appendChild(photoWrapper);

                    // Add event listener to the remove button
                    removeButton.addEventListener('click', function() {
                        photoContainer.removeChild(photoWrapper);
                    });
                };

                reader.readAsDataURL(file);
            }
        });
    </script>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>