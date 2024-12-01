<?php

if(isset($_POST["newClass"])){
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

if(isset($_GET["class"])){
    $classCode = $_GET["class"];
    $stdController = new StudentController();
    $details = $stdController->getClassDetails1($classCode);
    $listController = new ListController();
    $studentList = $listController->displayList($details[0]["class_code"]);
    $profDetails = $stdController->searchInstructor($details[0]["class_teacher"]);

}
