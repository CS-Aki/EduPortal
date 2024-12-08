<?php

$postId =  $_GET["post"];
$classCode = $_GET["class"];

require_once("../log and reg backend/classes/connection.php");
require_once("classes/model.Prof.php");
require_once("classes/controller.Prof.php");

$instrCtrlr = new InstructorController();

$quizContent = $instrCtrlr->getQuizDetails($postId, $classCode);

// echo var_dump($quizContent);
// echo var_dump($quizContent);

if($quizContent != null){
    $groupedQuestions = [];
    foreach ($quizContent as $question) {
        $questionId = $question['question_id'];
        if (!isset($groupedQuestions[$questionId])) {
            $groupedQuestions[$questionId] = [
                'question_id' => $questionId,
                'question_type' => $question['question_type'],
                'question_text' => $question['question_text'],
                'points' => $question['points'],
                'title' => $question['title'],
                'ans_key' => $question['ans_key'],
                'options' => []
            ];
        }
        $groupedQuestions[$questionId]['options'][] = $question['option_text'];
    }
}
//  echo var_dump($groupedQuestions);
