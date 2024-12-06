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