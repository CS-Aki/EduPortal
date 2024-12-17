<?php

require_once("../log and reg backend/classes/connection.php");
require_once("classes/model.Staff.php");
require_once("classes/controller.Staff.php");

if(isset($_SESSION["name"])){
    $staffController = new StaffController();
    $profile = $staffController->getProfileDetails($_SESSION["name"], $_SESSION["email"]);
    $id = $profile[0]["user_id"];
    $currentDate = new DateTime();
    $year = $currentDate->format("Y");
    
    $id = sprintf("%04d", $id);
    $userId = $year . "" . $id . "-S";

}