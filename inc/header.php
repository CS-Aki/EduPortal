<!-- HEADER -->
<nav class="navbar navbar-expand-lg bg-white shadow-lg px-lg-3 py-lg-3 z-3">
    <div class="container-fluid">
        <a class="navbar-brand h-font me-5 ms-3 fw-bold fs-3 pt-1" href="#"><img src="images/combined-fixed.png" class="logo" alt="logo"></a>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="ms-auto d-flex">
                <ul class="navbar-nav mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link green1 active me-2 h-font" aria-current="page" href="rooms.php">Contacts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link green1 active me-4 h-font" aria-current="page" href="facilities.php">About Us</a>
                    </li>
                </ul>
                <button type="button" class="btn  green shadow-none me-lg-2 me-3 rounded-5 px-4" data-bs-toggle="modal" data-bs-target="#signUpModal">
                    Sign Up
                </button>
                <button type="button" class="btn  green shadow-none me-lg-2 me-3 rounded-5 px-4" data-bs-toggle="modal" data-bs-target="#signInModal">
                    Sign In
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Sign Up Modal -->
<div class="modal fade" id="signUpModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md w-70">
        <div class="modal-content rounded-pill p-2">
            <div class="modal-body">
                <div class="container-fluid mb-3 d-flex justify-content-between align-items-center">
                    <h1 class="modal-title fs-1 h-font" id="staticBackdropLabel">Sign Up</h1>
                    <button type="button" id="close_btn" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <form action="log and reg backend/includes/register.inc.php" class="row g-3 needs-validation" novalidate method="post" id="signUpForm">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 mb-1">
                                <label class="form-label black2 mb-0 ">First Name</label>
                                <input type="text" class="form-control black2 shadow-sm" placeholder="Enter First Name" name="firstName" id="first_name" required value="<?php if (isset($_SESSION['google_name'])) {
                                                                                                                                                                                echo $_SESSION['google_name'];
                                                                                                                                                                            } ?>">
                            </div>
                            <div class="col-12 mb-1">
                                <label class="form-label black2 mb-0">Last Name</label>
                                <input type="text" class="form-control black2 shadow-sm" placeholder="Enter Last Name" name="lastName" id="last_name" required>
                            </div>
                            <div class="col-12 mb-1">
                                <label class="form-label black2 mb-0">Email</label>
                                <input type="email" class="form-control black2 shadow-sm" placeholder="Enter Email" name="email" id="email" required value="<?php if (isset($_SESSION['google_email'])) {
                                                                                                                                                                echo $_SESSION['google_email'];
                                                                                                                                                            } ?>">
                            </div>
                            <div class="col-12 mb-1">
                                <label class="form-label black2 mb-0">Password</label>
                                <input type="password" class="form-control black2 shadow-sm" placeholder="Enter Password" name="password" id="password" required>
                            </div>
                            <div class="col-12 mb-1">
                                <label class="form-label black2 mb-0">Confirm Password</label>
                                <input type="password" class="form-control black2 shadow-sm" placeholder="Re-Enter Password" name="repeatPass" id="repeat_pass" required>
                            </div>
                            <div class="col-12 d-flex justify-content-center align-content-center mt-3">
                                <p class="black3">Already have an account?</p> <a data-target="#signInModal" data-bs-toggle="modal" href="#signInModal" class="green2 fs-6 ms-2" id="goSignIn">Sign in</a>
                            </div>
                            <div class="justify-content-center">
                                <button type="submit" name="registerBtn" id="register_btn" class="w-100 btn green shadow-none rounded-5 px-5 py-2">Sign Up</button>
                            </div>

                            <div class="col-12 mb-1 d-flex justify-content-center align-items-center">
                                <div class="w-25 line"></div>
                                <p class="black3 mx-3 mt-1">or</p>
                                <div class="w-25 line"></div>
                            </div>

                            <div class="justify-content-center">
                                <a href="google-oauth.php" class="google-login-btn"><button type="button" class="w-100 btn green shadow-none rounded-5 px-5 py-2"><i class="bi bi-google me-2" hidden></i>Continue with Google</button></a>
                            </div>

                            <br>                                                                                                                                
                            <p class="sign-up-msg"></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Sign In Modal -->
<div class="modal fade" id="signInModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md w-70">
        <div class="modal-content rounded-pill p-2">
            <div class="modal-body">
                <div class="container-fluid mb-3 d-flex justify-content-between align-items-center">
                    <h1 class="modal-title fs-1 h-font" id="staticBackdropLabel">Sign In</h1>
                    <button type="button" class="btn-close" id="close_modal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="log and reg backend/includes/login.inc.php" class="row g-3 needs-validation" novalidate method="post" id="signInForm">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 mb-1">
                                <label class="form-label black2 mb-0 ">Email</label>
                                <input type="email" class="form-control black2 shadow-sm" placeholder="" name="email" id="email1" required>
                            </div>

                            <div class="col-12 mb-1">
                                <label class="form-label black2 mb-0">Password</label>
                                <input type="password" class="form-control black2 shadow-sm" placeholder="" name="password" id="password1" required>
                            </div>
                            <div class="col-12 d-flex justify-content-center align-content-center mt-3">
                                <p class="black3">Don't have an account?</p> <a data-target="#signUpModal" data-bs-toggle="modal" href="#signUpModal" class="green2 fs-6 ms-2" id="goSignUp">Sign Up</a>
                            </div>
                            <div class="justify-content-center">
                                <button type="submit" name="loginBtn" class="w-100 btn green shadow-none rounded-5 px-5 py-2" id="login_btn">Sign In</button>
                            </div>
                            <div class="col-12 mb-1 d-flex justify-content-center align-items-center">
                                <div class="w-25 line"></div>
                                <p class="black3 mx-3 mt-1">or</p>
                                <div class="w-25 line"></div>
                            </div>
                            <div class="justify-content-center">
                                <a href="google-oauth.php" class="google-login-btn"><button type="button" class="w-100 btn green shadow-none rounded-5 px-5 py-2"><i class="bi bi-google me-2"></i>Continue with Google</button></a>
                                <div class="position-relative">
                                    <div class="position-absolute bottom-50 end-0"></div>
                                </div>
                                <br>
                            </div>
                            <p class="form-message"></p>

                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Message Modal -->
<div class="modal fade" id="msgModal" tabindex="-1" aria-labelledby="msgModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="Label">Registration Message</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <?php if (isset($_GET["error"])) {
                    $error = "";
                    switch ($_GET["error"]) {
                        case "userAlreadyRegistered":
                            $error = "User Already Registered !!!";
                            break;
                        case "passwordMismatch":
                            $error = "Password Mismatch !!!";
                            break;
                        case "invalidNameInput":
                            $error = "Special Characters aren't allowed in name !!!";
                            break;
                        case "emptyInput":
                            $error = "Fill out All Information !!!";
                            break;
                    } ?>

                    <div class="alert alert-danger" role="alert">
                        <div class="justify-content-center"><label><?php echo $error; ?></label></div>
                    </div>

                <?php } else { ?>

                    <div class="alert alert-success" role="alert">
                        <div class="justify-content-center"><label>Registration Success !!!</label></div>
                    </div>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {

                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>