<?php

if(isset($_POST["comment"])){
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

if(isset($_POST["comment"])){
    session_start();
    $comment = $_POST["comment"];
    if(empty($comment)) return;
    // echo $comment;
    $postTitle =  $_POST["post-title"];
    $stdController = new StudentController();
    $classCode = $_POST["class-code"];

    $postDetails = $stdController->getPostDetails($postTitle, $classCode);

    // echo $postDetails[0]["class_code"];
    // echo "<br>". $postDetails[0]["title"];

    $result = $stdController->postComment($postDetails[0]["title"],  $postDetails[0]["class_code"], $comment);

    if($result == true){
        echo "Success Comment";
    }else{
        echo "Failed Comment";
    }


}