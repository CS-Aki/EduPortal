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
    <title>EduPortal</title>
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
    <div class="container-fluid p-0">
        <div class="container-fluid px-0 m-0 carousel-container position-relative">
            <div id="carouselExample" class="carousel slide carousel-fade position-relative" data-bs-ride="carousel">
                <div class="position-absolute overlay z-2 d-flex flex-column justify-content-center mt-lg-5 ms-lg-5 mt-2 p-lg-5 p-5 ms-0">
                    <h1 class="h-font2 white2 mb-0 pb-0">Education</h1>
                    <h1 class="h-font2 white2 mt-0 mb-4 pt-0">made <i class="green2">accessible.</i></h1>
                    <!-- <a data-target="#signUpModal" data-bs-toggle="modal" href="#signUpModal" class="green2 fs-6 ms-2"><button class="btn btn-lg green rounded-5 px-3">Start your journey</button></a> -->
                    <a href="google-oauth.php" class="green2 fs-6 ms-2"><button class="btn btn-lg green rounded-5 px-3">Start your journey</button></a>

                </div>
                <div class="carousel-inner z-1">
                    <div class="carousel-item active">
                        <img src="images/background1.png" class="d-block w-100 h-100 object-fit-cover" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="images/background2.jpg" class="d-block w-100 object-fit-cover" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="images/background3.jpg" class="d-block w-100 object-fit-cover" alt="...">
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
        <div class="container-fluid p-4">
            <div class="container-fluid mt-3">
                <h1 class="h-font fs-1 green1 me-2 sub-title mb-0 text-center mb-2">Features</h1>
            </div>
            <div class="row p-lg-3 p-sm-3 mx-lg-5 mx-sm-3">
                <div class="col-lg-4 col-md-6 col-sm-12 mb-2 d-flex align-items-center justify-content-center mb-4">
                    <div class="p-3 px-4 shadow-elevation-light-3 rounded-4 d-flex flex-column align-items-center justify-content-center h-100" style="width: 90%;">
                        <i class="bi bi-intersect green1 fs-1 p-0 m-0 "></i>
                        <h1 class="h-font fs-3 mb-3 green1 me-2 sub-title mb-0 text-center">Interactive Learning Experience</h1>
                        <p class="black3 lh-1 fs-6 ">
                            Engage with dynamic content, quizzes, and multimedia resources tailored to your learning style.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-2 d-flex align-items-center justify-content-center mb-4">
                    <div class="p-3 px-4 shadow-elevation-light-3 rounded-4 d-flex flex-column align-items-center justify-content-center h-100" style="width: 90%;">
                        <i class="bi bi-globe green1 fs-1 p-0 m-0 "></i>
                        <h1 class="h-font fs-3 mb-3 green1 me-2 sub-title mb-0 text-center">Access Anytime, Anywhere</h1>
                        <p class="black3 lh-1 fs-6 ">
                            Learn on the go with our mobile-friendly platform.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-2 d-flex align-items-center justify-content-center mb-4">
                    <div class="p-3 px-4 shadow-elevation-light-3 rounded-4 d-flex flex-column align-items-center justify-content-center h-100" style="width: 90%;">
                        <i class="bi bi-people-fill green1 fs-1 p-0 m-0 "></i>
                        <h1 class="h-font fs-3 mb-3 green1 me-2 sub-title mb-0 text-center">Collaborative Tools</h1>
                        <p class="black3 lh-1 fs-6 ">
                            Connect with peers and instructors through classrooms and replies.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-2 d-flex align-items-center justify-content-center mb-4">
                    <div class="p-3 px-4 shadow-elevation-light-3 rounded-4 d-flex flex-column align-items-center justify-content-center h-100" style="width: 90%;">
                        <i class="bi bi-intersect green1 fs-1 p-0 m-0 "></i>
                        <h1 class="h-font fs-3 mb-3 green1 me-2 sub-title mb-0 text-center">Easy Course Creation</h1>
                        <p class="black3 lh-1 fs-6 ">
                            Design and launch courses effortlessly with our user-friendly tools.                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-2 d-flex align-items-center justify-content-center mb-4">
                    <div class="p-3 px-4 shadow-elevation-light-3 rounded-4 d-flex flex-column align-items-center justify-content-center h-100" style="width: 90%;">
                        <i class="bi bi-pencil-square green1 fs-1 p-0 m-0 "></i>
                        <h1 class="h-font fs-3 mb-3 green1 me-2 sub-title mb-0 text-center">Cuztomizable Assessments</h1>
                        <p class="black3 lh-1 fs-6 ">
                         Create quizzes and assignments that align with your curriculum.                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-2 d-flex align-items-center justify-content-center mb-4">
                    <div class="p-3 px-4 shadow-elevation-light-3 rounded-4 d-flex flex-column align-items-center justify-content-center h-100" style="width: 90%;">
                        <i class="bi bi-pie-chart-fill green1 fs-1 p-0 m-0 "></i>
                        <h1 class="h-font fs-3 mb-3 green1 me-2 sub-title mb-0 text-center">Analytics and Reporting</h1>
                        <p class="black3 lh-1 fs-6 ">
                        Gain insights into student performance and engagement to enhance your teaching strategies.                        </p>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="container-fluid bg-body-secondary p-4">
            <div class="container-fluid mt-3">
                <h1 class="h-font fs-1 green1 me-2 sub-title mb-0 text-center mb-2">Why Choose EduPortal?</h1>
            </div>
            <div class="row p-lg-3 p-sm-3 mx-lg-5 mx-sm-3">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-2 d-flex align-items-center justify-content-center mb-4">
                    <div class="p-3 px-4 bg-white shadow-elevation-light-3 rounded-4 d-flex flex-column align-items-center justify-content-center h-100 py-3" style="width: 80%;">
                        <i class="bi bi-person-circle green1 p-0 m-0" style="font-size: 6rem;"></i>
                        <h1 class="h-font fs-3 mb-3 green1 me-2 sub-title mb-0 text-center">For Students</h1>
                        <div class="w-75 greenline"></div>
                        <p class="black3 lh-base fs-6 mt-4">
                            <ul>
                                <li class="black3 lh-normal">Achieve your academic goals</li>
                                <li class="black3 lh-normal">Enhance skills and knowledge</li>
                                <li class="black3 lh-normal">Build a professional network</li>
                            </ul>
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mb-2 d-flex align-items-center justify-content-center mb-4">
                    <div class="p-3 px-4 bg-white shadow-elevation-light-3 rounded-4 d-flex flex-column align-items-center justify-content-center h-100 py-3" style="width: 80%;">
                        <i class="bi bi-mortarboard-fill green1 p-0 m-0" style="font-size: 6rem;"></i>
                        <h1 class="h-font fs-3 mb-3 green1 me-2 sub-title mb-0 text-center">For Professors</h1>
                        <div class="w-75 greenline"></div>
                        <p class="black3 lh-base fs-6 mt-4">
                            <ul>
                                <li class="black3 lh-normal">Streamline your teaching process</li>
                                <li class="black3 lh-normal">Foster student engagement</li>
                                <li class="black3 lh-normal">Improve learning outcomes</li>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="container-fluid">
            <div class="container-fluid my-4 mt-lg-5 mt-sm-3">
                <h1 class="h-font fs-1 green1 me-2 sub-title mb-0 text-center mb-2">What our users say</h1>
            </div>
            <div id="carouselExampleIndicators" class="carousel slide w-75 mx-auto mb-lg-4 pb-lg-3 mb-sm-0 pb-sm-0" data-bs-ride="carousel" >
                <!-- Carousel Inner -->
                <div class="carousel-inner">
                    <!-- First Testimonial -->
                    <div class="carousel-item active">
                        <div class="testimonial-container d-flex flex-column align-items-center justify-content-center text-center px-5 my-4 rounded-5" style="height: 530px;">
                            <i class="bi bi-quote text-success mb-2" style="font-size: 6rem;"></i>
                            <p class="fs-3 px-3 fw-semibold black3">
                                "EduPortal transformed the way I learn. The interactive features keep me engaged!""
                            </p>
                            <h5 class="mt-4 fs-3 fw-semibold black2 fst-italic">- John Doe, Student</h5>
                            <div class="line w-75"></div>
                        </div>
                    </div>

                    <!-- Second Testimonial -->
                    <div class="carousel-item">
                        <div class="testimonial-container d-flex flex-column align-items-center text-center px-5 my-4 rounded-5" style="height: 530px;">
                            <i class="bi bi-quote text-success mb-2" style="font-size: 6rem;"></i>
                            <p class="fs-3 px-3 fw-semibold black3">
                            "EduPortal has made managing my classes so much easier. All my lessons, assignments, and deadlines are in one place. It's like having a personal assistant for my studies!"
                            </p>
                            <h5 class="mt-4 fs-3 fw-semibold black2 fst-italic">— Alex R., High School Student</h5>
                            <div class="line w-75"></div>
                        </div>
                    </div>

                    <!-- Third Testimonial -->
                    <div class="carousel-item">
                        <div class="testimonial-container d-flex flex-column align-items-center text-center px-5 my-4 rounded-5" style="height: 530px;">
                            <i class="bi bi-quote text-success mb-2" style="font-size: 6rem;"></i>
                            <p class="fs-3 px-3 fw-semibold black3">
                                "As an educator, EduPortal has streamlined the way I deliver lessons and communicate with my students. It's intuitive and packed with tools that save me so much time."                            </p>
                            <h5 class="mt-4 fs-3 fw-semibold black2 fst-italic">— Sarah T., Math Teacher</h5>
                            <div class="line w-75"></div>
                        </div>
                    </div>
                </div>

                <!-- Controls -->
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>
        </div>
        <div class="container-fluid bg-body-secondary p-5" style="background-image: url('images/background4.png'); background-size: cover no-repeat;">
            <div class="mb-4 pb-4">
                <h1 class="h-font fs-1 green1 me-2 sub-title mb-0 text-center mb-2">Ready to</h1>
                <h1 class="h-font fs-1 green1 me-2 sub-title mb-0 text-center mb-2" style="font-size: 3rem !important;">Transform Learning?</h1>
            </div>
            <div class="mt-5 pt-5 text-end pb-4">
                <h1 class="fs-2 fw-light green1 me-2 sub-title mb-0 text-end mb-2">Join EduPortal today and</h1>
                <h1 class="fs-2 fw-light green1 me-2 sub-title mb-0 text-end mb-2">unlock a world of educational possibilities.</h1>
                <a href="google-oauth.php" class="green2 fs-6 ms-2 "><button class="btn btn-lg green rounded-5 mt-4">Sign up now</button></a>
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