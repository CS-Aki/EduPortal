<?php
if(isset($_POST['createClassBtn'])){
    
    $classCode = generateClassCode();
    $className = $_POST["className"];
    $status = $_POST["status"];
    $classSchedule = array("day" => $_POST["daySched"], "startingHour" => $_POST["startingHourSched"], "startingMin" => $_POST["startingMinSched"], "startTimePeriod" => $_POST["startTimePeriod"],
                           "endingHour" => $_POST["endingHourSched"], "endingMin" => $_POST["endingMinSched"], "endTimePeriod" => $_POST["endTimePeriod"]
                     );
    $classProf = $_POST["classProf"];
    $_SESSION["className"] = $className;
    $_SESSION["classProf"] = $classProf;
    $_SESSION['daySched'] = $classSchedule["day"];
    $_SESSION['startingHourSched'] = $classSchedule["startingHour"];
    $_SESSION['startingMinSched'] = $classSchedule["startingMin"];
    $_SESSION['startTimePeriod'] = $classSchedule["startTimePeriod"];
    $_SESSION['endingHourSched'] = $classSchedule["endingHour"];
    $_SESSION['endingMinSched'] = $classSchedule["endingMin"];
    $_SESSION['endTimePeriod'] = $classSchedule["endTimePeriod"];
    $_SESSION['status'] = $status;
    $classController = new ClassRmController($classCode, $className, $classSchedule, $classProf, $status);
    $classController->addClass();

}

if(isset($_POST['backBtn'])) {
    unset($_SESSION["timer"]);
    header("Location: admin-dashboard.php");
}

function generateClassCode(){
    $alphabet = "abcdefghijklmnopqrstuvwxyz0123456789";
    $classCodeHolder = "";
    for($i = 1; $i <= 8; $i++){
      $randomCaps = rand(1, 100);
      $randomize = rand(0, strlen($alphabet) - 1);

      if(!is_numeric($alphabet[$randomize])){
          if($randomCaps >= 50){
              $classCodeHolder .= strtoupper($alphabet[$randomize]);
              continue;
          }
      }
      $classCodeHolder .= $alphabet[$randomize];
    }

    return $classCodeHolder;
}
                   