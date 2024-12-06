<?php

require_once("../../log and reg backend/classes/connection.php");
require_once("../classes/model.Prof.php");
require_once("../classes/controller.Prof.php");

// $quizTitle = $_POST["title"];
$classCode = $_POST["classCode"]; // Note this is still encrypted
$jsonData = $_POST["questions"];

// echo "Class Code: ". $classCode . "\n";
$questions = json_decode($jsonData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['message' => 'Invalid JSON data']);
    exit;
}

// echo "The title is " . $quizTitle . "\n";
// echo var_dump($data);
$postId = $_POST["postId"];
$instrCtrlr = new InstructorController();
$instrCtrlr->createQuiz($classCode, $questions, $postId);

// foreach ($questions as $question) {
//     $questionText = $question['question'];
//     $type = $question['type'];
//     $options = $question['options'];
//     $ansKey = $question['ansKey'];
//     $points = $question['points'];

//     echo "Question: $questionText, Type: $type, Answer Key: $ansKey, Points: $points\n";
//     if ($type === 'multiple-choice') {
//         echo "Options: " . count($options) . "\n";
//     }
// }

// foreach ($questions as $question) {
//     $questionText = $question['question'];
//     $type = $question['type'];
//     $options = $question['options'];
//     $ansKey = $question['ansKey'];
//     $points = $question['points'];

//     echo "Question: $questionText, Type: $type, Answer Key: $ansKey, Points: $points\n";
//     if ($type === 'multiple-choice') {
//         echo "Options: " . implode('-', $options) . "\n";
//     }
// }

