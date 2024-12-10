<?php 


if(isset($_GET["post"])){
    if(isset($_GET["temp"])){
        require_once("../../../log and reg backend/classes/connection.php");
        require_once("../classes/model.ClassRm.php");
        require_once("../classes/controller.Lists.php");
        require_once("../classes/controller.Student.php");
    }else{
        require_once("../log and reg backend/classes/connection.php");
        require_once("student backend/classes/model.ClassRm.php");
        require_once("student backend/classes/controller.Lists.php");
        require_once("student backend/classes/controller.Student.php");
    }

    $postId =  $_GET["post"];
    // if(isset($_SESSION["storedId"])){
    //     $postId = $_SESSION["storedId"];
    // }
    $_SESSION["storedId"] = $postId;
    $stdController = new StudentController();
    $timezone =  new DateTimeZone('Asia/Manila');
    date_default_timezone_set('Asia/Manila');
    if(isset($_GET["code"])) $classCode = $_GET["code"];
    else $classCode = $_GET["class"];

    // if(isset($_SESSION["storedCode"])){
    //     $classCode = $_SESSION["storedCode"];
    // }
    // echo $classCode;
    $postDetails = $stdController->getPostDetails($postId, $classCode);
    $comments = $stdController->getComments($postId, $classCode);
    $files = $stdController->getFiles($postId, $classCode);
    // echo var_dump($postDetails);
    $submissions = $stdController->getSubmittedFiles($postId, $classCode);
    // echo var_dump($postDetails);
    if($postDetails[0]["content_type"] == "Quiz"){
        $yourScore = array();
        $currentAttempt = 0;
        $quizContent = $stdController->getQuizContent($postId, $classCode);
        $quizStatus = $stdController->getQuizStatus($postId, $classCode, $_SESSION["id"]);
        // $quizAttempt = $stdController->getQuizAttempt($postId, $_SESSION["id"]);
        $submittedQuiz = $stdController->getQuizResult($postId, $classCode, $_SESSION["id"]);
        $totalScore = 0;
        $totalCorrectAnsCount = array();
        $j = 0;
        // echo var_dump($submittedQuiz);
        if($submittedQuiz != null){
            for ($i = 0; $i < count($submittedQuiz); $i++) {
                // echo $currentAttempt;
                if ($submittedQuiz[$i]["attempt"] != $currentAttempt) {
                    $totalScore = $submittedQuiz[$i]["score"];
                    $currentAttempt = $submittedQuiz[$i]["attempt"];
                    $yourScore[$currentAttempt] = 0;
        
                    // Initialize totalCorrectAnsCount for this attempt
                    if (!isset($totalCorrectAnsCount[$currentAttempt])) {
                        $totalCorrectAnsCount[$currentAttempt] = 0;
                    }
        
                    if ($submittedQuiz[$i]["status"] == 1) {
                        $yourScore[$currentAttempt] = $submittedQuiz[$i]["score"];
                        $totalCorrectAnsCount[$currentAttempt] = 1;
                    }
                } else {
                    $totalScore += $submittedQuiz[$i]["score"];
                    $j++;
                    if (!isset($totalCorrectAnsCount[$currentAttempt])) {
                        $totalCorrectAnsCount[$currentAttempt] = 0;
                    }
        
                    if ($submittedQuiz[$i]["status"] == 1) {
                        $yourScore[$currentAttempt] += $submittedQuiz[$i]["score"];
                        $totalCorrectAnsCount[$currentAttempt] += 1;
                    }
                }
            }
            $totalItems = count($submittedQuiz) / count($yourScore);
            $attemptNum = count($totalCorrectAnsCount);
            // echo "Attempt count " . count($totalCorrectAnsCount);
        }

        // echo var_dump($totalCorrectAnsCount);
        $startingDateTime = date("F j, Y g:i A", strtotime($quizContent[0]["starting_date"] . " " . $quizContent[0]["starting_time"]));
        $deadlineDateTime = date("F j, Y g:i A", strtotime($quizContent[0]["deadline_date"] . " " . $quizContent[0]["deadline_time"]));  
        
    }
// echo var_dump($submissions);
    if($postDetails[0]["content_type"] == "Activity"){
        // echo $postId . "<br>";
        // echo $classCode;
        $actDetails = $stdController->actContent($postId, $classCode); // For now it gets the points from the activity
        $actDeadline = date("F j, Y g:i A", strtotime($actDetails[0]["deadline_date"] . " " . $actDetails[0]["deadline_time"]));  
        // echo var_dump($actDetails);
        // echo var_dump($actDetails);
    }
    // echo var_dump($submissions);
    // echo var_dump($files);
    // echo var_dump($comments);
    
    // if(isset($comments[0]["month"])){
        $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $year = $postDetails[0]["month"][0] . "" . $postDetails[0]["month"][1] . $postDetails[0]["month"][2] . "" . $postDetails[0]["month"][3];
        $month = $months[$postDetails[0]["month"][5] . "" . $postDetails[0]["month"][6] - 1];
        $day = $postDetails[0]["month"][8] . "" . $postDetails[0]["month"][9];
    // }else{

    if(isset($_GET["temp"])){
        header('content-type: application/json');
        echo json_encode($comments);
    }

    // echo var_dump($comments);
}



if(isset($_POST["displayFiles"])){
    if (session_id() === "") session_start();
    // echo "\n\n\ninside";
    require_once("../../../log and reg backend/classes/connection.php");
    require_once("../classes/model.ClassRm.php");
    require_once("../classes/controller.Lists.php");
    require_once("../classes/controller.Student.php");

    $stdController = new StudentController();
    $submissions = $stdController->getSubmittedFiles($_SESSION["postId"], $_SESSION["storeCode"]);
    // echo var_dump($submissions);
    header('content-type: application/json');
    echo json_encode($submissions);
    // $_SESSION["postId"];

}