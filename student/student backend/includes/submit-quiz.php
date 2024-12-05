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

    $form = $_POST; // The serialized form data

    $stdController = new StudentController();
    // user id, post id, class code, status, answer, question id
    echo "POST ID : " . $classCode . "\n\n";
    $answers = [];
    foreach ($_POST as $questionId => $answer) {
        if ($questionId === 'classCode' || $questionId === 'postId') {
            continue; 
        }
          
        $answers[$questionId] = $answer;
        if (isset($_SESSION["answerKey"][$questionId]) && $_SESSION["answerKey"][$questionId] == $answer) {
            echo "Correct Answer for Question ID $questionId: $answer\n\n";
            $stdController->submitAnswers($_SESSION["id"], $postId, $classCode, 1, $answer, $questionId);
        } else {
            $stdController->submitAnswers($_SESSION["id"], $postId, $classCode, 0, $answer, $questionId);
            echo "Wrong Answer for Question ID $questionId: $answer\n\n";
        }
    }

  

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