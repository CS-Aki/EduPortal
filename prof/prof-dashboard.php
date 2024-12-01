<?php

if (session_id() === "") session_start();
require_once("../log and reg backend/classes/connection.php");
require_once("classes/model.Prof.php");
require_once("classes/controller.Prof.php");
require_once("acc.php");

// echo "This is the email ".  $name . " <br>";

// echo "This is the name ". $email . " <br>";

// echo "This is the session ". session_id() . " <br>";
// $google_loggedin = $_SESSION['google_loggedin'];
// $google_email = $_SESSION['google_email'];
// $google_name = $_SESSION['google_name'];
// // echo  $_SESSION['user_id'];

// session_write_close();

// $random = rand(1,1000000);
// session_name("session_" . $random);
// session_start();

// echo "<br><br>Session " . session_id();

// echo  $_SESSION['user_id'];
// echo $google_email . "<br>" .  $google_name . "<br>";
// echo $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.19.0/js/md5.min.js"></script>

    <script src="scripts/display-class.js"></script>

    <?php require('inc/links.php'); ?>

</head>

<body>
    <?php require('inc/header.php'); ?>

    <div class="container-fluid px-4 py-3" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto">
                <div class="container">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="h-font green3 me-2" id="pageTitle"><?php if (!isset($_GET["class"])) echo "All Classes"; ?></h3>
                        <div class="line-h"></div> <!-- Ensure the line grows to fill the space -->
                    </div>
                    <div>
                        <!-- <h1 class="h-font green1"><i class="bi bi-folder2-open me-2"></i>BSCS 3A</h1> -->
                    </div>
                    <!--  -->
                    <div>
                        <div class="row mt-3 d-flex justify-content-center" id="class-container">

                             <!-- Display the professor classes else display the selected class -->
                            <?php if (!isset($_GET["class"])) require_once("includes/load-classes.php");
                            else { ?>
                                <?php if(!isset($_GET["post"])){ ?>

                                    
                                <!-- Temmporary display for class information and posts -->
                                <span id="classCode" class="code"></span><br>
                                <span id="classSched"></span><br>
                                <span id="classInstructor"></span><br><br>
                                <div> <button id="displayPost">DISPLAY POST</button></div>

                                <div id="postContainer">
                                    <form action="includes/post.php" method="post" id="postForm">
                                        <label>Title</label>
                                        <input type="text" id="title" placeholder="Enter Title" required><br>
                                        <label>Description</label>
                                        <input type="text" id="description" placeholder="Enter Description" required><br>
                                        <!-- Will change this to a dropdown -->
                                        <label>Content Type</label>
                                        <input type="text" id="contentType" placeholder="Enter Content Type" required><br><br>
                                        <button type="submit" id="post">POST</button>
                                    </form>
                                </div>

                                <h4>• Materials</h4>
                                <div id="materialContent"></div>
                                <br><br>
                                <h4>• Activities</h4>
                                <div id="actsContent"></div>
                                <br><br>
                                <h4>• Quizzes</h4>
                                <div id="quizContent"></div>
                                <br><br>
                                
                                <script src="scripts/post-content.js">
                                </script>
                                <!-- <span id="">TEST</span><br> -->
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
                                        // Handles the displaying of the selected post by the user
                      -->       <?php }else if(isset($_GET["post"])){?>
                                                <span>POST HERE</span>
                                <?php } ?>
                            <?php } ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar-menu');
            sidebar.classList.toggle('active');
        }
    </script>
    <script src="scripts/display-post.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>