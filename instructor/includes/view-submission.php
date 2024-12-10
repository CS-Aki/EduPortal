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
    $deadlineDateTime = date("F j, Y g:i A", strtotime($actContent[0]["deadline_date"] . " " . $actContent[0]["deadline_time"]));  
}


  
//  echo var_dump($actSubmission);