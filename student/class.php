<?php 
if (session_id() === "") session_start();

if(!isset($_SESSION["user_category"])){
    header("Location: ../index.php");
}

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.19.0/js/md5.min.js"></script>

    <!-- <script src="scripts/view-class.js"></script> -->
    <!-- <script src="scripts/class-content.js"></script> -->
    <?php if(isset($_GET["class"])){ include("student backend/includes/view-class.php"); } 
        $_SESSION["storeCode"] = $_GET["class"]; 
        // $_SESSION["storedId"] = $_GET["post"];
    ?>
    <?php require('inc/links.php');  ?>
    
</head>

<body>
    <?php require('inc/header.php'); ?>

    <div class="container-fluid p-0 m-0" id="main-content">
        <div class="row">
            <div class="col-lg-10 col-sm-12 ms-auto">
                <nav class="navbar navbar-expand-lg sticky-top line fs-5 z-2" style="background-color: white">
                    <div class="container-fluid sticky-top" >
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse green1" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link active" href="class.php?class=<?php echo md5($details[0]["class_code"]); ?>" >Class Name</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="submittedworks.php?class=<?php echo md5($details[0]["class_code"]); ?>">Submitted Works</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="list.php?class=<?php echo md5($details[0]["class_code"]); ?>">List of Students</a>
                                </li>
                              
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="container mt-4 px-lg-5 px-sm-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <h1 class="h-font green1 me-2 title" id="pageTitle"><?php echo $details[0]["class_name"]; ?></h1>
                        <div class="line-h"></div>
                    </div>
                    <div class="row d-flex px-2 py-1">
                        <div class="col-lg-9">
                            <p class="lh-base fw-semibold green2 fs-5">
                                Class Schedule: <span id="classSched" class="fw-semibold black3"><?php echo $details[0]["class_schedule"]; ?></span></br>
                                Professor: <span id="classInstructor" class="fw-semibold black3"><?php echo $details[0]["class_teacher"]; ?></span></br>
                                Class Code: <span id="classCode" class="fw-semibold black3"><?php echo $details[0]["class_code"]; ?></span></p>
                        </div>
                        <div class="col-lg-3 ms-auto">
                            <div class="container-fluid bg-body-tertiary py-2 rounded-4">
                                <p class="fw-semibold green2 fs-5 lh-sm">Attendance <br>
                                      <!-- Add Current Date Here -->
                                    <span class="fs-6 fw-semibold black3"><?php echo $currentDate; ?></span>
                                </p>
                                <!-- <div class="container-fluid form-check form-switch container-fluid ">
                                    <input class="form-check-input" type="checkbox" id="attendance-toggle">
                                </div> -->
                            </div>
                            <!-- Change element into an unclickable element -->
                            <button class="container-fluid btn green shadow-none mt-2 fw-medium fs-5">Attendance Status: <br><?php include("student backend/includes/attendance-status.php"); ?></button>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <h1 class="h-font green1 me-2 sub-title">Lessons</h1>
                            <div class="line-h"></div>
                        </div>
                        <div id="materialContent">

                            <?php
                                    if(isset($post[0]["content_type"])){
                                        for($i = 0 ; $i < count($post); $i++){
                                            $year = $post[$i]["month"][0] . "" . $post[$i]["month"][1] . $post[$i]["month"][2] . "" . $post[$i]["month"][3];
                                            $month = $months[$post[0]["month"][5] . "" . $post[0]["month"][6] - 1];
                                            $day = $post[$i]["month"][8] . "" . $post[$i]["month"][9];
                                            if($post[$i]["content_type"] == "Material"){
                                                ?>
                                                    <a href='material.php?class=<?php echo md5($details[0]["class_code"]); ?>&post=<?php echo md5($post[$i]['post_id']); ?>'>             
                                                <?php
                                                echo" <div class='container-fluid bg-body-tertiary d-flex align-content-center rounded-3 px-4 py-2 mb-2 shadow-elevation-dark-1'>
                                                        <div><i class='bi bi-bookmark-fill green1 fs-2 p-0 m-0'></i></div>
                                                        <div class='ms-3 mt-1'> 
                                                            <p id='material-id' hidden>{$post[$i]['post_id']}</p>
                                                            <p class='green2 fw-bold lh-1 fs-5 mb-0 pb-0' id='material-title'>{$post[$i]['title']}<br>
                                                                <span class='fs-6 fw-light green3' id='material-date'>{$month} {$day}, {$year}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>";
                                            }
                                        }
                                    }
                            ?>

                            <!-- <a href="">
                                <div class="container-fluid bg-body-tertiary d-flex align-content-center rounded-3 px-4 py-2 mb-2 shadow-elevation-dark-1">
                                    <div>   
                                        <i class="bi bi-question-circle-fill green1 fs-2 p-0 m-0"></i>
                                    </div>
                                    <div class="ms-3 mt-1">
                                        <p class="green2 fw-bold lh-1 fs-5 mb-0 pb-0" id="material-title">Lesson 1: C# Basics <br>
                                            <span class="fs-6 fw-light green3" id="material-date">September 24, 2024</span>
                                        </p>
                                    </div>
                                </div>
                            </a>  -->

                        </div>
                    </div>

                    <div class="mt-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <h1 class="h-font green1 me-2 sub-title">Activities</h1>
                            <div class="line-h"></div>
                        </div>
                        <div id="actsContent">
                        <?php
                                    if($activity != null){
                                        // echo var_dump($activity);
                                        for($i = 0 ; $i < count($activity); $i++){
                                            if($activity[$i]["content_type"] == "Activity"){
                                                $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                                                $year = $activity[$i]["month"][0] . "" . $activity[$i]["month"][1] . $activity[$i]["month"][2] . "" . $activity[$i]["month"][3];
                                                $month = $months[$activity[0]["month"][5] . "" . $activity[0]["month"][6] - 1];
                                                $day = $activity[$i]["month"][8] . "" . $activity[$i]["month"][9];
                                                ?>
                                                <a href='material.php?class=<?php echo md5($details[0]["class_code"]); ?>&post=<?php echo md5($activity[$i]['post_id']); ?>'>             
                                            <?php
                                            echo" <div class='container-fluid bg-body-tertiary d-flex align-content-center rounded-3 px-4 py-2 mb-2 shadow-elevation-dark-1'>
                                                    <div><i class='bi bi-file-earmark-text-fill green1 fs-2 p-0 m-0'></i></div>
                                                    <div class='ms-3 mt-1'> 
                                                        <p id='material-id' hidden>{$activity[$i]['post_id']}</p>
                                                        <p class='green2 fw-bold lh-1 fs-5 mb-0 pb-0' id='material-title'>{$activity[$i]['title']}<br>
                                                            <span class='fs-6 fw-light green3' id='material-date'>{$month} {$day}, {$year}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>";
                                            }
                                        }
                                    }
                            ?>
                        </div>
                    </div>

                    <div class="mt-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <h1 class="h-font green1 me-2 sub-title">Quizzes</h1>
                            <div class="line-h"></div>
                        </div>
                        <div id="quizContent">
                        <?php   
                                    if($quiz != null){
                                        for($i = 0 ; $i < count($quiz); $i++){
                                            if($quiz[$i]["content_type"] == "Quiz"){
                                                ?>
                                                <a href='material.php?class=<?php echo md5($details[0]["class_code"]); ?>&post=<?php echo md5($quiz[$i]['post_id']); ?>'>             
                                             <?php
                                            $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

                                            $year = $quiz[$i]["month"][0] . "" . $quiz[$i]["month"][1] . $quiz[$i]["month"][2] . "" . $quiz[$i]["month"][3];
                                            $month = $months[$quiz[0]["month"][5] . "" . $quiz[0]["month"][6] - 1];
                                            $day = $quiz[$i]["month"][8] . "" . $quiz[$i]["month"][9];
                                             echo" <div class='container-fluid bg-body-tertiary d-flex align-content-center rounded-3 px-4 py-2 mb-2 shadow-elevation-dark-1'>
                                                    <div><i class='bi bi-question-circle-fill green1 fs-2 p-0 m-0'></i></div>
                                                    <div class='ms-3 mt-1'> 
                                                        <p id='material-id' hidden>{$quiz[$i]['post_id']}</p>
                                                        <p class='green2 fw-bold lh-1 fs-5 mb-0 pb-0' id='material-title'>{$quiz[$i]['title']}<br>
                                                            <span class='fs-6 fw-light green3' id='material-date'>{$month} {$day}, {$year}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>";
                                            }
                                        }
                                    }
                            ?>
                        </div>
                    </div>

                    <div class="mt-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <h1 class="h-font green1 me-2 sub-title">Exams</h1>
                            <div class="line-h"></div>
                        </div>
                        <div id="examContent">
                            
                        <?php 
                                        if($exam != null){
                                            for($i = 0 ; $i < count($exam); $i++){
                                                if($exam[$i]["content_type"] == "Exam"){
                                                    $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                                                    $year = $exam[$i]["month"][0] . "" . $exam[$i]["month"][1] . $exam[$i]["month"][2] . "" . $exam[$i]["month"][3];
                                                    $month = $months[$exam[0]["month"][5] . "" . $exam[0]["month"][6] - 1];
                                                    $day = $exam[$i]["month"][8] . "" . $exam[$i]["month"][9];
                                                    ?>
                                                    <a href='material.php?class=<?php echo md5($details[0]["class_code"]); ?>&post=<?php echo md5($exam[$i]['post_id']); ?>'>             
                                                <?php
                                                echo" <div class='container-fluid bg-body-tertiary d-flex align-content-center rounded-3 px-4 py-2 mb-2 shadow-elevation-dark-1'>
                                                        <div><i class='bi bi-question-circle-fill green1 fs-2 p-0 m-0'></i></div>
                                                        <div class='ms-3 mt-1'> 
                                                            <p id='material-id' hidden>{$exam[$i]['post_id']}</p>
                                                            <p class='green2 fw-bold lh-1 fs-5 mb-0 pb-0' id='material-title'>{$exam[$i]['title']}<br>
                                                                <span class='fs-6 fw-light green3' id='material-date'>{$month} {$day}, {$year}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>";
                                                }
                                            }
                                        }
                                    
                            ?>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    </div>
    <br><br><br>

    <?php require('inc/footer.php'); ?>

    <script src="https://eduportal-wgrc.onrender.com/socket.io/socket.io.min.js"></script>
    <script src="scripts/view-class.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const navLinks = document.querySelectorAll('.nav-link');

        // Loop through each link and add click event listener
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                // Remove 'active' class from all nav links
                navLinks.forEach(link => link.classList.remove('active'));
                // Add 'active' class to the clicked link
                this.classList.add('active');
            });
        });
    </script>
</body>

</html>