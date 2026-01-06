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

unset($_SESSION["displayQuiz"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted Works</title>
    <?php require('inc/links.php'); include("includes/view-class.php"); include("includes/view-submission.php");
?>
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
                                    <a class="nav-link" href="class.php?class=<?php echo md5($details[0]['class_code']); ?>">Class Name</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="submittedworks.php?class=<?php echo md5($details[0]['class_code']); ?>">Submitted Works</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="list.php?class=<?php echo md5($details[0]['class_code']); ?>">List of Students</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="grades.php?class=<?php echo md5($details[0]['class_code']); ?>">Grades</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <div class="container mt-4 px-lg-5 px-sm-2">
                    <?php
                    // Function to display material (Activity/Quiz/Exam)
                    // if($contentType == "Exam"){
                    //     echo "Submission student id " . $submission["user_id"] . "<br>";
                    //     echo "user student id " . $student["user_id"] . "<br>";
                    //     echo "submission id " . $submission["post_id"] . "<br>";
                    //     echo "post id " . $post[$i]["post_id"] . "<br><br>";
                    // }

                    function displayMaterial($post, $contentType, $studentList, $submissionList, $classCode) {
                        // echo var_dump($submissionList) . "<br><br><br>"; 
                        if (isset($post[0]['content_type'])) {
                            // echo var_dump($studentList);

                            for ($i = 0; $i < count($post); $i++) {
                                if ($post[$i]['content_type'] == $contentType) {
                                 
                                    $turnedIn = [];
                                    $pending = [];

                                    $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                                    $year = $post[$i]["month"][0] . "" . $post[$i]["month"][1] . $post[$i]["month"][2] . "" . $post[$i]["month"][3];
                                    $month = $months[(int)($post[$i]["month"][5] . $post[$i]["month"][6]) - 1];
                                    $day = $post[$i]["month"][8] . "" . $post[$i]["month"][9];

                                    foreach ($studentList as $student) {
                                        $submitted = false;
                                        if ($submissionList != null) {
                                            foreach ($submissionList as $submission) {
                                    
                                                if ($submission['user_id'] == $student['user_id'] && $submission['post_id'] == $post[$i]['post_id']) {
                                                    // if($contentType == "Exam") echo "STUDENT SUBMITT FOUND";
                                                    $submitted = true;
                                                    break;
                                                }
                                            }
                                        }
                                        if ($submitted) {
                                            $turnedIn[] = $student;
                                        } else {
                                            $pending[] = $student;
                                        }
                                    }

                                    $contentTemp = strtolower($contentType);
                                    
                                    echo "
                                    <div id='material'>
                                        <button data-bs-toggle='collapse' href='#collapse_{$i}' role='button' aria-expanded='false' aria-controls='collapse_{$i}' class='btn container-fluid p-0 m-0'>
                                            <div class='container-fluid bg-body-tertiary d-flex align-content-center justify-content-between rounded-3 px-lg-4 py-2 mb-2 shadow-elevation-dark-1'>
                                                <div class='d-flex align-content-center'>
                                                    <div><i class='bi bi-bookmark-fill green1 fs-2 p-0 m-0'></i></div>
                                                    <div class='ms-3 mt-1'>
                                                        <p class='green2 fw-bold lh-1 fs-5 mb-0 pb-0 d-flex flex-column align-items-start' id='material-title'>
                                                            {$post[$i]['title']}
                                                            <span class='fw-light green2 fs-6 d-flex mt-1' id='material-date'>{$month} {$day}, {$year}</span>
                                                        </p>
                                                    </div>
                                                </div>";
                                                if($contentType == "Quiz" || $contentType == "Exam"){
                                                if($contentType == "Exam") $contentTemp = "quiz";

                                                echo"<div class='d-flex align-items-center justify-content-center'>
                                                    <a href='{$contentTemp}-form.php?class=" . md5($classCode) . "&post=" . md5($post[$i]['post_id']) . "'>
                                                        <i class='bi bi-eye-fill green1 fs-2 p-0 m-0'></i>
                                                    </a>";
                                                }else{
                                                    echo"<div class='d-flex align-items-center justify-content-center'>
                                                    <a href='material.php?class=" . md5($classCode) . "&post=" . md5($post[$i]['post_id']) . "'>
                                                        <i class='bi bi-eye-fill green1 fs-2 p-0 m-0'></i>
                                                    </a>";
                                                }
                                            echo"</div>
                                            </div>
                                        </button>

                                        <div class='collapse mb-2' id='collapse_{$i}'>
                                            <div class='d-flex flex-column align-items-end justify-content-end'>
                                                <div class='card card-body rounded-3 bg-body-tertiary shadow-elevation-dark-1 border-0' style='width: 90%;'>
                                                    <div class='mt-0 pt-0 d-flex' id='card-container'>
                                                        <div class='pe-lg-3' style='width: 100%;'>
                                                            <p class='fs-6 h-font green2 me-2 mb-1'>Turned In</p>
                                                            <div class='row px-2'>";

                                    foreach ($turnedIn as $student) {
                                        if($contentType == "Quiz" || $contentType == "Exam"){
                                            if($contentType == "Exam") $contentTemp = "quiz";
    
                                            echo "<a href='{$contentTemp}-material.php?class=" . md5($classCode) . "&post=" . md5($post[$i]['post_id']) . "&user=" . md5($student['user_id']) . "' class='col-lg-4 col-md-6 col-sm-12 p-1 mb-1'>
                                                <div class='d-flex align-items-center justify-content-start p-2 white-btn rounded-4' style='width: 95%;'>
                                                    <img src='{$student['image']}' style='width: 20px;' class='rounded-5 me-3'>
                                                    <p class='student_name green2 fw-semibold lh-sm m-0 p-0 fs-6'>{$student['name']}</p>
                                                </div>
                                            </a>";
                                        }else{
                                            echo "<a href='material.php?class=" . md5($classCode) . "&post=" . md5($post[$i]['post_id']) . "&user=" . md5($student['user_id']) . "' class='col-lg-4 col-md-6 col-sm-12 p-1 mb-1'>
                                                <div class='d-flex align-items-center justify-content-start p-2 white-btn rounded-4' style='width: 95%;'>
                                                    <img src='{$student['image']}' style='width: 20px;' class='rounded-5 me-3'>
                                                    <p class='student_name green2 fw-semibold lh-sm m-0 p-0 fs-6'>{$student['name']}</p>
                                                </div>
                                            </a>";
                                        }
                                    }
                                    echo "               </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>";

                                    // Display pending students
                                    echo "<div class='d-flex flex-column align-items-end justify-content-end mt-3'>
                                            <div class='card card-body rounded-3 bg-body-tertiary shadow-elevation-dark-1 border-0' style='width: 90%;'>
                                                <div class='mt-0 pt-0 d-flex'>
                                                    <div class='pe-lg-3' style='width: 100%;'>
                                                        <p class='fs-6 h-font black2 me-2 mb-1'>Pending</p>
                                                        <div class='row px-2'>";
                                    foreach ($pending as $student) {
                                        if($contentType == "Quiz" || $contentType == "Exam"){
                                        if($contentType == "Exam") $contentTemp = "quiz";

                                        echo "<a href='{$contentTemp}-material.php?class=" . md5($classCode) . "&post=" . md5($post[$i]['post_id']) . "&user=" . md5($student['user_id']) . "' class='col-lg-4 col-md-6 col-sm-12 p-1 mb-1'>
                                                <div class='d-flex align-items-center justify-content-start p-2 white-btn rounded-4' style='width: 95%;'>
                                                    <img src='{$student['image']}' style='width: 20px;' class='rounded-5 me-3'>
                                                    <p class='student_name green2 fw-semibold lh-sm m-0 p-0 fs-6'>{$student['name']}</p>
                                                </div>
                                            </a>";
                                        }else{
                                            echo "<a href='material.php?class=" . md5($classCode) . "&post=" . md5($post[$i]['post_id']) . "&user=" . md5($student['user_id']) . "' class='col-lg-4 col-md-6 col-sm-12 p-1 mb-1'>
                                                <div class='d-flex align-items-center justify-content-start p-2 white-btn rounded-4' style='width: 95%;'>
                                                    <img src='{$student['image']}' style='width: 20px;' class='rounded-5 me-3'>
                                                    <p class='student_name green2 fw-semibold lh-sm m-0 p-0 fs-6'>{$student['name']}</p>
                                                </div>
                                            </a>";
                                        }
                                    }
                                    echo "               </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                                }
                            }
                        }
                    }

                    // Display Activities
                    echo "<div class='mt-4'>
                            <div class='d-flex align-items-center justify-content-between'>
                                <h1 class='h-font green1 me-2 sub-title'>Activities</h1>
                                <div class='line-h'></div>
                            </div>";
                    displayMaterial($post, 'Activity', $studentList, $actSubmission, $details[0]['class_code']);
                    echo "</div>";

                    // Display Quizzes
                    echo "<div class='mt-4'>
                            <div class='d-flex align-items-center justify-content-between'>
                                <h1 class='h-font green1 me-2 sub-title'>Quizzes</h1>
                                <div class='line-h'></div>
                            </div>";
                    displayMaterial($post, 'Quiz', $studentList, $quizSubmission, $details[0]['class_code']);
                    echo "</div>";

                    // Display Exams
                    echo "<div class='mt-4'>
                            <div class='d-flex align-items-center justify-content-between'>
                                <h1 class='h-font green1 me-2 sub-title'>Exams</h1>
                                <div class='line-h'></div>
                            </div>";
                    displayMaterial($post, 'Exam', $studentList, $examSubmission, $details[0]['class_code']);
                    echo "</div>";
                    
                    echo "<div class='mt-4'>
                            <div class='d-flex align-items-center justify-content-between'>
                                <h1 class='h-font green1 me-2 sub-title'>Seatworks</h1>
                                <div class='line-h'></div>
                            </div>";
                    displayMaterial($post, 'Seatwork', $studentList, $seatworkSubmission, $details[0]['class_code']);
                    echo "</div>";
                    
                    echo "<div class='mt-4'>
                            <div class='d-flex align-items-center justify-content-between'>
                                <h1 class='h-font green1 me-2 sub-title'>Assignments</h1>
                                <div class='line-h'></div>
                            </div>";
                    displayMaterial($post, 'Assignment', $studentList, $assignmentSubmission, $details[0]['class_code']);
                    echo "</div>";
            
                    
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php require('inc/footer.php'); ?>   

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
