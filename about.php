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
    <title>About Us</title>
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
            <div class="row">
                <div class="col-lg-12 px-lg-4">
                    <div>
                        <div class="mb-2 d-flex align-items-center justify-content-center flex-column">
                            <img src="images/combined-fixed.png" id="logoabout" style="width: 25rem;">
                            <h1 class="h-font fs-1 green1 me-2 sub-title mb-0 text-start mb-2">About Us</h1>
                        </div> 
                        <div class="mb-2 text-center">
                            <p class="black3 lh-sm fs-6 text-justify mb-2">
                                Welcome to EDUPORTAL, your comprehensive educational management system designed to revolutionize the way institutions, educators, and students interact with learning. Our mission is to streamline educational processes, enhance communication, and foster an enriching learning environment that meets the evolving needs of today’s academic landscape.                 
                            </p>
                            <h1 class="h-font fs-3 green1 me-2 sub-title mb-2 text-center mb-2">Vision</h1>
                            <p class="black3 lh-sm fs-6 text-justify mb-2">
                                We envision a world where education is accessible, efficient, and engaging. We believe that the right tools can empower educators to inspire their students, while also enabling learners to take control of their educational journeys. Our platform aims to bridge the gap between traditional teaching methods and modern technological advancements, making education more effective and adaptable for everyone.                            
                            </p>
                            <h1 class="h-font fs-3 green1 me-2 sub-title mb-2 text-center mb-2">Mission</h1>
                            <p class="black3 lh-sm fs-6 text-justify mb-2">
                                Our mission is to provide an intuitive, user-friendly platform that simplifies educational management. By integrating various functionalities such as course management, student information systems, and communication tools into one seamless interface, we help educators and institutions save time and resources. Our goal is to enhance collaboration between teachers, students, and parents, ensuring that everyone involved in the educational process is informed, engaged, and supported.                            </p>
                            <h1 class="h-font fs-3 green1 me-2 sub-title mb-2 text-center mb-2">What we offer</h1>
                            <p class="black3 lh-sm fs-6 text-justify mb-2">
                                EDUPORTAL is equipped with a wide range of features designed to meet the unique needs of educational institutions:                            \
                            </p>
                            <ul>
                                <li class="black3 fs-6"><b>Course Management:</b> Easily create, manage, and track courses, ensuring that all educational materials are organized and accessible.</li>
                                <li class="black3 fs-6"><b>Student Profiles:</b> Maintain comprehensive profiles that track academic progress, attendance, and personal achievements.</li>
                                <li class="black3 fs-6"><b>Analytics and Reporting:</b> Utilize data-driven insights to monitor performance, identify trends, and make informed decisions to improve educational outcomes.</li>
                            </ul>
                            <h1 class="h-font fs-3 green1 me-2 sub-title mb-2 text-center mb-2">Join us on our journey</h1>
                            <p class="black3 lh-sm fs-6 text-justify mb-2">
                                As we continue to develop and refine EDUPORTAL, we invite you to join us on this exciting journey. Whether you are an educator, an administrator, or a student, we believe that together we can create a more efficient, engaging, and empowering educational experience.
                                </br>Thank you for choosing EDUPORTAL. We are excited to partner with you in shaping the future of education!                            </p>
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