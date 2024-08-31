 <li class="nav-item">
     <button class="btn nav-link " aria-current="page" data-bs-toggle="modal" data-bs-target="#addAdmin">Add admin account</button>
 </li>

 <!-- add admin account modal -->
 <div class="modal fade" id="addAdmin" tabindex="-1" aria-labelledby="addAdminLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <div class="w-100 text-center">
                     <h4 class="modal-title " id="addAdminLabel">Add Admin Account</h4>
                 </div>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="container p-5 modal-body">
                 <form action="municipal_includes/addSuperAdminAcc.php" method="POST">

                     <!-- Group 1: Full Name -->
                     <div id="group1" class="form-step">
                         <h4 class="h4  mb-3">Personal Information</h4>
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
                                 <button type="button" class="btn btn-primary  w-100" id="nextBtn1">
                                     Next <i class="bi bi-arrow-right-square"></i>
                                 </button>
                             </div>
                         </div>
                     </div>

                     <!-- Group 2: Sex and Address -->
                     <div id="group2" class="form-step d-none">
                         <h4 class="h4  mb-3">Personal Information</h4>
                         <div class="form-floating mb-3">
                             <select id="user_gender" name="gender" class="form-select" required>
                                 <option value="" disabled selected>Select Male or Female</option>
                                 <option value="Male">Male</option>
                                 <option value="Female">Female</option>
                             </select>
                             <label for="user_gender" class="form-label">Sex</label>
                         </div>

                         <div class="form-floating mb-3">
                             <input type="number" name="user_purok" class="form-control" id="user_purok" placeholder="Purok" required>
                             <label for="user_purok" class="form-label">Purok</label>
                         </div>

                         <div class="form-floating mb-3">
                             <input type="text" name="contactNum" class="form-control" id="contactNum" placeholder="Contact Number" required pattern="^(09\d{9}|639\d{9})$" title="(e.g., 09123456789 or 639123456789)">
                             <label for="contactNum" class="form-label">Contact Number</label>
                         </div>

                         <div class="row">
                             <div class="col-12 col-md-6 mb-2">
                                 <button type="button" class="btn btn-secondary  w-100" id="prevBtn2">
                                     <i class="bi bi-arrow-left-square"></i>
                                     Previous
                                 </button>
                             </div>
                             <div class="col-12 col-md-6">
                                 <button type="button" class="btn btn-primary  w-100" id="nextBtn2">
                                     Next <i class="bi bi-arrow-right-square"></i>
                                 </button>
                             </div>
                         </div>
                     </div>

                     <!-- Group 3: Additional Information -->
                     <div id="group3" class="form-step d-none">
                         <h4 class="h4  mb-3">Additional Information</h4>
                         <!-- Date of Birth and Place of Birth -->
                         <div class="form-floating mb-3">
                             <input id="dateOfBirth" class="form-control" type="date" name="dateOfBirth" placeholder="Date of Birth" required>
                             <label for="dateOfBirth">Date of Birth</label>
                         </div>

                         <div class="form-floating mb-3">
                             <input id="placeOfBirth" class="form-control" type="text" name="placeOfBirth" placeholder="Place of Birth" required>
                             <label for="placeOfBirth">Place of Birth</label>
                         </div>

                         <div class="form-floating mb-3">
                             <select id="civilStatus" name="civilStatus" class="form-select" required>
                                 <option value="" disabled selected>Choose Status</option>
                                 <option value="Single">Single</option>
                                 <option value="Married">Married</option>
                                 <option value="Widowed">Widowed</option>
                                 <option value="Divorced">Divorced</option>
                             </select>
                             <label for="civilStatus">Civil Status</label>
                         </div>

                         <div class="row">
                             <div class="col-12 col-md-6 mb-2">
                                 <button type="button" class="btn btn-secondary  w-100" id="prevBtn3">
                                     <i class="bi bi-arrow-left-square"></i>
                                     Previous
                                 </button>
                             </div>
                             <div class="col-12 col-md-6">
                                 <button type="button" class="btn btn-primary  w-100" id="nextBtn4">
                                     Next <i class="bi bi-arrow-right-square"></i>
                                 </button>
                             </div>
                         </div>
                     </div>

                     <!-- Group 4: Account Information -->
                     <div id="group4" class="form-step d-none">
                         <h4 class="h4  mb-3">Account Information</h4>
                         <div class="row">
                             <div class="col-12">
                                 <div class="form-floating mb-3">
                                     <input type="email" name="email" class="form-control" id="user_email" placeholder="Email Address" required title="e.g., juandelacruz143@gmail.com">
                                     <label for="user_email" class="form-label">Email Address</label>
                                 </div>
                             </div>
                             <div class="col-12">
                                 <div class="form-floating mb-3">
                                     <input type="text" name="username" class="form-control" id="username" placeholder="Username" required pattern="^[a-zA-Z]{2}[a-zA-Z0-9.@_\\-\\s]+$" title="At least three characters and more">
                                     <label for="username" class="form-label">Username</label>
                                 </div>
                             </div>
                         </div>

                         <div class="row">
                             <div class="col-12">
                                 <div class="form-floating mb-3 position-relative">
                                     <input type="password" name="signupPassword" class="form-control mb-3" id="signupPassword" placeholder="Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="At least one number, one uppercase letter, one lowercase letter, and at least 8 or more characters">
                                     <span class="icon position-absolute top-50 end-0 translate-middle-y p-3" id="signupShowPasswordIcon"><i class="bi bi-eye-slash-fill"></i></span>
                                     <label for="signupPassword" class="form-label">Password</label>
                                 </div>
                             </div>
                             <div class="col-12">
                                 <div class="form-floating mb-3 position-relative">
                                     <input type="password" name="confirmPassword" class="form-control mb-3" id="confirmPassword" placeholder="Confirm Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="At least one number, one uppercase letter, one lowercase letter, and at least 8 or more characters">
                                     <span class="icon position-absolute top-50 end-0 translate-middle-y p-3" id="confirmShowPasswordIcon"><i class="bi bi-eye-slash-fill"></i></span>
                                     <label for="confirmPassword" class="form-label">Confirm Password</label>
                                 </div>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-12 col-md-6 mb-2">
                                 <button type="button" class="btn btn-secondary  w-100" id="prevBtn4">
                                     <i class="bi bi-arrow-left-square"></i>
                                     Previous
                                 </button>
                             </div>
                             <div class="col-12 col-md-6">
                                 <button type="submit" name="btnSignup" class="btn btn-success  w-100">
                                     Save <i class="bi bi-save"></i>
                                 </button>
                             </div>
                         </div>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>



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

     $('#nextBtn4').click(function() {
         $('#group3').addClass('d-none');
         $('#group4').removeClass('d-none');
     });

     $('#prevBtn4').click(function() {
         $('#group4').addClass('d-none');
         $('#group3').removeClass('d-none');
     });


     // Function to toggle password visibility
     function togglePasswordVisibility(inputId, iconId) {
         const passwordInput = document.getElementById(inputId);
         const showPasswordIcon = document.getElementById(iconId);

         showPasswordIcon.addEventListener("click", function() {
             if (passwordInput.type === "password") {
                 passwordInput.type = "text";
                 showPasswordIcon.innerHTML = '<i class="bi bi-eye-fill"></i>';
             } else {
                 passwordInput.type = "password";
                 showPasswordIcon.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
             }
         });
     }

     // Initialize the toggle for each password field
     togglePasswordVisibility("signupPassword", "signupShowPasswordIcon");
     togglePasswordVisibility("confirmPassword", "confirmShowPasswordIcon");
 </script>