<?php

require_once("../../log and reg backend/classes/connection.php");
require_once("../classes/model.Prof.php");
require_once("../classes/controller.Prof.php");


$classCode = $_POST["classCode"];
$actWg = $_POST["actWg"];
$quizWg = $_POST["quizWg"];
$examWg = $_POST["examWg"];
$assignmentWg = $_POST["assignmentWg"];
$seatworkWg = $_POST["seatworkWg"];

$instrCtrlr = new InstructorController();
$result = $instrCtrlr->editGradeSystem($classCode, $actWg, $quizWg, $examWg, $assignmentWg, $seatworkWg);

if($result == true){
    echo "Success";
}else{
    echo "Failed";
}