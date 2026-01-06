<?php

require_once("../log and reg backend/classes/connection.php");
require_once("classes/model.Prof.php");
require_once("classes/model.ClassRm.php");
require_once("classes/controller.Prof.php");
require_once("classes/controller.Lists.php");

$instrCtrlr = new InstructorController();

$listController = new ListController();
$classCode = $_GET["class"];
$details = $instrCtrlr->classDetails($classCode);
$studentList = $listController->displayList($details[0]["class_code"]);
$actSubmission = $listController->getActSubmission($classCode);
$quizSubmission = $listController->getQuizSubmission($classCode);
$examSubmission = $listController->getExamSubmission1($classCode);
$seatworkSubmission = $listController->getSeatworkSubmission($classCode);
$assignmentSubmission = $listController->getAssignmentSubmission($classCode);

$grades1 = $listController->getAllGrades($classCode);
$gradingSystem = $listController->getGradingSystem($classCode);

$total = $listController->totalActCount($classCode);
// echo var_dump($grades1);

$totalAct = 0;
$totalQuiz = 0;
$totalExam = 0;
$totalSeatwork = 0;
$totalAssignment = 0;

if ($total != null) {
    foreach ($total as $item) {
        if ($item["content_type"] == "Activity") {
            $totalAct = $item["total_posts"];
        } elseif ($item["content_type"] == "Quiz") {
            $totalQuiz = $item["total_posts"];
        } elseif ($item["content_type"] == "Exam") {
            $totalExam = $item["total_posts"];
        } elseif ($item["content_type"] == "Seatwork") {
            $totalSeatwork = $item["total_posts"];
        } elseif ($item["content_type"] == "Assignment") {
            $totalAssignment = $item["total_posts"];
        }
    }
}

// echo "Total act " . $totalAct . "<br>";
// echo "Total quiz " . $totalQuiz . "<br>";
// echo "Total exam " . $totalExam . "<br>";

$legitPostId = 0;

if(isset($_GET["post"])){
    if($actSubmission != null){
        foreach($actSubmission as $sub){
            if(md5($sub["post_id"]) == $_GET["post"]){
                $legitPostId = $sub["post_id"];
                break;
            }
        }
    }
}

$actScores = array();
$quizScores = array();
$examScores = array();
$seatworkScores = array();
$assignmentScores = array();

// echo var_dump($total);

if ($grades1 != null) {
    foreach ($grades1 as $grade) {
        if ($grade["content_type"] == "Activity") {
            // Initialize key if it doesn't exist
            if (!isset($actScores[$grade["user_id"]])) {
                $actScores[$grade["user_id"]] = 0;
            }
            $actScores[$grade["user_id"]] += $grade["grade"];
        } else if ($grade["content_type"] == "Quiz") {
            // Initialize key if it doesn't exist
            if (!isset($quizScores[$grade["user_id"]])) {
                $quizScores[$grade["user_id"]] = 0;
            }
            $quizScores[$grade["user_id"]] += $grade["grade"];
        } else if ($grade["content_type"] == "Exam"){
            if (!isset($examScores[$grade["user_id"]])) {
                $examScores[$grade["user_id"]] = 0;
            }
            $examScores[$grade["user_id"]] += $grade["grade"];
        } else if ($grade["content_type"] == "Seatwork"){
            if (!isset($seatworkScores[$grade["user_id"]])) {
                $seatworkScores[$grade["user_id"]] = 0;
            }
            $seatworkScores[$grade["user_id"]] += $grade["grade"];
        } else if ($grade["content_type"] == "Assignment"){
            if (!isset($assignmentScores[$grade["user_id"]])) {
                $assignmentScores[$grade["user_id"]] = 0;
            }
            $assignmentScores[$grade["user_id"]] += $grade["grade"];
        }
    }
}

// Debug output
// print_r($actScores);
// print_r($quizScores);
// print_r($examScores);

// $actGSys = $gradingSystem[0]["act_wg"] / 100;

// // echo var_dump($gradingSystem);

// foreach ($actScores as $user_id => $score) {
//     $calculatedScore = ($score / $totalAct) * $actGSys;
//     // echo "User ID: $user_id - Total Activity Grade: $calculatedScore <br>";
// }

// $quizGSys = $gradingSystem[0]["quiz_wg"] / 100;

// foreach ($quizScores as $user_id => $score) {
//     $calculatedScore = ($score / $totalQuiz) * $quizGSys;
//     // echo "User ID: $user_id - Total Quiz Grade: $calculatedScore <br>";
// }

// $examGSys = $gradingSystem[0]["exam_wg"] / 100;

// foreach ($examScores as $user_id => $score) {
//     $calculatedScore = ($score / $totalExam) * $examGSys;
//     // echo "User ID: $user_id - Total Quiz Grade: $calculatedScore <br>";
// }
// echo "<br> Exam " . 45 * $examGSys;

$userId = 0;

$submittedFiles = null;
if(isset($_GET["user"])){
    $urlId = $_GET["user"];
    $firstName = "";
    $userId = 0;

    foreach($studentList as $student){
        if(md5($student["user_id"]) == $urlId){
            $names = explode(" ",  $student["name"]);
            $firstName = $names[0];

            $userId = $student["user_id"];
            break;
        }
      }
    //   echo $ . "<br>";
    //   echo $classCode . "<br>";
    //   echo $userId . "<br>";

      $submittedFiles = $instrCtrlr->getIndivFIles($postID, $classCode, $userId);

    //    echo var_dump($actContent);
}

if(isset($postID) && $postID != null){
    if (session_id() === "") session_start();

    $actContent = $instrCtrlr->deadlineAndPoints($postID, $classCode); // Get Deadline and Points of Activity
    $seatworkContent = $instrCtrlr->deadlineAndPointsSw($postID, $classCode);
    $assignmentContent = $instrCtrlr->deadlineAndPointsAssign($postID, $classCode);
    $pointTemp = 0;
    $startDate = 0;
    $startTime = 0;
    $endDate = 0;
    $endTime = 0;
    $maxPoints = 0;
    $maxLimitPoints = 0;
    // echo var_dump($assignmentContent);
    if($seatworkContent != null){
        $startingDateTime = date("F j, Y g:i A", strtotime($seatworkContent[0]["starting_date"] . " " . $seatworkContent[0]["starting_time"]));  
        $deadlineDateTime = strtotime($seatworkContent[0]["deadline_date"] . " " . $seatworkContent[0]["deadline_time"]);  
        $pointTemp = $seatworkContent[0]["points"];
        $startDate = $seatworkContent[0]["starting_date"];
        $startTime = $seatworkContent[0]["starting_time"];
        $endDate = $seatworkContent[0]["deadline_date"];
        $endTime = $seatworkContent[0]["deadline_time"];
        $maxPoints = $seatworkContent[0]["points"];
        $_SESSION["post-type"] = "Seatwork";
    }else if($actContent != null){
        $startingDateTime = date("F j, Y g:i A", strtotime($actContent[0]["starting_date"] . " " . $actContent[0]["starting_time"]));  
        $deadlineDateTime = strtotime($actContent[0]["deadline_date"] . " " . $actContent[0]["deadline_time"]);  
        $pointTemp = $actContent[0]["points"];
        $startDate = $actContent[0]["starting_date"];
        $startTime = $actContent[0]["starting_time"];
        $endDate = $actContent[0]["deadline_date"];
        $endTime = $actContent[0]["deadline_time"];
        $maxPoints = $actContent[0]["points"];
        $_SESSION["post-type"] = "Activity";
    }else if($assignmentContent != null){
        $startingDateTime = date("F j, Y g:i A", strtotime($assignmentContent[0]["starting_date"] . " " . $assignmentContent[0]["starting_time"]));  
        $deadlineDateTime = strtotime($assignmentContent[0]["deadline_date"] . " " . $assignmentContent[0]["deadline_time"]);  
        $pointTemp = $assignmentContent[0]["points"];
        $startDate = $assignmentContent[0]["starting_date"];
        $startTime = $assignmentContent[0]["starting_time"];
        $endDate = $assignmentContent[0]["deadline_date"];
        $endTime = $assignmentContent[0]["deadline_time"];
        $maxPoints = $assignmentContent[0]["points"];
        $_SESSION["post-type"] = "Assignment";

        // echo $pointTemp;
    }


    $submitTemp = strtotime($startingDateTime);
    $submitDateTime = date("F j, Y g:i A",  $submitTemp);
    $deadlineTemp = date("F j, Y g:i A", $deadlineDateTime);
    $status = "";

    if($submitDateTime < $deadlineTemp){
        $status = "Late";
    }else if($submittedFiles != null){
        $status = "On Time";
    }

    $grades = $instrCtrlr->getActivityGrade($postID, $classCode, $userId);
    if($userId != 0 && $grades != null){
        if($actContent != null) $currentPoint = ($grades[0]["grade"] / 100) * $actContent[0]["points"];
        if($seatworkContent != null) $currentPoint = ($grades[0]["grade"] / 100) * $seatworkContent[0]["points"];
        if($assignmentContent != null) $currentPoint = ($grades[0]["grade"] / 100) * $assignmentContent[0]["points"];
    } 

}


