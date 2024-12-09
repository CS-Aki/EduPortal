<?php

if (session_id() === "") session_start();
// echo "test " . $_SESSION["address"];
if(isset($_SESSION["user_category"])){
    $category = $_SESSION["user_category"];
    switch($category){
        case 1: header("Location: ../admin/admin-dashboard.php"); exit(); break;
        case 2: break;
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
</head>

<body>
    <?php require('inc/header.php'); ?>
    
    <div class="container-fluid px-4 py-3" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto">
                <div class="container">
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

    <?php require('inc/footer.php'); ?>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar-menu');
            sidebar.classList.toggle('active');
        }
    </script>
    <script src="https://eduportal-wgrc.onrender.com/socket.io/socket.io.min.js"></script>

    <script>
        const socket = io("https://eduportal-wgrc.onrender.com", {
            transports: ["websocket"] // Ensure WebSocket transport
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