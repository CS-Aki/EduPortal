<?php

if (session_id() === "") session_start();
// echo "test " . $_SESSION["address"];
if(isset($_SESSION["user_category"])){
    $category = $_SESSION["user_category"];
    switch($category){
        case 1: header("Location: ../admin/admin-dashboard.php"); exit(); break;
        case 2: header("Location: ../staff/staff-dashboard.php"); break;
        case 3: header("Location: ../instructor/instructor-dashboard.php"); exit(); break;
        // case 4: header("Location: student/student-dashboard.php"); break;
    }
}else{
    header("Location: ../");
    exit();
}

require_once("../log and reg backend/classes/connection.php");
require_once("student backend/classes/model.ClassRm.php");
require_once("student backend/classes/controller.Lists.php");
require_once("student backend/classes/controller.Student.php");
require_once("acc.php");
$_SESSION["email"] = $email;
$_SESSION["id"] = $userId;
$_SESSION["name"] = $name;

if (session_id() === "") session_start();

require_once("student backend/get-profile.php");
// require_once("student backend/includes/announce.php");
// echo $_SESSION["access_token"];
// if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
//     $url = "https";
//     } else {
//     $url = "http";
//     }

//     $url .= "://";
//     $url .= $_SERVER['HTTP_HOST'];
//     $url .= $_SERVER['REQUEST_URI'];

//     echo $url;

if(isset($_GET["class"])){
    include("class.php");
}else{

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.19.0/js/md5.min.js"></script>
    <script src="scripts/join-class.js"></script>
    
    <?php require('inc/links.php'); ?>
    <script src="scripts/announce.js"></script>
<style>
    .card-body{
        min-height:10rem !important;
    }
    </style>
</head>

<body>
    <?php require('inc/header.php'); ?>
    
    <div class="container-fluid px-4 py-3" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="h-font green3 me-2">All Classes</h3>
                        <div class="line-h"></div> <!-- Ensure the line grows to fill the space -->
                    </div>
                    <div>
                        <!-- <h1 class="h-font green1"><i class="bi bi-folder2-open me-2"></i>BSCS 3A</h1> -->
                    </div>
                    <!--  -->
                    <div>
                        <div class="row mt-3 d-flex justify-content-start" id="class-container">
                            
                            <?php require("student backend/includes/load-classes.php"); ?>
                             <!-- <?php if(isset($_POST["class"])){ ?> <script src="scripts/class-content.js"></script> <?php } ?> -->

                            <!-- <div class="col-lg-3 col-md-4 mb-3">
                                <a href="">
                                    <div class="card shadow-elevation-light-3" style="width: 18rem; border-radius: 20px;">
                                        <div class="card-img-top" style="height: 100px; background-color: var(--green1); border-radius: 20px 20px 0 0;"></div>
                                        <div class="card-body">
                                            <h5 class="card-title i-font black2 mb-0">Software Engineering I</h5>
                                            <h6 class="card-text black3 ">CCS 110</h6>
                                            <h6 class="card-text black3">Jessie Alamil</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                      -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Announce modal -->
        <div class="modal fade" id="announceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editProfLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">                       
                <div class="modal-content rounded-4 px-0">
                    <div class="container-fluid rounded-top-4 general" id="announcement-type"></div> <!-- change class naalng here general, exam or maintenance -->
                    <div class="modal-body px-3 pb-3 mt-2">
                        <form action="">
                            <div class="container-fluid d-flex justify-content-between align-items-center">
                                <div class="d-flex justify-content-center align-items-center mt-2">
                                    <div>
                                        <i class='bi bi-megaphone-fill fs-1 green1 title p-0 m-0'></i>
                                    </div>
                                    <div class="lh-1">
                                        <h1 class="title fs-1 h-font ms-3 m-0 p-0 green1 lh-1" id="className">Announcement</h1>
                                        <p class="fw-light black3 ms-3 fs-6 d-flex m-0 lh-1" id="date-text">October 12, 2024</p>   
                                    </div>
                                </div>
                                <!-- Close button -->
                                <button type="button" class="btn-close" id="close_code" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="container-fluid mt-4 mb-4">
                                <div class="container-fluid">
                                    <div class="d-flex align-items-center justify-content-start">
                                        <p class="fw-bold black2 fs-6 d-flex m-0 lh-1" id="announcement-title">Announcement Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum</p>   
                                    </div>
                                    <div class="container-fluid d-flex align-items-center justify-content-start mt-4">
                                        <pre class="black2 fs-6" style="white-space: pre-wrap;" id="content">
                                        <?php 
                                        $text = <<<'ANNOUNCEMENT'
                                                    Dear UCCians,

                                                    We hope this message finds you safe and in good spirits. We would like to inform you of an important update concerning the academic schedule. Due to the incoming typhoon expected to affect our area, all classes and academic activities from October 11 to October 15 will be suspended. This decision has been made to prioritize the safety and well-being of our students, instructors, staff, and the entire UCC community.

                                                    During this period, we advise everyone to take the necessary precautions to stay safe. The typhoon is predicted to bring heavy rains, strong winds, and possible flooding, and we urge you to follow updates from local authorities and weather agencies.
                                                    Stay safe, UCCians!

                                                    Warm regards,
                                                    The UCC Admin Team
                                                    University of Caloocan City
                                                    ANNOUNCEMENT;

                                        echo trim($text);
                                        ?>
                                        </pre> 
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons positioned at the bottom -->
                            <div class="modal-footer d-flex justify-content-end">
                                <button id="next-btn" type="button" class="btn btn-primary me-2">Next</button>
                                <button type="button" class="btn btn-secondary" id='close-announce' data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>      
            </div>           
        </div>
</div>

    <?php require('inc/footer.php'); ?>

    <script src="https://eduportal-wgrc.onrender.com/socket.io/socket.io.min.js"></script>

    <script>
         const socket = io("https://eduportal-wgrc.onrender.com", {
              transports: ["websocket"], // Ensure WebSocket transport
              timeout: 10000,            // Maximum time (ms) to wait for a connection
              reconnection: true,        // Enable auto-reconnection
              reconnectionAttempts: 5,   // Maximum attempts before giving up
              pingInterval: 25000,       // Send a ping every 25 seconds
              pingTimeout: 5000          // Wait 5 seconds for a pong before disconnecting
          });

        socket.on('connect_error', (err) => {
            console.error("Connection error:", err);
        });

        socket.on('connect', () => {
            console.log('Connected to Socket.IO server');
            });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>

<?php } ?>