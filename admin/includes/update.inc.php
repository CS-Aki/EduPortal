<?php
$_SESSION["searchSwitch"] = "all";

// Will remove this, but we'll still unset the session if they pressed another sidebar button
if (isset($_POST['backBtn'])) {
    unset($_SESSION["min"]);
    unset($_SESSION["max"]);
    unset($_SESSION["searchSwitch"]);
    unset($_SESSION["counter"]);
    //might cause issues in the future keep in mind
    //  unset($_SESSION['list']);
    header("Location: admin-dashboard.php");
    exit();
}

if (isset($_POST["editClassBtn"])) {
    $num = $_POST['classNum'];
    $classCode = $_SESSION['list'][$num -  $_SESSION["min"] - 1]['class_code'];
    // echo  $_SESSION['list'][$num -  $_SESSION["min"] - 1]['class_code'];
    $_SESSION['num'] = $num -  $_SESSION["min"] - 1;
    // echo $classCode;

    $className = $_POST["className"];
    $classSchedule = array(
        "day" => $_POST["daySched"],
        "startingHour" => $_POST["startingHourSched"],
        "startingMin" => $_POST["startingMinSched"],
        "startTimePeriod" => $_POST["startTimePeriod"],
        "endingHour" => $_POST["endingHourSched"],
        "endingMin" => $_POST["endingMinSched"],
        "endTimePeriod" => $_POST["endTimePeriod"]
    );
    $classProf = $_POST["classProf"];
    $status = $_POST["status"];
    //echo $classCode . "<br>" . $classProf . "<br>" . $status;

    $classController = new ClassRmController($classCode, $className, $classSchedule, $classProf, $status);
    $classController->editClass();
}
