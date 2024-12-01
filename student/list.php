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
    <?php require('inc/links.php'); include("student backend/includes/view-list.php");?>
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
                                    <a class="nav-link" href="submittedworks.php?class=<?php echo md5($details[0]["class_code"]); ?>">Submitted Works</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="list.php?class=<?php echo md5($details[0]["class_code"]); ?>">List of Students</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="container mt-4 px-lg-5 px-sm-2">
                    <div class="mt-2" id="professor-container">
                        <div class="">
                            <h1 class="h-font green1 me-2 sub-title mb-0 pb-0">Professor</h1>
                            <div class="line-h mt-0"></div>
                        </div>
                        <div class="ms-3">
                            <div class="d-flex align-items-center mb-3 mt-3" id="professor">
                                 <img src="<?php echo $profDetails[0]["image"]; ?>" style="width: 40px;" class="rounded-5 me-3"></span>
                                 <p class="green1 fw-semibold lh-sm m-0 p-0 fs-5 " id="professor-name"><?php echo $profDetails[0]["name"]; ?></p>
                            </div>                         
                        </div>
                    </div>
                    <div class="mt-2" id="student-container">
                        <div class="">
                            <h1 class="h-font green1 me-2 sub-title mb-0 pb-0">Students</h1>
                            <div class="line-h mt-0"></div>
                        </div>
                        <div class="ms-3 mt-3">
                            <?php 
                              for($i = 0 ; $i < count($studentList); $i++){
                                echo "<div class='d-flex align-items-center mb-2' id='professor'>
                                     <img src='{$studentList[$i]["image"]}' style='width: 40px;' class='rounded-5 me-3'></span>
                                     <p class='green2 fw-semibold lh-sm m-0 p-0 fs-5' id='student-name'>{$studentList[$i]["name"]} </p>
                                     </div>";
                              }
                            ?>
                            <!-- <div class="d-flex align-items-center mb-2" id="professor">
                                <img src="images/mikmik.jpg" style="width: 40px;" class="rounded-5 m-0 me-3"></span>
                                <p class="green2 fw-semibold lh-sm m-0 p-0 fs-5 " id="student-name">Jarmen A. Cachero </p>
                            </div>                          -->
                            <!-- <div class="d-flex align-items-center mb-2" id="professor">
                                <img src="images/mikmik.jpg" style="width: 40px;" class="rounded-5 me-3"></span>
                                <p class="green2 fw-semibold lh-sm m-0 p-0 fs-5 " id="student-name">Jarmen A. Cachero </p>
                            </div>    
                            <div class="d-flex align-items-center mb-2" id="professor">
                                <img src="images/mikmik.jpg" style="width: 40px;" class="rounded-5 m-0 me-3"></span>
                                <p class="green2 fw-semibold lh-sm m-0 p-0 fs-5 " id="student-name">Jarmen A. Cachero </p>
                            </div>                         
                            <div class="d-flex align-items-center mb-2" id="professor">
                                <img src="images/mikmik.jpg" style="width: 40px;" class="rounded-5 me-3"></span>
                                <p class="green2 fw-semibold lh-sm m-0 p-0 fs-5 " id="student-name">Jarmen A. Cachero </p>
                            </div>                         -->
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
