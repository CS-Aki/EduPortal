<?php

require_once("classes/connection.php");
require_once("classes/model.Staff.php");
require_once("classes/controller.Staff.php");

if(isset($_SESSION["name"])){
    $staffController = new StaffController();
    $profile = $staffController->getStaffDetail($_SESSION["name"], $_SESSION["email"]);
    // echo var_dump($profile);
    $id = $profile[0]["user_id"];
    $currentDate = new DateTime();
    $year = substr($profile[0]["created"], 0, 4);
    
    $id = sprintf("%04d", $id);
    $userId = $year . "" . $id . "-S";

}