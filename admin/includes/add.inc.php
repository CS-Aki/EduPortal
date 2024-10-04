<?php
if(isset($_POST['addClassBtn'])) header("Location: add-class.php");

if(isset($_POST['createClassBtn'])){
    
    $classCode = generateClassCode();
    $className = $_POST["className"];
    $status = $_POST["status"];
    $classSchedule = array("day" => $_POST["daySched"], "startingHour" => $_POST["startingHourSched"], "startingMin" => $_POST["startingMinSched"], "startTimePeriod" => $_POST["startTimePeriod"],
                           "endingHour" => $_POST["endingHourSched"], "endingMin" => $_POST["endingMinSched"], "endTimePeriod" => $_POST["endTimePeriod"]
                     );
    $classProf = $_POST["classProf"];
    
    // $_SESSION["data"] = array("classCode" => $classCode, "className" => $className, "status" => $status, "classSched" => $classSchedule, "classProf" => $classProf);
    // echo json_encode($_SESSION["data"]);
                     
    $classController = new ClassRmController($classCode, $className, $classSchedule, $classProf, $status);
//  $adminController = new AdminController($classController);
//  $adminController->callAddClass();
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
                   