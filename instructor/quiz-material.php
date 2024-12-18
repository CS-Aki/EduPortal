<?php
if (session_id() === "") session_start();

if(isset($_SESSION["user_category"])){
    $category = $_SESSION["user_category"];
    switch($category){
        case 1: header("Location: ../admin/admin-dashboard.php"); exit(); break;
        case 2: header("Location: ../staff/staff-dashboard.php"); break;
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.19.0/js/md5.min.js"></script>
    <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }

            .question {
                margin-bottom: 15px;
            }

            .options,
            .question-settings {
                margin-top: 10px;
            }

            button {
                margin-top: 20px;
            }

            textarea.form-control {
                resize: none;
            }

            .btn-danger {
                background-color: #dc3545;
                border: none;
            }

            .btn-secondary {
                background-color: #6c757d;
                border: none;
            }

            .options .form-floating {
                margin-bottom: 10px;
            }

            .d-flex.align-items-center {
                display: flex;
                align-items: center;
            }

            input[type="radio"] {
                appearance: none;
                /* Remove default styling */
                width: 20px;
                height: 20px;
                border: 2px solid #ccc;
                border-radius: 50%;
                outline: none;
                cursor: pointer;
                transition: border-color 0.3s, background-color 0.3s;
            }

            input[type="text"] {
                border: 1px solid #989598 !important;
                color: #989598 !important;
            }

            input[type="radio"]:checked {
                background-color: #219E53 !important;
                border-color: #219E53 !important;
            }

            .quizborder {
                border: 1px solid var(--black3);
            }
            .correct {
                border: 1px solid var(--green1);
            }
            .wrong {
                border: 1px solid var(--red);
            }

            .gray-out {
                background-color: gray; /* Change to your desired gray color */
                color: white; /* Change text color if needed */
                opacity: 0.5; /* Adjust opacity to make it look grayed out */
                pointer-events: none; /* Disable interaction */
            }

            a.disabled {
                pointer-events: none;
                cursor: default;
            }

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

            #editProfModal .dataTables_scroll {

            width: 100% !important;

            }

            #editProfModal .dataTables_scrollHeadInner,

            #editProfModal table.dataTable {

                width: 100% !important;

            }

            .container {
                position: relative; /* Set the parent container to relative */
            }

            .done-badge {
                position: absolute; /* Position the badge absolutely */
                top: 0; /* Align to the top */
                right: 0; /* Align to the right */
                margin: 10px; /* Optional: Add some margin for spacing */
            }
        
    </style>
    <?php require('inc/links.php'); ?>
</head>

<body>
    <?php if (isset($_GET["class"])) {include("includes/view-quiz.php"); 
    } ?>
    <?php require('inc/header.php');  ?>

    <div class="container-fluid p-0 m-0" id="main-content">
        <div class="row">
            <div class="col-lg-10 col-sm-12 ms-auto">
                <nav class="navbar navbar-expand-lg sticky-top line fs-5 z-2" style="background-color: white">
                    <div class="container-fluid sticky-top">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse green1" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link active" href="class.php?class=<?php echo md5($postDetails[0]["class_code"]); ?>">Class Name</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="submittedworks.php?class=<?php echo md5($postDetails[0]["class_code"]); ?>">Submitted Works</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="list.php?class=<?php echo md5($postDetails[0]["class_code"]); ?>">List of Students</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="grades.php?class=<?php echo md5($details[0]["class_code"]); ?>">Grades</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="container-fluid mt-4 px-lg-5 px-sm-4">
                    <p id="post-id" hidden><?php echo $postDetails[0]["post_id"]; ?></p>
                    <div class="mt-2">
                        <div class="d-flex px-3">
                            <div id="icon-material">
                                <i class="bi bi-question-circle-fill green1 fs-1 p-0 m-0 me-3"></i>
                            </div>
                            <div class="w-100">
                                <div>
                                    <h1 class="h-font green1 me-2 sub-title mb-0" id="material-title"><?php echo $postDetails[0]["title"]; ?></h1>
                                    <!-- <p class="fw-light green2 fs-6 d-flex m-0" id="material-date"><?php echo $month . " ". $day . ", " . $year; ?></p>  -->
                                    <p class="fw-light green2 fs-6 d-flex m-0" id="material-date">Starting Date: <?php  echo $startingDateTime; ?></p>   
                                    <p class="fw-light green2 fs-6 d-flex m-0" id="material-date">Deadline Date: <?php echo $deadlineDateTime; ?></p>   
                                    <p class="fw-light red fs-6 d-flex m-0" id="material-date">Max Attempt: <?php echo $quizContent[0]["attempt"]; ?></p>   
                                </div>
                                <div class="mt-3" id="material-description">
                                    <p class="black3 fs-6 lh-sm">
                                        Description: <?php echo $postDetails[0]["content"]; ?>
                                    </p>                         
                                </div>
                                <?php ?>
                                <div class="container-fluid p-0">
                                    <h1 class="h-font green2 text-center sub-title mb-0" id="material-title"><?php echo $firstName;?>'s Work</h1><br>
                                    
                                    <div class="row justify-content-center"> 
                                        
                                    </div>
                                </div><br>
                                
                                <div class="container-fluid mt-2 m-0 p-0 table-responsive" id="table-container">
                                    <table id="classTable" class="table table-bordered text-center align-middle teble-responsive">
                                        <thead>
                                            <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Items</th>
                                            <th scope="col">Points</th>
                                            <th scope="col">Grade</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">View</th>
                                        
                                            </tr>
                                        </thead>
                                        <tbody>
                                                
                                            <?php  
                                                // echo $yourScore[1];
                                                // echo count($quizStatus);
                                                $j = 0;
                                                // echo var_dump($quizStatus);

                                                if (count($yourScore) > 0) {
                                                    // echo $_SESSION["attempt"];
                                                    foreach ($yourScore as $attempt => $score) { 
                                                        // Ensure $totalCorrectAnsCount and $totalItems are defined
                                                        $correctCount = isset($totalCorrectAnsCount[$attempt]) ? $totalCorrectAnsCount[$attempt] : 0;
                                                        $grade = ($totalItems > 0) ? ($correctCount / $totalItems) * 100 : 0;

                                                        ?>
                                                        <tr>
                                                            <td><?php echo $attempt; ?></td>
                                                            <td><?php echo $correctCount; ?> / <?php echo $totalItems; ?></td>
                                                            <td>
                                                                Your Points: <?php echo $score; ?> <br> 
                                                                Total Points: <?php echo $totalScore; ?> <br> 
                                                                Result: 
                                                                <span class="badge rounded-pill text-bg-<?php echo ($grade >= 70) ? "success" : "danger"; ?>">
                                                                    <?php if($postDetails[0]["content_type"] == "Exam") echo ($examGrades[$j]["grade"] >= 70) ? "Passed" : "Failed"; 
                                                                           else echo ($quizGrades[$j]["grade"] >= 70) ? "Passed" : "Failed"; 
                                                                    ?>
                                                                </span>
                                                            </td>
                                                            <td><?php if($postDetails[0]["content_type"] == "Exam") echo ceil($examGrades[$j]["grade"]) . "%"; 
                                                                      else echo ceil($quizGrades[$j]["grade"]) . "%" ?>
                                                                    </td>
                                                            <td><?php 
                                                                
                                                                 if($quizStatus != null && $quizStatus[$j]["status"] == "On Time"){
                                                                    echo '<span class="badge rounded-pill text-bg-success">Finished</span>';
                                                                
                                                                 }else{
                                                                    echo '<span class="badge rounded-pill text-bg-danger">Finished Late</span>';
                                                          
                                                                 }
                                                                 $j++;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <a href='quiz-result.php?class=<?php echo md5($postDetails[0]["class_code"]); ?>&post=<?php echo md5($postDetails[0]["post_id"]); ?>&user=<?php echo $_GET["user"];?>&attempt=<?php echo $attempt; ?>' class="green2">View</a>
                                                            </td>
                                                        </tr>
                                                        <?php 
                                                    }
                                                } 
                                                
                                                ?>
                                              <!--<tr>
                                                <td>2</td>
                                                <td>Quiz: Quiz 1 <br> Quiz: Sorting Algorithm</td>
                                                <td>Correct Answers: 49 <br> Total Points: 80 <br> Result: <span class="badge rounded-pill text-bg-danger">Failed</span></td>
                                                <td><span class="badge rounded-pill text-bg-success">Finished</span></td>
                                                <td><a href="#" class="green2">View</a></td>
                                            </tr> -->
                                            <?php if($submittedQuiz == null){ ?>
                                            <tr>
                                                <td colspan="6">No record</td>
                                            </tr> 
                                            <?php }?>
                                        </tbody>
                                    </table> 
                                </div>

                                <div class="line2 mt-5"></div>
                                <div class="w-75 mt-4" id="material-comment-container">
                                    <div class="input-group mt-lg-2">
                                        <span class="input-group-text rounded-start-5 bg-white ps-3"><img src="<?php if(isset($_SESSION["profile"])){ echo "../profiles/".$_SESSION["profile"]; } else{ echo "../profiles/profile.png"; }  ?>" style="width: 35px;" class="rounded-5"></span>
                                        <textarea class="form-control py-3 black3 5 border-start-0 border-end-0 fs-6" id="commentArea" style="resize: none;" rows="1" aria-label="With textarea" placeholder="Leave a comment..."></textarea>
                                        <span class="input-group-text rounded-end-5 bg-white">                                        
                                            <a href="" class="align-items-end green1 fs-3 pe-2 comment-btn"><i class="bi bi-send-fill"></i></a>
                                        </span>
                                    </div>
                                </div>
                                <div class="ms-lg-3 mt-4">
                                        <div id="comments"></div>
                                </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <div id="postIdValue" hidden><?php echo $postDetails[0]["post_id"]; ?></div>
    <div id="classCodeValue" hidden><?php echo $postDetails[0]["class_code"]; ?></div>
    <?php require('inc/footer.php'); ?>

    <!-- <script src="scripts/submit-quiz.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>