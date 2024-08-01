<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BayanLink</title>
    <!-- local css -->
    <link rel="stylesheet" href="indexMaterials/style.im.css">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap icon CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="#home">
                <img src="img/ourLogo.png" alt="Logo"> BAYANLINK</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 fw-bold">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#about">About</a>
                    </li>
                </ul>

                <div class="ms-auto">
                    <button type="button" class="btn btn-outline-success fw-bold" data-bs-toggle="modal" data-bs-target="#registerModal">
                        Sign up
                    </button>

                    <button type="button" class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Sign in
                    </button>

                    <button id="theme-toggle" class="btn btn-sm shadow">
                        <i class="bi bi-moon-fill" id="moon-icon"></i>
                        <i class="bi bi-brightness-high-fill" id="sun-icon" style="display:none;"></i>
                    </button>

                </div>
            </div>
        </div>
    </nav>

    <!-- Sign in Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-3 fw-bold" id="loginModalLabel">Sign In</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="signin.code.php" method="POST">
                        <h4 class="h4 fw-bold mb-3">Account Information</h4>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address*</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
                        </div>
                        <div class="mb-3">
                            <label for="signinPassword" class="form-label">Password*</label>
                            <input type="password" name="signinPassword" class="form-control" id="signinPassword" placeholder="Enter your password" required pattern=".{8,}">
                        </div>

                        <div class="row mb-3">
                            <div class="col d-flex align-items-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div>
                            </div>
                            <div class="col text-end">
                                <small>
                                    <a href="#" class="link-offset-2">Forgot Password?</a>
                                </small>
                            </div>
                        </div>
                        <hr>
                        <button type="submit" name="btnSignin" class="btn btn-primary fw-bold w-100">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sign up Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-3 fw-bold" id="registerModalLabel">Sign Up</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="signup.code.php" method="POST">
                        <h4 class="h4 fw-bold mb-3">Personal Information</h4>
                        <!-- Dropdown for San Isidro -->
                        <div class="mb-3">
                            <label for="fromSanIsidro" class="form-label">Are you from San Isidro?*</label>
                            <select id="fromSanIsidro" name="fromSanIsidro" class="form-select" required>
                                <option value="" disabled selected>Select Yes or No</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <!-- Barangay -->
                        <div class="mb-3">
                            <label for="user_brgy" class="form-label">Which Barangay are you from?*</label>
                            <select name="barangay" id="user_brgy" class="form-select" required>
                                <option value="" disabled selected>Select Barangay</option>
                                <option value="Alua">Alua</option>
                                <option value="Calaba">Calaba</option>
                                <option value="Malapit">Malapit</option>
                                <option value="Mangga">Mangga</option>
                                <option value="Poblacion">Poblacion</option>
                                <option value="Pulo">Pulo</option>
                                <option value="San Roque">San Roque</option>
                                <option value="Sto. Cristo">Sto. Cristo</option>
                                <option value="Tabon">Tabon</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>
                        <hr>

                        <!-- Full Name -->
                        <div class="row mb-3">
                            <div class="col-md-4 mb-3">
                                <label for="user_fname" class="form-label">First Name*</label>
                                <input type="text" name="fname" class="form-control" id="user_fname" placeholder="Enter your first name" required pattern="^[a-zA-Z\s\-]+$">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="user_mname" class="form-label">Middle Name*</label>
                                <input type="text" name="mname" class="form-control" id="user_mname" placeholder="Enter your middle name" pattern="^[a-zA-Z\s\-]+$">
                            </div>
                            <div class="col-md-4">
                                <label for="user_lname" class="form-label">Last Name*</label>
                                <input type="text" name="lname" class="form-control" id="user_lname" placeholder="Enter your last name" required pattern="^[a-zA-Z\s\-]+$">
                            </div>
                        </div>

                        <!-- gender -->
                        <div class="mb-3">
                            <label for="user_gender" class="form-label">Gender*</label>
                            <select id="user_gender" name="gender" class="form-select" required>
                                <option value="" disabled selected>Select Male or Female</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <!-- Address and Contact Number -->
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label for="user_address" class="form-label">Address*</label>
                                <input type="text" name="address" class="form-control" id="user_address" placeholder="Enter your address" required pattern="^[a-zA-Z0-9\s\-.,]+$">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="user_contactNum" class="form-label">Contact Number*</label>
                                <input type="text" name="contactNum" class="form-control" id="user_contactNum" placeholder="Enter your contact number" required pattern="^(09\d{9}|639\d{9})$" title="(e.g., 09123456789 or 639123456789)">
                            </div>
                        </div>
                        <hr>

                        <h4 class="h4 fw-bold mb-3">Account Information</h4>
                        <!-- Email and Username -->
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label for="user_email" class="form-label">Email*</label>
                                <input type="email" name="email" class="form-control" id="user_email" placeholder="Enter your email" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="e.g., juandelacruz143@gmail.com">
                            </div>
                            <div class="col-md-6">
                                <label for="username" class="form-label">Username*</label>
                                <input type="text" name="username" class="form-control" id="username" placeholder="Enter your username" required pattern="^[a-zA-Z]{2}[a-zA-Z0-9.@_\\-\\s]+$" title="At least three characters and more">
                            </div>
                        </div>

                        <!-- Password and Confirm Password -->
                        <div class="row mb-3">
                            <div style="position: relative" class="col-md-6 mb-3">
                                <label for="signupPassword" class="form-label">Password*</label>
                                <input type="password" name="signupPassword" class="form-control" id="signupPassword" placeholder="Enter your password" required pattern=".{8,}">
                            </div>
                            <div style="position: relative" class="col-md-6">
                                <label for="confirm-password" class="form-label">Confirm Password*</label>
                                <input type="password" name="confirmPassword" class="form-control" id="confirm-password" placeholder="Confirm your password" required pattern=".{8,}">
                            </div>
                        </div>

                        <button type="submit" name="btnSignup" class="btn btn-success fw-bold w-100">Sign up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Home Section -->
    <section id="home" class="container my-5">
        <div class="row align-items-center">
            <!-- Content Section -->
            <div class="col-md-6 text-center text-md-start mb-4 mb-md-0">
                <h1 class="display-3 fw-bold mb-3">Welcome to Bayanlink</h1>
                <p class="lead mb-4">At Bayanlink, we connect communities and simplify access to essential services. Our platform provides direct access to official information, streamlines document requests, and enhances civic engagement.</p>
                <p class="mb-4">Explore our features to see how we make your experience more efficient and engaging.</p>
                <button type="button" class="btn btn-success fw-bold" data-bs-toggle="modal" data-bs-target="#registerModal">
                    Get started
                </button>

            </div>
            <!-- Image Section -->
            <div class="col-md-6">
                <img src="img/img1.png" width="600" height="400" alt="Bayanlink Overview" class="img-fluid rounded shadow-sm">
            </div>
        </div>
        <hr>
    </section>

    <!-- Services Section -->
    <section id="services" class="container my-5">
        <h1 class="text-center mb-4">Our Services</h1>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <div class="col">
                <div class="card card-custom border shadow rounded">
                    <div class="card-header p-2 fs-4 fw-bold">Direct Access to Official Information</div>
                    <div class="card-body p-3">
                        <p class="card-text">Get direct access to the latest official information and updates.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-custom border shadow rounded">
                    <div class="card-header p-2 fs-4 fw-bold">Document Requesting and Tracking</div>
                    <div class="card-body">
                        <p class="card-text">Easily request and track documents with our streamlined process.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-custom border shadow rounded">
                    <div class="card-header p-2 fs-4 fw-bold">Enhanced Civic Engagement</div>
                    <div class="card-body">
                        <p class="card-text">Engage with your community more effectively through our platform.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-custom border shadow rounded">
                    <div class="card-header p-2 fs-4 fw-bold">Communication Channels</div>
                    <div class="card-body">
                        <p class="card-text">Access various communication channels for better interaction.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-custom border shadow rounded">
                    <div class="card-header p-2 fs-4 fw-bold">Personalized User Experience</div>
                    <div class="card-body">
                        <p class="card-text">Enjoy a personalized experience tailored to your preferences.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-custom border shadow rounded">
                    <div class="card-header p-2 fs-4 fw-bold">Accessibility and Convenience</div>
                    <div class="card-body">
                        <p class="card-text">Experience enhanced accessibility and convenience across the platform.</p>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="container my-5">
        <h1 class="text-center mb-4">Get in Touch with Us!</h1>
        <p class="text-center mb-4">If you have any inquiries and want to get in touch with us, we'll be happy to help you!</p>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="contact-card">
                    <div>
                        <h5 class="mb-1">Contact Phone Number</h5>
                        <p><i class="bi bi-telephone-fill"></i> +63 918 260 9219</p>
                        <p> <i class="bi bi-telephone-fill"></i> +63 928 669 0296</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-card">
                    <div>
                        <h5 class="mb-1">Our Email Address</h5>
                        <p><i class="bi bi-envelope-fill"></i> bayanlink@gmail.com</p>
                        <p><i class="bi bi-envelope-fill"></i> sanisidro@gmail.com</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-card">
                    <div>
                        <h5 class="mb-1">Our Location</h5>
                        <p><i class="bi bi-geo-alt-fill"></i> 8W54+QPM, Gapan-Olonga Rd, San Isidro, Nueva Ecija</p>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </section>

    <!-- About Section -->
    <section id="about" class="container my-5">
        <div class="row mb-4">
            <div class="col">
                <h1 class="text-center mb-3">About Us</h1>
                <p class="lead text-center">BayanLink is Lorem ipsum dolor sit, amet consectetur adipisicing elit. Optio eius fugit quasi sint dolorum, est nulla, similique soluta omnis cumque laborum aut quam ab assumenda?</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col">
                <h1 class="text-center mb-3">Our Mission</h1>
                <p class="lead text-center">BayanLink is Lorem ipsum dolor sit, amet consectetur adipisicing elit. Optio eius fugit quasi sint dolorum, est nulla, similique soluta omnis cumque laborum aut quam ab assumenda?</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <h1 class="text-center mb-3">Our Amazing Team</h1>
                <div class="row g-4">
                    <div class="col-md-3 text-center">
                        <img src="img/p1.png" alt="Yvez Santiago" class="img-fluid rounded-circle mb-2" style="width: 100px; height: 100px;">
                        <h6>Yvez Santiago</h6>
                        <p class="text-muted">Front-end Developer</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="img/p2.png" alt="Kevin Palma" class="img-fluid rounded-circle mb-2" style="width: 100px; height: 100px;">
                        <h6>Kevin Palma</h6>
                        <p class="text-muted">UI/UX Designer</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="img/p3.png" alt="Vincent Bernardino" class="img-fluid rounded-circle mb-2" style="width: 100px; height: 100px;">
                        <h6>Vincent Bernardino</h6>
                        <p class="text-muted">Operations Manager</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="img/p4.png" alt="Paolo Ramos" class="img-fluid rounded-circle mb-2" style="width: 100px; height: 100px;">
                        <h6>Paolo Ramos</h6>
                        <p class="text-muted">Back-end Developer</p>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <div class="row mt-5">
            <div class="col">
                <h1 class="text-center mb-3">Frequently Asked Questions</h1>
                <p class="text-center">Content to be added.</p>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-dark text-white text-center py-4">
        <hr>
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-4 mb-2 mb-md-0">
                    <h5>About Us</h5>
                    <p>Learn more about our mission and vision, and how we strive to connect communities and simplify access to essential services.</p>
                </div>
                <div class="col-md-4 mb-2 mb-md-0">
                    <h5>Contact Us</h5>
                    <p><i class="bi bi-telephone-fill"></i> +63 918 260 9219</p>
                    <p><i class="bi bi-envelope-fill"></i> bayanlink@gmail.com</p>
                </div>
                <div class="col-md-4 mb-2 mb-md-0">
                    <h5>Follow Us</h5>
                    <a href="#" class="text-white me-2"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white me-2"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
            <div class="pt-3">
                <p class="mb-0">&copy; <span id="current-year"></span> BayanLink. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="indexMaterials/script.im.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php
if (isset($_SESSION['signin_error_message'])) {
    echo '<script>
            Swal.fire({
                title: "Error",
                text: "' . $_SESSION['signin_error_message'] . '",
                icon: "warning",
            });
        </script>';
    unset($_SESSION['signin_error_message']);
}

if (isset($_SESSION['signup_error_message'])) {
    echo '<script>
            Swal.fire({
                title: "Error",
                text: "' . $_SESSION['signup_error_message'] . '",
                icon: "error",
            });
        </script>';
    unset($_SESSION['signup_error_message']);
}

if (isset($_SESSION['signup_success_message'])) {
    echo '<script>
            Swal.fire({
                title: "Done",
                text: "' . $_SESSION['signup_success_message'] . '",
                icon: "success",
            });
        </script>';
    unset($_SESSION['signup_success_message']);
}
?>

</html>