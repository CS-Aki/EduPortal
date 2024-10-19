<?php
// $_SESSION["searchSwitch"] = "all";

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

if (isset($_POST['click_edit_btn'])) {
 
  $classCode = $_POST['class_code'];
  $listController = new ListController();
  $listOfClasses = $listController->getClassFromCode();
  $_SESSION["list"] = $listOfClasses;
//  echo $listOfClasses[0]["class_num"];
  //$_SESSION['classNumber'] = 1;
  $sched = $listController->getSched();
 
  $listOfClasses[0]["daySched"] = $sched["daySched"];
  $listOfClasses[0]["startingHour"] = $sched["startingHour"];
  $listOfClasses[0]["startingMin"] = $sched["startingMin"];
  $listOfClasses[0]["startTimePeriod"] = $sched["startTimePeriod"];
  $listOfClasses[0]["endingHour"] = $sched["endingHour"];
  $listOfClasses[0]["endingMin"] = $sched["endingMin"];
  $listOfClasses[0]["endTimePeriod"] = $sched["endTimePeriod"];

  $_SESSION["list"] = $listOfClasses;
  
  header('content-type: application/json');
  echo json_encode($listOfClasses);

  exit();
}

if (isset($_POST["editClassBtn"])) {
    $num = $_POST['classNum'];
    $classCode = $_POST['class_code'];
    // $_SESSION['num'] = $num -  $_SESSION["min"] - 1;

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
