<?php

require_once("../../log and reg backend/classes/connection.php");
require_once("../classes/model.Prof.php");
require_once("../classes/controller.Prof.php");
if (session_id() === "") session_start();

$files = null;

if(isset($_FILES["files"])){
    $files = $_FILES['files'];
    // $_SESSION["storedFile"] = $_FILES['files'];
    echo "THERE IS FILES";
}


$classCode = $_POST["classCode"];
$title = $_POST["title"];
$postId = $_POST["postId"];
$description = $_POST["description"];
$startingDate = $_POST["startingDate"];
$startingTime = $_POST["startingTime"];
$deadlineDate = $_POST["deadlineDate"];
$deadlineTime = $_POST["deadlineTime"];
$type = $_POST["type"];
$points = $_POST["points"];
$attempts = $_POST["attempts"];

// echo var_dump($_FILES['files']);

$instrCtrlr = new InstructorController();
$instrCtrlr->updatePost($classCode, $title, $postId, $description, $startingDate, $startingTime, $deadlineDate, $deadlineTime, $type, $files, $points, $attempts);

//  echo "Title " .  $title . "\n";
//  echo "postId " .  $postId . "\n";
//  echo "description " .  $description . "\n";
//  echo "startingDate " .  $startingDate . "\n";
//  echo "startingTime " .  $startingTime . "\n";
//  echo "deadlineDate " .  $deadlineDate . "\n";
//  echo "deadlineTime " .  $deadlineTime . "\n";
 