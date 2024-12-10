<?php

require_once("../log and reg backend/classes/connection.php");
require_once("classes/model.Prof.php");
require_once("classes/model.ClassRm.php");
require_once("classes/controller.Prof.php");
require_once("classes/controller.Lists.php");

$listController = new ListController();
$classCode = $_GET["class"];
$details = $instrCtrlr->classDetails($classCode);
$studentList = $listController->displayList($details[0]["class_code"]);
$actSubmission = $listController->getActSubmission($classCode);
$instrCtrlr = new InstructorController();

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

    $submitTemp = strtotime($submittedFiles[0]["created"]);
    $submitDateTime = date("F j, Y g:i A",  $submitTemp);
    $deadlineTemp = date("F j, Y g:i A", $deadlineDateTime);
    $status = "";
    if($submitDateTime > $deadlineDateTime){
        $status = "Late";
        // echo "<br>LATE";
    }else{
        $status = "On Time";
        // echo "<br>On time";
    }
    // echo "user" . $userId;
    $grades = $instrCtrlr->getActivityGrade($postID, $classCode, $userId);

    // echo $classCode;
    // echo var_dump($grades);
}



//  echo var_dump($submittedFiles);
//  echo "<br>";
//  echo var_dump($actContent);
