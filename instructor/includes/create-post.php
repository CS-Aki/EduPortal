<?php

require_once("../../log and reg backend/classes/connection.php");
require_once("../classes/model.Prof.php");
require_once("../classes/controller.Prof.php");

if(isset($_POST["type"])){
    
    $classCode = $_POST["classCode"];
    $type = $_POST["type"];
    $time = "";
    $date = "";
    $startingDate = "";
    $startingTime = "";
    $points = 0;

    if($type != "material"){
        $date = $_POST["date"];
        $time = $_POST["time"];
        $startingDate = $_POST["startDate"];
        $startingTime = $_POST["startTime"];
        $points = $_POST["points"];
    }

    $title = $_POST["title"];
    $desc = $_POST["desc"];
    $instrCtrlr = new InstructorController();
    $postDetails = $instrCtrlr->createPost($classCode, $type, $title, $desc, $date, $time, $startingDate, $startingTime, $points);
    // echo var_dump($postDetails);
    header('content-type: application/json');
    echo json_encode($postDetails);
}