<?php

$postId =  $_GET["post"];
$classCode = $_GET["class"];

require_once("../log and reg backend/classes/connection.php");
require_once("classes/model.Prof.php");
require_once("classes/controller.Prof.php");

$instrCtrlr = new InstructorController();

$quizContent = $instrCtrlr->getQuizDetails($postId, $classCode);
$postDetails = $instrCtrlr->getPostDetails($postId, $classCode);

// echo var_dump($quizContent);
// echo var_dump($quizContent);




if($quizContent != null && $quizContent[0]["question_id"] != null){
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

if(isset($_GET["user"])){
    $yourScore = array();
        $userId = $_GET["user"];
        $currentAttempt = 0;
        $quizContent = $instrCtrlr->getQuizContent($postId, $classCode);
        $quizDetails = $instrCtrlr->getQuizDetails($postId, $classCode);
        $quizStatus = $instrCtrlr->getQuizStatus($postId, $classCode, $userId);
        // $quizAttempt = $stdController->getQuizAttempt($postId, $_SESSION["id"]);
        $submittedQuiz = $instrCtrlr->getQuizResult($postId, $classCode, $userId);
        $name =  $instrCtrlr->getStudentName($userId);
        $names = explode(" ", $name[0]["name"]);
        $firstName = $names[0];
        //  echo var_dump($quizDetails);

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
        
        if(isset($_GET["attempt"])){
            // echo "POST ID " . $postId . "<br>";
            // echo "CLASS CODE " . $classCode . "<br>";
            // echo "user id " . $_SESSION["id"] . "<br>";
            // echo "ATTEMPT " . $_GET["attempt"] . "<br>";
            $result = $instrCtrlr->getQuizResultFormat($postId, $classCode, $userId, $_GET["attempt"]);
            $numberOfCorrect = 0;
            // $j = 0;
            if($result != null){
                for ($i = 0; $i < count($result); $i++) {
                    if($result[$i]["status"] == 1) $numberOfCorrect++;
                }
            }
        }
}else{
    $quizContent1 = $instrCtrlr->getQuizContent($postId, $classCode);
}



//  echo var_dump($groupedQuestions);
