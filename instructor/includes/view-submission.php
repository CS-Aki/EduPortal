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

$examSubmission = $listController->getExamSubmission($classCode);
$grades1 = $listController->getAllGrades($classCode);
$gradingSystem = $listController->getGradingSystem($classCode);

$total = $listController->totalActCount($classCode);
// echo var_dump($total);

$totalAct = 0;
$totalQuiz = 0;
$totalExam = 0;

if ($total != null) {
    foreach ($total as $item) {
        if ($item["content_type"] == "Activity") {
            $totalAct = $item["total_posts"];
        } elseif ($item["content_type"] == "Quiz") {
            $totalQuiz = $item["total_posts"];
        } elseif ($item["content_type"] == "Exam") {
            $totalExam = $item["total_posts"];
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
        }else{
            if (!isset($examScores[$grade["user_id"]])) {
                $examScores[$grade["user_id"]] = 0;
            }
            $examScores[$grade["user_id"]] += $grade["grade"];
        }
    }
}

// Debug output
// print_r($actScores);
// print_r($quizScores);
// print_r($examScores);

$actGSys = $gradingSystem[0]["act_wg"] / 100;

// echo var_dump($gradingSystem);

foreach ($actScores as $user_id => $score) {
    $calculatedScore = ($score / $totalAct) * $actGSys;
    // echo "User ID: $user_id - Total Activity Grade: $calculatedScore <br>";
}

$quizGSys = $gradingSystem[0]["quiz_wg"] / 100;

foreach ($quizScores as $user_id => $score) {
    $calculatedScore = ($score / $totalQuiz) * $quizGSys;
    // echo "User ID: $user_id - Total Quiz Grade: $calculatedScore <br>";
}

$examGSys = $gradingSystem[0]["exam_wg"] / 100;

foreach ($examScores as $user_id => $score) {
    $calculatedScore = ($score / $totalExam) * $examGSys;
    // echo "User ID: $user_id - Total Quiz Grade: $calculatedScore <br>";
}
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
    $actContent = $instrCtrlr->deadlineAndPoints($postID, $classCode); // Get Deadline and Points of Activity
    $startingDateTime = date("F j, Y g:i A", strtotime($actContent[0]["starting_date"] . " " . $actContent[0]["starting_time"]));  
    $deadlineDateTime = strtotime($actContent[0]["deadline_date"] . " " . $actContent[0]["deadline_time"]);  

    $submitTemp = strtotime($startingDateTime);
    $submitDateTime = date("F j, Y g:i A",  $submitTemp);
    $deadlineTemp = date("F j, Y g:i A", $deadlineDateTime);
    $status = "";
    
    if($submitDateTime > $deadlineTemp){
        $status = "Late";
    }else if($submittedFiles != null){
        $status = "On Time";
    }

    $grades = $instrCtrlr->getActivityGrade($postID, $classCode, $userId);
    if($userId != 0 && $grades != null){
        $currentPoint = ($grades[0]["grade"] / 100) * $actContent[0]["points"];
    } 
    // echo $classCode;
    // echo var_dump($grades);
}



// echo $actContent[0]["starting_date"];


//  echo var_dump($submittedFiles);
//  echo "<br>";
//  echo var_dump($quizSubmission);
