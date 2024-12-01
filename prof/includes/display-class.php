<?php 
require_once("../../log and reg backend/classes/connection.php");
require_once("../classes/model.Prof.php");
require_once("../classes/controller.Prof.php");

if(isset($_GET["class-code"]) || isset($_POST["class-code"])){
    // echo $_POST["class-code"];
    if( isset($_POST["class-code"])) $classCode = $_POST["class-code"];
    else $classCode = str_replace("Class Code: ", "", $_GET["class-code"]);
    // echo $classCode;
    $instrCtrlr = new InstructorController();
    $details = $instrCtrlr->getClassDetails($classCode);
    
    header('content-type: application/json');
    echo json_encode($details);

    //  echo md5($classCode);
}

