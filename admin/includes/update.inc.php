<?php
$_SESSION["searchSwitch"] = "all";

// Will remove this, but we'll still unset the session if they pressed another sidebar button
if(isset($_POST['backBtn'])){
    unset($_SESSION["min"]);
    unset($_SESSION["max"]);
    unset($_SESSION["searchSwitch"]);
    unset($_SESSION["counter"]);
    unset($_SESSION['list']);
    header("Location: admin-dashboard.php");
    exit();
}


if(isset($_POST["editClassBtn"])){
     $classCode = $_SESSION['list'][$_SESSION['classNumber']]['class_code'];
    // $className = $_SESSION['list'][$_SESSION['classNumber']]['class_name'];
    // $classSched = $_SESSION['list'][$_SESSION['classNumber']]['class_schedule'];
    // $classProf = $_SESSION['list'][$_SESSION['classNumber']]['class_teacher'];
    // $status = $_SESSION['list'][$_SESSION['classNumber']]['class_status'];

    $className = $_POST["className"];
    $classSchedule = array("day" => $_POST["daySched"], "startingHour" => $_POST["startingHourSched"], "startingMin" => $_POST["startingMinSched"], "startTimePeriod" => $_POST["startTimePeriod"],
    "endingHour" => $_POST["endingHourSched"], "endingMin" => $_POST["endingMinSched"], "endTimePeriod" => $_POST["endTimePeriod"]
    );
    $classProf = $_POST["classProf"];
    $status = $_POST["status"];
    //echo $classCode . "<br>" . $classProf . "<br>" . $status;

    $classController = new ClassRmController($classCode, $className, $classSchedule, $classProf, $status);
    $classController->editClass();
}