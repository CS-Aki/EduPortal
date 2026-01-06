<?php 
if (session_id() === "") session_start();

if(!isset($_SESSION["user_category"])){
    header("Location: ../index.php");
}

if(isset($_SESSION["user_category"])){
    $category = $_SESSION["user_category"];
    switch($category){
        case 1: header("Location: ../admin/admin-dashboard.php"); exit(); break;
        case 2: header("Location: ../staff/staff-dashboard.php"); exit(); break;
        case 3: header("Location: ../instructor/instructor-dashboard.php"); exit(); break;
        // case 4: header("Location: student/student-dashboard.php"); break;
    }
}else{
    header("Location: ../");
    exit();
}

include("student backend/includes/get-grades.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grades</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
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
    <?php require('inc/links.php'); include("student backend/includes/view-profile.php"); ?>

</head>
<body>
    <?php require('inc/header.php'); ?>
    <div class="container-fluid p-0 m-0" id="main-content">
        <div class="row">
            <div class="col-lg-10 col-sm-12 ms-auto ">
                
                <div class="container-fluid p-0 p-lg-3 mt-3  px-4" style="width: 100%;">
                    <div class="d-flex justify-content-start mb-3"> 
                        <h1 class="h-font sub-title green1 me-2 title lh-1" id="pageTitle">Grades List</h1>
                    </div>
                    <table id="myTable" class="table table-bordered text-center align-middle" style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col">Class Code</th>
                                <th scope="col">Class</th>
                                <th scope="col">Activity</th>
                                <th scope="col">Quiz</th>
                                <th scope="col">Seatwork</th>
                                <th scope="col">Assignment</th>
                                <th scope="col">Exam</th>
                                <th scope="col">Final Grade</th>
                      
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($grades != null || $total != null || $gradingSystem != null){
                                        for($i = 0; $i < count($gradingSystem); $i++){
                                            // $year = "";
                                            // $studentCode = substr($studentList[$i]["created"], 0, 4);
                                            // $year .= $studentCode;

                                            // for($j = strlen($studentList[$i]["user_id"]); $j < 4; $j++){
                                            //     $year .= "0";
                                            // }
                                            // // echo $year;
                                            
                                            // $year .= $studentList[$i]["user_id"] . "-S";

                                            $actGSys = $gradingPerClass[$gradingSystem[$i]["class_code"]]["act_wg"] / 100;

                                            $calculatedActScore = 0;
                                            $calculatedQuizScore = 0;
                                            $calculatedExamScore = 0;
                                            $calculatedSeatworkScore = 0;
                                            $calculatedAssignmentScore = 0;
                                            $actSum = 0;
                                            $quizSum = 0;
                                            $examSum = 0;
                                            $seatworkSum = 0;
                                            $assignmentSum = 0;

                                            foreach ($actScores as $class_code => $score) {
                                                if($class_code == $gradingSystem[$i]["class_code"]){
                                                    $actSum = ceil(($score / $totalPerClass[$gradingSystem[$i]["class_code"]]["Activity"]));
                                                    $calculatedActScore = ceil(($score / $totalPerClass[$gradingSystem[$i]["class_code"]]["Activity"]) * $actGSys);
                                                    break;
                                                }
                                            }
                                            
                                            $quizGSys = $gradingPerClass[$gradingSystem[$i]["class_code"]]["quiz_wg"] / 100;
                                            
                                            foreach ($quizScores as $class_code => $score) {
                                                if($class_code == $gradingSystem[$i]["class_code"]){
                                                    $quizSum = ceil(($score / $totalPerClass[$gradingSystem[$i]["class_code"]]["Quiz"]));
                                                    $calculatedQuizScore = ceil(($score / $totalPerClass[$gradingSystem[$i]["class_code"]]["Quiz"]) * $quizGSys);
                                                    break;
                                                }
                                            }

                                            $examGSys = $gradingPerClass[$gradingSystem[$i]["class_code"]]["exam_wg"] / 100;
                                                foreach ($examScores as $class_code => $score) {
                                                     if($class_code == $gradingSystem[$i]["class_code"]){
                                                         $examSum = ceil(($score / $totalPerClass[$gradingSystem[$i]["class_code"]]["Exam"]));
                                                         $calculatedExamScore = ceil(($score / $totalPerClass[$gradingSystem[$i]["class_code"]]["Exam"]) * $examGSys);
                                                         break;
                                                     }
                                                 }
                                                 
                                            $seatworkGSys = $gradingPerClass[$gradingSystem[$i]["class_code"]]["seatwork_wg"] / 100;
                                            
                                            foreach ($seatworkScores as $class_code => $score) {
                                                if($class_code == $gradingSystem[$i]["class_code"]){
                                                    $seatworkSum = ceil(($score / $totalPerClass[$gradingSystem[$i]["class_code"]]["Seatwork"]));
                                                    $calculatedSeatworkScore = ceil(($score / $totalPerClass[$gradingSystem[$i]["class_code"]]["Seatwork"]) * $examGSys);
                                                    break;
                                                }
                                            }
                                            
                                            $assignmentGSys = $gradingPerClass[$gradingSystem[$i]["class_code"]]["assignment_wg"] / 100;
                                            
                                            foreach ($assignmentScores as $class_code => $score) {
                                                if($class_code == $gradingSystem[$i]["class_code"]){
                                                    $assignmentSum = ceil(($score / $totalPerClass[$gradingSystem[$i]["class_code"]]["Assignment"]));
                                                    $calculatedAssignmentScore = ceil(($score / $totalPerClass[$gradingSystem[$i]["class_code"]]["Assignment"]) * $examGSys);
                                                    break;
                                                }
                                            }

                                            $sum = $calculatedActScore + $calculatedQuizScore + $calculatedExamScore + $calculatedSeatworkScore + $calculatedAssignmentScore;

                                                echo "<tr>
                                                    <td>{$gradingSystem[$i]['class_code']}</td>
                                                    <td>{$gradingSystem[$i]['class_name']}</td>
                                                    <td>{$actSum}%</td>
                                                    <td>{$quizSum}%</td>
                                                    <td>{$seatworkSum}%</td>
                                                    <td>{$assignmentSum}%</td>
                                                    <td>{$examSum}%</td>";
                                                echo"<td>{$sum}%</td>
                                                </tr>
                                            ";
                                        }
                                }else if($studentList != null){
                                  
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
                                                <td>{$gradingSystem[$i]['class_code']}</td>
                                                <td>{$gradingSystem[$i]['class_name']}</td>
                                                <td>0%</td>
                                                <td>0%</td>
                                                <td>0%</td>
                                                <td>0%</td>
                                                <td>0%</td>
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
    <br><br>

        <?php require('inc/footer.php'); ?>
        
            
        <script>
            console.log("test");
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
                        emptyTable: "No Grades Available"
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
        </script>
        
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
