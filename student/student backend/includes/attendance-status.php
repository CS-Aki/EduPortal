<?php 

require_once("../log and reg backend/classes/connection.php");
require_once("student backend/classes/model.ClassRm.php");
require_once("student backend/classes/controller.Lists.php");
require_once("student backend/classes/controller.Student.php");

if (session_id() === "") session_start();

$stdController = new StudentController();

$status = $stdController->getAttendance($_SESSION["id"]);

if($status == null || count($status) == 0){
    echo "Pending";
}else{
    echo $status[0]["status"];
}


