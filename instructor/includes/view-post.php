<?php 

// if(isset($_GET["temp"])){
//     require_once("../../../log and reg backend/classes/connection.php");
//     require_once("../classes/model.ClassRm.php");
//     require_once("../classes/controller.Lists.php");
//     require_once("../classes/controller.Student.php");
// }else{
//     require_once("../log and reg backend/classes/connection.php");
//     require_once("student backend/classes/model.ClassRm.php");
//     require_once("student backend/classes/controller.Lists.php");
//     require_once("student backend/classes/controller.Student.php");
// }
if(isset($_GET["temp"])){
    require_once("../../log and reg backend/classes/connection.php");
    require_once("../classes/model.Prof.php");
    require_once("../classes/controller.Prof.php");
}else{
    require_once("../log and reg backend/classes/connection.php");
    require_once("classes/model.Prof.php");
    require_once("classes/controller.Prof.php");
}


if(isset($_GET["post"])){
    
    if (session_id() === "") session_start();   
    
    $postID =  $_GET["post"];
    $instrCtrlr = new InstructorController();

    // sleep(5);
    // $stdController = new StudentController();
    if(isset($_GET["code"])) $classCode = $_GET["code"];
    else $classCode = $_GET["class"];

    $postDetails = $instrCtrlr->getPostDetails($postID, $classCode);
    $comments = $instrCtrlr->getComments($postID, $classCode);
    $files = $instrCtrlr->getFiles($postID, $classCode);
    $startingDateTime = null;
    $deadlineDateTime = null;
    // echo var_dump($postDetails);
    // echo var_dump($files);
    // echo var_dump($postDetails);
    // $postDetails = $stdController->getPostDetails($postTitle, $classCode);
    // $comments = $stdController->getComments($postTitle, $classCode);
    // echo var_dump($comments);
    // if($postDetails[0]["content_type"] == "Quiz"){
    //     $yourScore = array();
    //     $currentAttempt = 0;
    //     $quizContent = $stdController->getQuizContent($postId, $classCode);
    //     $quizStatus = $stdController->getQuizStatus($postId, $classCode, $_SESSION["id"]);
    //     // $quizAttempt = $stdController->getQuizAttempt($postId, $_SESSION["id"]);
    //     $submittedQuiz = $stdController->getQuizResult($postId, $classCode, $_SESSION["id"]);
    //     $totalScore = 0;
    //     $totalCorrectAnsCount = array();
    //     $j = 0;
    //     // echo var_dump($submittedQuiz);
    //     if($submittedQuiz != null){
    //         for ($i = 0; $i < count($submittedQuiz); $i++) {
    //             // echo $currentAttempt;
    //             if ($submittedQuiz[$i]["attempt"] != $currentAttempt) {
    //                 $totalScore = $submittedQuiz[$i]["score"];
    //                 $currentAttempt = $submittedQuiz[$i]["attempt"];
    //                 $yourScore[$currentAttempt] = 0;
        
    //                 // Initialize totalCorrectAnsCount for this attempt
    //                 if (!isset($totalCorrectAnsCount[$currentAttempt])) {
    //                     $totalCorrectAnsCount[$currentAttempt] = 0;
    //                 }
        
    //                 if ($submittedQuiz[$i]["status"] == 1) {
    //                     $yourScore[$currentAttempt] = $submittedQuiz[$i]["score"];
    //                     $totalCorrectAnsCount[$currentAttempt] = 1;
    //                 }
    //             } else {
    //                 $totalScore += $submittedQuiz[$i]["score"];
    //                 $j++;
    //                 if (!isset($totalCorrectAnsCount[$currentAttempt])) {
    //                     $totalCorrectAnsCount[$currentAttempt] = 0;
    //                 }
        
    //                 if ($submittedQuiz[$i]["status"] == 1) {
    //                     $yourScore[$currentAttempt] += $submittedQuiz[$i]["score"];
    //                     $totalCorrectAnsCount[$currentAttempt] += 1;
    //                 }
    //             }
    //         }
    //         $totalItems = count($submittedQuiz) / count($yourScore);
    //         $attemptNum = count($totalCorrectAnsCount);
    //         // echo "Attempt count " . count($totalCorrectAnsCount);
    //     }

    //     // echo var_dump($totalCorrectAnsCount);
    //     $startingDateTime = date("F j, Y g:i A", strtotime($quizContent[0]["starting_date"] . " " . $quizContent[0]["starting_time"]));
    //     $deadlineDateTime = date("F j, Y g:i A", strtotime($quizContent[0]["deadline_date"] . " " . $quizContent[0]["deadline_time"]));  
        
    // }

    // if(isset($comments[0]["month"])){
        $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $year = $postDetails[0]["month"][0] . "" . $postDetails[0]["month"][1] . $postDetails[0]["month"][2] . "" . $postDetails[0]["month"][3];
        $month = $months[$postDetails[0]["month"][5] . "" . $postDetails[0]["month"][6] - 1];
        $day = $postDetails[0]["month"][8] . "" . $postDetails[0]["month"][9];
    //  }else{
    //     $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    //     $year = $postDetails[0]["month"][0] . "" . $postDetails[0]["month"][1] . $postDetails[0]["month"][2] . "" . $postDetails[0]["month"][3];
    //     $month = $months[$postDetails[0]["month"][5] . "" . $postDetails[0]["month"][6] - 1];
    //     $day = $postDetails[0]["month"][8] . "" . $postDetails[0]["month"][9];
    //  }

    if(isset($_GET["temp"])){
        // $comments[count($comments) - 1]["id"] = $_SESSION["id"];
        header('content-type: application/json');
        echo json_encode($comments);
    }

    // echo var_dump($comments);
}