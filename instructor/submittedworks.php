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
        // case 3: header("Location: instructor/instructor-dashboard.php"); break;
        case 4: header("Location: ../student/student-dashboard.php"); exit(); break;
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
    <title>Professor Dashboard</title>
    <?php require('inc/links.php'); include("includes/view-class.php"); ?>
</head>
<body>
    <?php require('inc/header.php'); ?>
    
    <div class="container-fluid p-0 m-0" id="main-content">
        <div class="row">
            <div class="col-lg-10 col-sm-12 ms-auto">
                <nav class="navbar navbar-expand-lg sticky-top line fs-5 z-2">
                    <div class="container-fluid sticky-top">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse green1" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="class.php?class=<?php echo md5($details[0]["class_code"]); ?>" >Class Name</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="submittedworks.php?class=<?php echo md5($details[0]["class_code"]); ?>">Submitted Works</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="list.php?class=<?php echo md5($details[0]["class_code"]); ?>">List of Students</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="container mt-4 px-lg-5 px-sm-2">
                    <div class="mt-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <h1 class="h-font green1 me-2 sub-title">Activities</h1>
                            <div class="line-h"></div>
                        </div>
                        <div>
                            <?php 
                                if(isset($post[0]['content_type'])){
                                    for($i = 0 ; $i < count($post); $i++){
                                        if($post[$i]['content_type'] == 'Activity'){
  
                                            echo "<div id='material'>
                                            <button data-bs-toggle='collapse' href='#{$i}' role='button' aria-expanded='false' aria-controls='collapseExample' class='btn container-fluid p-0 m-0'>
                                                <div class='container-fluid bg-body-tertiary d-flex align-content-center justify-content-between rounded-3 px-lg-4 py-2 mb-2 shadow-elevation-dark-1' >
                                                     <div class='d-flex align-content-center'>
                                                         <div>   
                                                            <i class='bi bi-bookmark-fill green1 fs-2 p-0 m-0'></i>
                                                        </div>
                                                        <div class='ms-3 mt-1'> 
                                                            <p class='green2 fw-bold lh-1 fs-5 mb-0 pb-0 d-flex flex-column align-items-start' id='material-title'>
                                                                {$post[$i]["title"]} <br>
                                                                <span class='fw-light green2 fs-6 d-flex mt-1' id='material-date'>{$month} {$day}, {$year}</span>                                         
                                                            </p>
                                                        </div>
                                                    </div>  
                                                    <div class='d-flex align-items-center justify-content-center'>  
                                                        <div>
                                                            <p class='green2 fw-light fs-5 me-2 mb-0 pb-0' id='material-score'> 6/10</p>
                                                        </div>
                                                        <div>";
                                                      ?>      <a href='material.php?class=<?php echo md5($details[0]["class_code"]); ?>&post=<?php echo md5($post[$i]['post_id']); ?>'><i class='bi bi-eye-fill green1 fs-2 p-0 m-0'></i></a>
                                                       <?php echo"</div> 
                                                    </div>
                                                </div>                    
                                            </button>";

                                            echo "<div class='collapse mb-2' id='{$i}'>
                                                        <div class='d-flex flex-column align-items-end justify-content-end' >
                                                            <div class='card card-body rounded-3 bg-body-tertiary shadow-elevation-dark-1 border-0' style='width: 90%;'>
                                                                <div class='mt-0 pt-0 d-flex' id='card-container'>
                                                                    <div class='pe-lg-3' style='width: 70%;' id='card-left-side'>
                                                                        <p class='fs-6 h-font green2 me-2 mb-1'>Description</p>
                                                                        <p class='black3 fs-6 lh-sm'>{$post[$i]["content"]}</p>
                                                                    </div>
                                                                    <div class='line-left text-end d-lg-flex align-content-lg-end justify-content-lg-end' style='width: 30%;' id='card-right-side'>
                                                                        <div class='mt-3'>
                                                                            <i class='bi bi-check-circle green2 fs-1'></i>
                                                                            <p class='mb-0 text-lg-right fs-4 green2 fw-bold' id='material-status'>Turned In</p>
                                                                            <p class='fs-6 green2 fw-bold mb-0' id='material-deadline'>{$month} {$day}, {$year}</p>   
                                                                        </div>                                           
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>";
                                        }
                                    }
                                }
                            ?>
                            
                        </div>

                    </div>
                </div>

                <div class="container mt-4 px-lg-5 px-sm-2">
                    <div class="mt-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <h1 class="h-font green1 me-2 sub-title">Quizzes</h1>
                            <div class="line-h"></div>
                        </div>
                        <div>
                            <?php 

                                if(isset($post[0]['content_type'])){
                                    for($i = 0 ; $i < count($post); $i++){
                                        if($post[$i]['content_type'] == 'Quiz'){
  
                                            echo "<div id='material'>
                                            <button data-bs-toggle='collapse' href='#{$i}' role='button' aria-expanded='false' aria-controls='collapseExample' class='btn container-fluid p-0 m-0'>
                                                <div class='container-fluid bg-body-tertiary d-flex align-content-center justify-content-between rounded-3 px-lg-4 py-2 mb-2 shadow-elevation-dark-1' >
                                                     <div class='d-flex align-content-center'>
                                                         <div>   
                                                            <i class='bi bi-question-circle-fill green1 fs-2 p-0 m-0'></i>
                                                        </div>
                                                        <div class='ms-3 mt-1'> 
                                                            <p class='green2 fw-bold lh-1 fs-5 mb-0 pb-0 d-flex flex-column align-items-start' id='material-title'>
                                                                {$post[$i]["title"]} <br>
                                                                <span class='fw-light green2 fs-6 d-flex mt-1' id='material-date'>{$month} {$day}, {$year}</span>                                         
                                                            </p>
                                                        </div>
                                                    </div>  
                                                    <div class='d-flex align-items-center justify-content-center'>  
                                                        <div>
                                                            <p class='green2 fw-light fs-5 me-2 mb-0 pb-0' id='material-score'> 6/10</p>
                                                        </div>
                                                        <div>";
                                                           ?> <a href='material.php?class=<?php echo md5($details[0]["class_code"]); ?>&post=<?php echo md5($post[$i]['post_id']); ?>'><i class='bi bi-eye-fill green1 fs-2 p-0 m-0'></i></a>
                                                    <?php  echo" </div> 
                                                    </div>
                                                </div>                    
                                            </button>";

                                            echo "<div class='collapse mb-2' id='{$i}'>
                                                        <div class='d-flex flex-column align-items-end justify-content-end' >
                                                            <div class='card card-body rounded-3 bg-body-tertiary shadow-elevation-dark-1 border-0' style='width: 90%;'>
                                                                <div class='mt-0 pt-0 d-flex' id='card-container'>
                                                                    <div class='pe-lg-3' style='width: 70%;' id='card-left-side'>
                                                                        <p class='fs-6 h-font green2 me-2 mb-1'>Description</p>
                                                                        <p class='black3 fs-6 lh-sm'>{$post[$i]["content"]}</p>
                                                                    </div>
                                                                    <div class='line-left text-end d-lg-flex align-content-lg-end justify-content-lg-end' style='width: 30%;' id='card-right-side'>
                                                                        <div class='mt-3'>
                                                                            <i class='bi bi-check-circle green2 fs-1'></i>
                                                                            <p class='mb-0 text-lg-right fs-4 green2 fw-bold' id='material-status'>Turned In</p>
                                                                            <p class='fs-6 green2 fw-bold mb-0' id='material-deadline'>{$month} {$day}, {$year}</p>   
                                                                        </div>                                           
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>";
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
    <br><br><br>
    <br><br><br>
    
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
