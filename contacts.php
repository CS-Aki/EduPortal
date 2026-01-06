<?php
require_once("log and reg backend/classes/connection.php");
require_once("log and reg backend/classes/model.User.php");
require_once("log and reg backend/classes/controller.Login.php");
require_once("log and reg backend/classes/controller.Register.php");
require_once("log and reg backend/classes/view.User.php");

if (session_id() === "") session_start();



if(isset($_SESSION["user_category"])){
    $category = $_SESSION["user_category"];
    switch($category){
        case 1: header("Location: admin/admin-dashboard.php"); break;
        case 2: header("Location: staff/staff-dashboard.php"); break;
        case 3: header("Location: instructor/instructor-dashboard.php"); break;
        case 4: header("Location: student/student-dashboard.php"); break;
    }
}

$showModal = false;
$gmailReg = false;
$regMsg = false;

if (isset($_SESSION["signIn"])) {
    unset($_SESSION["signIn"]);
    $showModal = true;
}

if (isset($_SESSION["signUp"])) {
    unset($_SESSION["signUp"]);
    $gmailReg = true;
}

if (isset($_SESSION["regMsg"])) {
    unset($_SESSION["regMsg"]);
    $regMsg = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="scripts/sign-in.js"></script>
    <script src="scripts/sign-up.js"></script>

    <?php require('inc/links.php'); ?>
    <style>
        .carousel-container {
            height: 600px;
            position: relative;
            overflow: hidden;
        }

        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            
        }

    </style>
</head>

<body>

    <?php include("inc/header.php") ?>
    <div class="container-fluid mb-3 px-5">
        <div class="container-fluid px-5 py-5 mt-4 bg-white shadow-elevation-light-3 rounded-4">
            <h1 class="h-font fs-1 green1 me-2 sub-title mb-0 text-start mb-2">Contact Us</h1>
            <div class="row">
                <div class="col-lg-6 px-lg-4">
                    <div style="width: 90%;">
                        <div class="mb-2">
                            <h1 class="h-font fs-4 green1 me-2 sub-title mb-0 text-start mb-1">Address</h1>
                            <p class="black3 lh-sm fs-5 ">
                                Biglang Awa Street Cor 11th Ave Catleya, Caloocan 1400 Metro Manila, Philippines                    
                            </p>
                        </div> 
                        <div class="mb-2">
                            <h1 class="h-font fs-4 green1 me-2 sub-title mb-0 text-start mb-1">Google Maps</h1>
                            <p class="black3 lh-sm fs-5 ">
                                <a href="https://maps.app.goo.gl/SvPYdagYPN6ngf1J8" class="black3 fs-5 text-truncate link">https://maps.app.goo.gl/SvPYdagYPN6ngf1J8</a>                   
                            </p>
                        </div>  
                        <div class="mb-3">
                            <h1 class="h-font fs-4 green1 me-2 sub-title mb-0 text-start mb-1">Phone Number</h1>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-telephone-fill green1 fs-5 p-0 m-0 me-2 "></i>
                                <p class="black3 lh-sm fs-5 mb-0">
                                    +639197175445                  
                                </p>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-telephone-fill green1 fs-5 p-0 m-0 me-2 "></i>
                                <p class="black3 lh-sm fs-5 mb-0">
                                    +639953047019                 
                                </p>
                            </div>
                        </div>
                        <div class="mb-2">
                            <h1 class="h-font fs-4 green1 me-2 sub-title mb-0 text-start mb-1">Email</h1>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-envelope-fill green1 fs-5 p-0 m-0 me-2 "></i>
                                <p class="black3 lh-sm fs-5 mb-0">
                                    <a href="mailto:eduportalmain@gmail.com" class="black3">eduportalmain@gmail.com</a>               
                                </p>
                            </div>
                            
                        </div>  
                    </div> 
                </div>
                <div class="col-lg-6 px-lg-4">
                    <div style="width: 90%;">
                        <div class="mb-3">
                            <h1 class="h-font fs-4 green1 me-2 sub-title mb-0 text-start mb-1">Special Links</h1>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-facebook green1 fs-3 p-0 m-0 me-2 "></i>
                                <p class="black3 lh-sm fs-5 mb-0">
                                    <a href="#" class="black3">facebook.com/eduportal</a>               
                                </p>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-twitter-x green1 fs-3 p-0 m-0 me-2 "></i>
                                <p class="black3 lh-sm fs-5 mb-0">
                                    <a href="#" class="black3">x.com/eduportal</a>               
                                </p>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-instagram green1 fs-3 p-0 m-0 me-2 "></i>
                                <p class="black3 lh-sm fs-5 mb-0">
                                    <a href="#" class="black3">instagram.com/eduportal</a>               
                                </p>
                            </div>
                            
                        </div>
                        <div class="mb-2">
                            <h1 class="h-font fs-4 green1 me-2 sub-title mb-0 text-start mb-1">iFrame</h1>
                            <div class="d-flex align-items-center mb-2 mt-3">
                                <iframe class="w-100 rounded-4 border-1" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3860.0440499452748!2d120.99215487487378!3d14.6534409858392!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b686dd24e859%3A0xe442b57504cbf05f!2sUniversity%20of%20Caloocan%20City%20-%20South%20Campus!5e0!3m2!1sen!2sph!4v1734187925068!5m2!1sen!2sph" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                            
                        </div>  
                    </div> 
                </div>
            </div>
        </div>

    </div>

    <?php include("inc/footer.php") ?>
    <script>
        var showModal = <?php echo $showModal ? "true" : "false"; ?>;

        if (showModal) {
            // Open the modal if PHP sets the condition
            var signInModal = new bootstrap.Modal(document.getElementById('signInModal'));
            signInModal.show();
        }

        var sGmail = <?php echo $gmailReg ? "true" : "false"; ?>;

        if (sGmail) {
            // Open the modal if PHP sets the condition
            var signUpModal = new bootstrap.Modal(document.getElementById('signUpModal'));
            signUpModal.show();
        }

        var regMsg = <?php echo $regMsg ? "true" : "false"; ?>;

        if (regMsg) {
            // Open the modal if PHP sets the condition
            console.log(regMsg);
            var msgModal = new bootstrap.Modal(document.getElementById('msgModal'));
            msgModal.show();
        }
        
        document.addEventListener("click", function(event) {
            if (event.altKey) {
                let target = event.target.closest("a, button");
                if (target) {
                    event.preventDefault();
                }
            }
        });
    </script>
    <!-- <script src="https://eduportal-wgrc.onrender.com/socket.io/socket.io.min.js"></script> -->
  
</body>

</html>

<?php
// if (!isset($_SESSION['unset'])) {
//     session_unset();
// }

?>