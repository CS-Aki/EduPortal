<?php
if(isset($_POST['addClassBtn'])) header("Location: add-class.php");

if(isset($_POST['createClassBtn'])){
    $classCode = generateClassCode();
    $className = $_POST["className"];
    $classSchedule = $_POST["classSched"];
    $classProf = $_POST["classProf"];
    $classController = new ClassRmController($classCode, $className, $classSchedule, $classProf);
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
