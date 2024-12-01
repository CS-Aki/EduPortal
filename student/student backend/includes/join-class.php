<?php 
require_once("../../../log and reg backend/classes/connection.php");
require_once("../classes/model.ClassRm.php");
require_once("../classes/controller.Lists.php");
require_once("../classes/controller.Student.php");
if (session_id() === "") session_start();

if(isset($_POST["joinClassBtn"])){

     $classCode = $_POST["class_code"];
     $stdController = new StudentController();

    //  echo $_SESSION['google_email'] . "<br>" .  $_SESSION['google_name'] . "<br>";
    //  echo $_SESSION['user_id'];
    $stdController->joinClass($classCode);

}

?>