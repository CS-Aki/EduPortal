<?php

require_once("../log and reg backend/classes/connection.php");
require_once("student backend/classes/model.ClassRm.php");
require_once("student backend/classes/controller.Lists.php");
require_once("student backend/classes/controller.Student.php");
if (session_id() === "") session_start();

if(isset($_GET["class"])){

$classCode = $_GET["class"];

// $classCode = str_replace("Class Code: ", "", $_GET["class"]);
$stdController = new StudentController();
$details = $stdController->getClassDetails1($classCode);
$submissions = $stdController->getSubmissions($classCode, $_SESSION["id"]);  // Checks Uploaded Files of Student (Activity)
$post = $stdController->getClassDetails($details[0]["class_code"]);


$quiz = $stdController->listOfQuiz($details[0]["class_code"]);
$activity = $stdController->listOfActs($details[0]["class_code"]);

// echo $_SESSION["id"];
$answeredQuiz = $stdController->getAnsweredQuizzes($classCode, $_SESSION["id"]);
// echo var_dump($quiz);

// $submittedQuiz = $stdController->getQuizResult($postId, $classCode, $_SESSION["id"]); 

// echo var_dump($quiz);


if(isset($post[0]["content_type"])){
    $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $year = $post[0]["month"][0] . "" . $post[0]["month"][1] . $post[0]["month"][2] . "" . $post[0]["month"][3];
    $month = $months[$post[0]["month"][5] . "" . $post[0]["month"][6] - 1];
    $day = $post[0]["month"][8] . "" . $post[0]["month"][9];
}

$currentDate = date("F j, Y");
// echo var_dump($submissions);
// SELECT files.file_name, posts.title, posts.post_id FROM `files` INNER JOIN posts ON posts.post_id = files.post_id WHERE md5(files.class_code) =
}