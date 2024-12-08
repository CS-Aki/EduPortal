<?php

require_once("../log and reg backend/classes/connection.php");
require_once("classes/model.Prof.php");
require_once("classes/model.ClassRm.php");
require_once("classes/controller.Prof.php");
require_once("classes/controller.Lists.php");

$listController = new ListController();

$classCode = $_GET["class"];

$quiz = $listController->displayQuizList($classCode);

if(isset($_GET["post"])){
    $listController = new ListController();
    $quizContent = $listController->displayQuiz($_GET["class"], $_GET["post"]);
}

// echo var_dump($quiz);

$title = "";
$startingDateTime = "";
$deadlineDateTime = "";
$attempt = 0;
// $description = "";
// echo var_dump($quiz);
if(isset($_GET["post"])){
    for($i = 0; $i < count($quiz); $i++){
        if(md5($quiz[$i]["post_id"]) == $_GET["post"]){
            $startingDateTime = date("F j, Y g:i A", strtotime($quiz[$i]["starting_date"] . " " . $quiz[$i]["starting_time"]));
            $deadlineDateTime = date("F j, Y g:i A", strtotime($quiz[$i]["deadline_date"] . " " . $quiz[$i]["deadline_time"]));     
            $title = $quiz[$i]["title"];
            $attempt = $quiz[$i]["attempt"];
            // $description = $quiz[$i][""];
            break;
        }
    }
}



