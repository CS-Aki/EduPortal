<?php

require_once("../../log and reg backend/classes/connection.php");
require_once("../classes/model.Prof.php");
require_once("../classes/controller.Prof.php");

if(isset($_POST["questionId"])){
    $questionId = $_POST["questionId"];
    $choiceValue = $_POST["choice"];
    $answerKey = $_POST["answer"];

    echo $questionId . "\n";
    echo $choiceValue . "\n";
    // echo $answerKey . "\n";

}

$instrCtrlr = new InstructorController();
$instrCtrlr->removeChoice($questionId, $choiceValue, $answerKey);
