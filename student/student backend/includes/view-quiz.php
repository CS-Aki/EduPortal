<?php

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
$score = 0;
$totalPoints = 0;              
        
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