<?php 
require_once("../../log and reg backend/classes/connection.php");
require_once("../classes/model.Prof.php");
require_once("../classes/controller.Prof.php");

if(isset($_POST["postBtn"])){
    $classCode = $_POST["class-code"];
    $instrCtrlr = new InstructorController();
    $instrCtrlr->addPost();
    $details = $instrCtrlr->getClassDetails($classCode);
    // echo $details[0]["title"];
   // echo "Success response";
    header('content-type: application/json');
    echo json_encode($details);
    // echo $_POST["class-code"] . "<br>" . $_POST["title"] . "<br>" . $_POST["desc"] . "<br>" . $_POST["type"] . "<br>";
}