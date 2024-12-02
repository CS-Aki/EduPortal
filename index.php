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
        case 2: break;
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
    <title>EduPortal</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="scripts/sign-in.js"></script>
    <script src="scripts/sign-up.js"></script>

    <?php require('inc/links.php'); ?>
    <style>
        .carousel-container {
            height: 560px;
            position: relative;
            overflow: hidden;
        }

        .carousel-item img {
            width: 100vw;
            margin-left: calc(-50vw + 50%);
        }

        .overlay {
            margin-left: 70px;
            margin-top: 15vh;
            max-width: 90vw;
        }
    </style>
</head>

<body>

    <?php include("inc/header.php") ?>

    <div class=" container-fluid px-0 m-0 carousel-container">
        <div id="carouselExample" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="position-absolute overlay">
                <h1 class="h-font2 white2 mb-0 pb-0" style="font-size: 90px; font-weight: 700;">Education</h1>
                <h1 class="h-font2 white2 mt-0 mb-4 pt-0" style="font-size: 90px; font-weight: 700;">made <i class="green2">accessible.</i></h1>
                <!-- <a data-target="#signUpModal" data-bs-toggle="modal" href="#signUpModal" class="green2 fs-6 ms-2"><button class="btn btn-lg green rounded-5 px-3">Start your journey</button></a> -->
                <a href="google-oauth.php" class="green2 fs-6 ms-2"><button class="btn btn-lg green rounded-5 px-3">Start your journey</button></a>

            </div>
            <div class="carousel-inner z-n1">
                <div class="carousel-item active">
                    <img src="images/background1.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="images/background2.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="images/background3.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev visually-hidden" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next visually-hidden" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <br><br>
    <br><br>

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
    </script>
    <!-- <script src="https://eduportal-wgrc.onrender.com/socket.io/socket.io.min.js"></script> -->
  
</body>

</html>

<?php
// if (!isset($_SESSION['unset'])) {
//     session_unset();
// }

?>