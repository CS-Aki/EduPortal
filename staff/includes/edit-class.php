<?php

if (isset($_POST["className"])) {
    require_once("../classes/connection.php");
    require_once("../classes/model.ClassRm.php");
    require_once("../classes/controller.ClassRm.php");
    require_once("../classes/controller.Lists.php");

    $classCode = $_POST['classCode'];
    // $_SESSION['num'] = $num -  $_SESSION["min"] - 1;
    $className = $_POST["className"];
    $userId = $_POST["classProfId"];
    $classSchedule = array(
        "day" => $_POST["daySched"],
        "startingHour" => $_POST["startingHourSched"],
        "startingMin" => $_POST["startingMinSched"],
        "startTimePeriod" => $_POST["startTimePeriod"],
        "endingHour" => $_POST["endingHourSched"],
        "endingMin" => $_POST["endingMinSched"],
        "endTimePeriod" => $_POST["endTimePeriod"]
    );
    $tempClassName = $_POST["tempClassName"];

    $classProf = $_POST["classProf"];
    $status = $_POST["classStatus"];
    //echo $classCode . "<br>" . $classProf . "<br>" . $status;

    $classController = new ClassRmController($classCode, $className, $classSchedule, $classProf, $status, $tempClassName, $userId);
    $classController->editClass();
    
}