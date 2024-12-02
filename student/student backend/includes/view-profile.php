<?php

require_once("../log and reg backend/classes/connection.php");
require_once("student backend/classes/model.ClassRm.php");
require_once("student backend/classes/controller.Lists.php");
require_once("student backend/classes/controller.Student.php");

if(isset($_SESSION["name"])){
    $stdController = new StudentController();
    $profile = $stdController->getProfileDetails($_SESSION["name"], $_SESSION["email"]);
    $id = $profile[0]["user_id"];
    $currentDate = new DateTime();
    $year = $currentDate->format("Y");
    
    $id = sprintf("%04d", $id);
    $userId = $year . "" . $id . "-S";

}