<?php 

if(isset($_GET["temp"])){
    require_once("../../../log and reg backend/classes/connection.php");
    require_once("../classes/model.ClassRm.php");
    require_once("../classes/controller.Lists.php");
    require_once("../classes/controller.Student.php");
}else{
    require_once("../log and reg backend/classes/connection.php");
    require_once("student backend/classes/model.ClassRm.php");
    require_once("student backend/classes/controller.Lists.php");
    require_once("student backend/classes/controller.Student.php");
}

if(isset($_GET["post"])){
    $postTitle =  $_GET["post"];
    $stdController = new StudentController();
    if(isset($_GET["code"])) $classCode = $_GET["code"];
    else $classCode = $_GET["class"];

    $postDetails = $stdController->getPostDetails($postTitle, $classCode);
    $comments = $stdController->getComments($postTitle, $classCode);
    // echo var_dump($comments);

    // if(isset($comments[0]["month"])){
        $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $year = $postDetails[0]["month"][0] . "" . $postDetails[0]["month"][1] . $postDetails[0]["month"][2] . "" . $postDetails[0]["month"][3];
        $month = $months[$postDetails[0]["month"][5] . "" . $postDetails[0]["month"][6] - 1];
        $day = $postDetails[0]["month"][8] . "" . $postDetails[0]["month"][9];
    // }else{

    if(isset($_GET["temp"])){
        header('content-type: application/json');
        echo json_encode($comments);
    }

    // echo var_dump($comments);
}