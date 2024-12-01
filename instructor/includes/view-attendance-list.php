<?php

if(isset($_GET["temp"])){
    require_once("../../log and reg backend/classes/connection.php");
    require_once("../classes/model.Prof.php");
    require_once("../classes/model.ClassRm.php");
    require_once("../classes/controller.Prof.php");
    require_once("../classes/controller.Lists.php");


}else{
    require_once("../log and reg backend/classes/connection.php");
    require_once("classes/model.Prof.php");
    require_once("classes/model.ClassRm.php");
    require_once("classes/controller.Prof.php");
    require_once("classes/controller.Lists.php");
}

if(isset($_GET["class"])){
    $classCode = $_GET["class"];
    // $stdController = new StudentController();
    $instrCtrlr = new InstructorController();
    $details = $instrCtrlr->classDetails($classCode);
    // $details = $stdController->getClassDetails1($classCode);
    $listController = new ListController();
    $studentList = $listController->displayAttendanceList($details[0]["class_code"]);
    // if(count($studentList) == 0) $studentList = $listController->displayList($details[0]["class_code"]);

    if(isset($_GET["temp"])){
        header('content-type: application/json');
        echo json_encode($studentList);
    }
    
}
