 <li class="nav-item">
     <button class="btn nav-link fw-bold" aria-current="page" data-bs-toggle="modal" data-bs-target="#addAdmin">Add super admin account</button>
 </li>

 <!-- add admin account modal -->
 <div class="modal fade" id="addAdmin" tabindex="-1" aria-labelledby="addAdminLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <div class="w-100 text-center">
                     <h4 class="modal-title fw-bold" id="addAdminLabel">Add Super Admin Account</h4>
                 </div>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="container p-5 modal-body">
                 <form action="municipal_includes/addSuperAdminAcc.php" method="POST">

                     <!-- Group 1: Full Name -->
                     <div id="group1" class="form-step">
                         <h4 class="h4 fw-bold mb-3">Personal Information</h4>
                         <div class="form-floating mb-3">
                             <input type="text" name="fname" class="form-control" id="user_fname" placeholder="First Name" required pattern="^[a-zA-Z\s\-]+$">
                             <label for="user_fname" class="form-label">First Name</label>
                         </div>
                         <div class="form-floating mb-3">
                             <input type="text" name="mname" class="form-control" id="user_mname" placeholder="Middle Name" pattern="^[a-zA-Z\s\-]+$">
                             <label for="user_mname" class="form-label">Middle Name</label>
                         </div>

                         <div class="form-floating mb-3">
                             <input type="text" name="lname" class="form-control" id="user_lname" placeholder="Last Name" required pattern="^[a-zA-Z\s\-]+$">
                             <label for="user_lname" class="form-label">Last Name</label>
                         </div>

                         <div class="row">
                             <div class="col-12">
                                 <button type="button" class="btn btn-primary fw-bold w-100" id="nextBtn1">
                                     Next <i class="bi bi-arrow-right-square"></i>
                                 </button>
                             </div>
                         </div>
                     </div>

                     <!-- Group 2: Gender and Address -->
                     <div id="group2" class="form-step d-none">
                         <h4 class="h4 fw-bold mb-3">Personal Information</h4>
                         <div class="form-floating mb-3">
                             <select id="user_gender" name="gender" class="form-select" required>
                                 <option value="" disabled selected>Select Male or Female</option>
                                 <option value="Male">Male</option>
                                 <option value="Female">Female</option>
                             </select>
                             <label for="user_gender" class="form-label">Gender</label>
                         </div>

                         <div class="form-floating mb-3">
                             <input type="text" name="address" class="form-control" id="user_address" placeholder="Address" required pattern="^[a-zA-Z0-9\s\-.,]+$">
                             <label for="user_address" class="form-label">Address</label>
                         </div>

                         <div class="form-floating mb-3">
                             <input type="text" name="contactNum" class="form-control" id="contactNum" placeholder="Contact Number" required pattern="^(09\d{9}|639\d{9})$" title="(e.g., 09123456789 or 639123456789)">
                             <label for="contactNum" class="form-label">Contact Number</label>
                         </div>

                         <div class="row">
                             <div class="col-12 col-md-6 mb-2">
                                 <button type="button" class="btn btn-secondary fw-bold w-100" id="prevBtn2">
                                     <i class="bi bi-arrow-left-square"></i>
                                     Previous
                                 </button>
                             </div>
                             <div class="col-12 col-md-6">
                                 <button type="button" class="btn btn-primary fw-bold w-100" id="nextBtn2">
                                     Next <i class="bi bi-arrow-right-square"></i>
                                 </button>
                             </div>
                         </div>
                     </div>

                     <!-- Group 3: Account Information -->
                     <div id="group3" class="form-step d-none">
                         <h4 class="h4 fw-bold mb-3">Account Information</h4>
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="form-floating mb-3">
                                     <input type="email" name="email" class="form-control" id="user_email" placeholder="Email Address" required title="e.g., juandelacruz143@gmail.com">
                                     <label for="user_email" class="form-label">Email Address</label>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-floating mb-3">
                                     <input type="text" name="username" class="form-control" id="username" placeholder="Username" required pattern="^[a-zA-Z]{2}[a-zA-Z0-9.@_\\-\\s]+$" title="At least three characters and more">
                                     <label for="username" class="form-label">Username</label>
                                 </div>
                             </div>
                         </div>

                         <div class="row">
                             <div class="col-md-6">
                                 <div class="form-floating mb-3">
                                     <input type="password" name="signupPassword" class="form-control mb-3" id="signupPassword" placeholder="Password" required pattern=".{8,}">
                                     <label for="signupPassword" class="form-label">Password</label>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-floating mb-3">
                                     <input type="password" name="confirmPassword" class="form-control mb-3" id="confirm-password" placeholder="Confirm Password" required pattern=".{8,}">
                                     <label for="confirm-password" class="form-label">Confirm Password</label>
                                 </div>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-12 col-md-6 mb-2">
                                 <button type="button" class="btn btn-secondary fw-bold w-100" id="prevBtn3">
                                     <i class="bi bi-arrow-left-square"></i>
                                     Previous
                                 </button>
                             </div>
                             <div class="col-12 col-md-6">
                                 <button type="submit" name="btnSignup" class="btn btn-success fw-bold w-100">
                                     Sign up
                                     <i class="bi bi-hand-index-thumb"></i>
                                 </button>
                             </div>
                         </div>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <?php
    if (isset($_SESSION['addAdmin_error_message'])) {
    ?>
     <script>
         Swal.fire({
             title: "Error",
             text: "<?php echo $_SESSION['addAdmin_error_message']; ?>",
             icon: "error",
         });
     </script>
 <?php
        unset($_SESSION['addAdmin_error_message']);
    }

    if (isset($_SESSION['addAdmin_success_message'])) {
    ?>
     <script>
         Swal.fire({
             title: "Done",
             text: "<?php echo $_SESSION['addAdmin_success_message']; ?>",
             icon: "success",
         });
     </script>
 <?php
        unset($_SESSION['addAdmin_success_message']);
    }

    ?>

 <script>
     // get admin info
     $('#nextBtn1').click(function() {
         $('#group1').addClass('d-none');
         $('#group2').removeClass('d-none');
     });

     $('#prevBtn2').click(function() {
         $('#group2').addClass('d-none');
         $('#group1').removeClass('d-none');
     });

     $('#nextBtn2').click(function() {
         $('#group2').addClass('d-none');
         $('#group3').removeClass('d-none');
     });

     $('#prevBtn3').click(function() {
         $('#group3').addClass('d-none');
         $('#group2').removeClass('d-none');
     });
 </script>