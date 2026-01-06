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
    <title>Grades</title>
    <style>
        .table thead th{
            background-color: #219E53 !important; 
            color: #FCFCFC !important; 
            border: #219E53;
        }
        .table td {
            font-weight: semibold;
            color: #6B656B;
        }
        
        .dataTables_info {
            color: #989598 !important; /* Change color */
        }
        .active >.page-link {
            background-color: #219E53 !important;
            color: #FCFCFC !important;
            border-color: #219E53 !important;
        }
        .page-link {
            color: #219E53 !important;
        }
        #myTable_filter input {
            border: 2px solid #4CAF50; /* Green border */
            padding: 5px 1em;
            color: #333;               /* Text color inside the input */
            border-radius: 50px;
        }
        #myTable_filter label {
            color: #56B37B; /* Change this color to whatever you prefer */
        }
    </style>
    <?php require('inc/links.php'); include("includes/view-submission.php"); include("includes/view-list.php");?>
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
                                    <a class="nav-link" href="list.php?class=<?php echo md5($details[0]["class_code"]); ?>">List of Students</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="grades.php?class=<?php echo md5($details[0]["class_code"]); ?>">Grades</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="container-fluid p-0 px-lg-5 pt-3 mt-0 px-3" style="width: 100%;">
                    <div class="d-flex justify-content-start mb-1"> 
                        <h1 class="h-font sub-title green1 me-2 title lh-1" id="pageTitle">Grades List</h1>
                    </div>
                    <table id="myTable" class="table table-bordered text-center align-middle" style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col">Student Code</th>
                                <th scope="col">Name</th>
                                <th scope="col">Activity</th>
                                <th scope="col">Quiz</th>
                                <th scope="col">Seatwork</th>
                                <th scope="col">Assignment</th>
                                <th scope="col">Exam</th>
                                <th scope="col">Grade</th>
                      
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($examSubmission != null || $actSubmission != null || $quizSubmission != null || $seatworkSubmission != null || $assignmentSubmission != null){
                                 
                                    for($i = 0; $i < count($studentList); $i++){
                                        $year = "";
                                        $studentCode = substr($studentList[$i]["created"], 0, 4);
                                        $year .= $studentCode;

                                        for($j = strlen($studentList[$i]["user_id"]); $j < 4; $j++){
                                            $year .= "0";
                                        }
                                        // echo $year;
                                        
                                        $year .= $studentList[$i]["user_id"] . "-S";

                                        $actGSys = $gradingSystem[0]["act_wg"] / 100;

                                        $calculatedActScore = 0;
                                        $calculatedQuizScore = 0;
                                        $calculatedExamScore = 0;
                                        $calculatedSeatworkScore = 0;
                                        $calculatedAssignmentScore = 0;
                                        $activitySum = 0;
                                        $quizSum = 0;
                                        $examSum = 0;
                                        $seatworkSum = 0;
                                        $assignmentSum = 0;

                                        foreach ($actScores as $user_id => $score) {
                                            if($user_id == $studentList[$i]["user_id"]){
                                                $calculatedActScore = ceil(($score / $totalAct) * $actGSys);
                                                $activitySum = ceil($score / $totalAct);
                                                    break;
                                            }
                                        }
                                        
                                        $quizGSys = $gradingSystem[0]["quiz_wg"] / 100;
                                        
                                        foreach ($quizScores as $user_id => $score) {
                                            if($user_id == $studentList[$i]["user_id"]){
                                                $calculatedQuizScore = ceil(($score / $totalQuiz) * $quizGSys);
                                                $quizSum = ceil($score / $totalQuiz);
                                                break;
                                            }
                                        }

                                        $examGSys = $gradingSystem[0]["exam_wg"] / 100;

                                        foreach ($examScores as $user_id => $score) {
                                            if($user_id == $studentList[$i]["user_id"]){
                                                $calculatedExamScore = ceil(($score / $totalExam) * $examGSys);
                                                $examSum = ceil($score / $totalExam);
                                                break;
                                            }
                                        }
                                        
                                        $seatworkGSys = $gradingSystem[0]["seatwork_wg"] / 100;

                                        foreach ($seatworkScores as $user_id => $score) {
                                            if($user_id == $studentList[$i]["user_id"]){
                                                $calculatedSeatworkScore = ceil(($score / $totalSeatwork) * $seatworkGSys);
                                                $seatworkSum = ceil($score / $totalSeatwork); 
                                                break;
                                            }
                                        }
                                        
                                        $assignmentGSys = $gradingSystem[0]["assignment_wg"] / 100;

                                        foreach ($assignmentScores as $user_id => $score) {
                                            if($user_id == $studentList[$i]["user_id"]){
                                                $calculatedAssignmentScore = ceil(($score / $totalAssignment) * $assignmentGSys);
                                                $assignmentSum = ceil($score / $totalAssignment);
                                                break;
                                            }
                                        }

                                        $sum = $calculatedActScore + $calculatedQuizScore + $calculatedExamScore + $calculatedSeatworkScore + $calculatedAssignmentScore;

                                            echo "<tr>
                                                <td>{$year}</td>
                                                <td>{$studentList[$i]['name']}</td>
                                                <td>{$activitySum}%</td>
                                                <td>{$quizSum}%</td>
                                                <td>{$seatworkSum}%</td>
                                                <td>{$assignmentSum}%</td>
                                                <td>{$examSum}%</td>";
                                           echo"<td>{$sum}%</td>
                                            </tr>
                                        ";
                                    }
                            }else{
                                for($i = 0; $i < count($studentList); $i++){
                                    $year = "";
                                    $studentCode = substr($studentList[$i]["created"], 0, 4);
                                    $year .= $studentCode;

                                    for($j = strlen($studentList[$i]["user_id"]); $j < 4; $j++){
                                        $year .= "0";
                                    }
                                    // echo $year;
                                    
                                    $year .= $studentList[$i]["user_id"] . "-S";

                                    echo "<tr>
                                            <td>{$year}</td>
                                            <td>0%</td>
                                            <td>0%</td>
                                            <td>0%</td>
                                            <td>0%</td>
                                            <td>0%</td>
                                            <td>{$studentList[$i]['name']}</td>
                                            <td>0%</td>
                                        </tr>
                                     ";
                                }
                            }?>

                        </tbody>
                    </table>
                </div>

                
            </div>
        </div>
    </div>
    <br><br><br>
    <br><br><br>
    <?php require('inc/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: true,
                pageLength: 10,
                language: {
                    search: "Filter records:",
                   
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'csv',
                        className: 'btn btn-success',
                        text: 'Export CSV'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-info',
                        text: 'Print'
                    }
                ]
            });
        });
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
