<?php

// header('Content-Type: application/json');
require_once("../../../log and reg backend/classes/connection.php");
require_once("../../student backend/classes/model.ClassRm.php");
require_once("../../student backend/classes/controller.Lists.php");
require_once("../../student backend/classes/controller.Student.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (session_id() === "") session_start();

    $postId = $_POST['postId'];
    $classCode = $_POST['classCode'];
    $attempt = $_POST['attempt'];
    $form = $_POST; // The serialized form data
    $date = $_POST['date'];
    $time = $_POST['time'];
    $stdController = new StudentController();
    // $quizDetails = $stdController->getQuizDetails($postId, $classCode);
    // user id, post id, class code, status, answer, question id
    // echo "POST ID : " . $classCode . "\n\n";
    
    $currentDateTime = new DateTime(); 
    $comparisonDateTime = new DateTime($date . " " . $time);
    $status = "";

    if ($currentDateTime <= $comparisonDateTime) {
        $status = "On Time";
    } elseif ($currentDateTime > $comparisonDateTime) {
        $status = "Late";
    } 

    $yourScore = 0;
    $totalItems = 0;
    $answers = [];
    foreach ($_POST as $questionId => $answer) {
        if ($questionId === 'classCode' || $questionId === 'postId' || $questionId === "attempt" || $questionId === "date" || $questionId === "time") {
            continue; 
        }
          
        $answers[$questionId] = $answer;
        if (isset($_SESSION["answerKey"][$questionId]) && $_SESSION["answerKey"][$questionId] == $answer) {
            echo "Correct Answer for Question ID $questionId: $answer\n\n";
            $yourScore++;           
             $stdController->submitAnswers($_SESSION["id"], $postId, $classCode, 1, $answer, $questionId, $attempt);
        } else {
             $stdController->submitAnswers($_SESSION["id"], $postId, $classCode, 0, $answer, $questionId, $attempt);
            echo "Wrong Answer for Question ID $questionId: $answer\n\n";
        }
        $totalItems++;
        unset($_SESSION[md5($postId)]);
    }

    $grade = ($yourScore / $totalItems) * 100;
    $stdController->insertGrade($_SESSION["id"], $postId, $classCode, "Quiz", $grade, $status);
    // echo "\n\nTOTAL ITEMS " . $totalItems;
    // echo "\n\SCORE  " . $yourScore;
    // echo "\n\GRADE  " . $grade;


    // echo var_dump($_SESSION["answerKey"]);
    
//     if (!empty($postId) && !empty($classCode)) {
//         echo json_encode(['status' => 'success', 'message' => 'Quiz submitted successfully.']);
//     } else {
//         http_response_code(400);
//         echo json_encode(['status' => 'error', 'message' => 'Invalid data provided.']);
//     }
// } else {
//     http_response_code(405);
//     echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
}