<?php
if (session_id() === "") session_start();

require_once("../log and reg backend/classes/connection.php");
require_once("student backend/classes/model.ClassRm.php");
require_once("student backend/classes/controller.Lists.php");
require_once("student backend/classes/controller.Student.php");

$postId =  $_GET["post"];
$classCode = $_GET["class"];

$stdController = new StudentController();
$postDetails = $stdController->getPostDetails($postId, $classCode);
$quizDetails = $stdController->getQuizDetails($postId, $classCode);
$submittedQuiz = $stdController->getQuizResult($postId, $classCode, $_SESSION["id"]); // Checks answer table if student already done with the quiz, 
                                                                                     //will add checker for attempt no. and add attempt number col on answer table
$temp = $stdController->getTotalItems($postId);                                             
$numberOfItems = $temp[0]["totalItems"];
$score = 0;
$totalPoints = 0;             
// echo var_dump($quizDetails); 
// $result = "";
// Viewing the quiz result
if(isset($_GET["attempt"])){
    // echo "POST ID " . $postId . "<br>";
    // echo "CLASS CODE " . $classCode . "<br>";
    // echo "user id " . $_SESSION["id"] . "<br>";
    // echo "ATTEMPT " . $_GET["attempt"] . "<br>";
    $result = $stdController->getQuizResultFormat($postId, $classCode, $_SESSION["id"], $_GET["attempt"]);
    $numberOfCorrect = 0;
    // $j = 0;
    if($result != null){
        for ($i = 0; $i < count($result); $i++) {
            if($result[$i]["status"] == 1) $numberOfCorrect++;
        }
    }
}

// echo var_dump($result);
if($submittedQuiz != null){
    if($result != null) $numberOfItems = count($submittedQuiz) / ($_GET["attempt"]);
    else $numberOfItems = count($submittedQuiz) / ($_GET["attempt"] - 1);
}



// echo var_dump($submittedQuiz);  
// if($submittedQuiz != null){
//     for($i = 0; $i < count($submittedQuiz); $i++){
//         $score += $submittedQuiz[$i]["score"];
//     }
// }

// for($i = 0; $i < count($quizDetails); $i++){
//     $totalPoints += $quizDetails[$i]["points"];
// }

// echo "Your score is " . $score;
// echo "<br>Quiz Total Points: " . $totalPoints;
// echo "<pre>";
// print_r($submittedQuiz);
// echo "</pre>";

$ansKey = array();
if($quizDetails != null){
    for ($i = 0; $i < count($quizDetails); $i++) {
        $ansKey[$quizDetails[$i]["question_id"]] = $quizDetails[$i]["ans_key"];
    }
}

$_SESSION["answerKey"] = $ansKey;

// echo "test";
// echo var_dump($_SESSION["answerKey"] );

// echo var_dump($quizDetails);