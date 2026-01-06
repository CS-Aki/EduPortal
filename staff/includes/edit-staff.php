<?php

if(isset($_POST["staffName"])){

    require_once("../classes/connection.php");
    require_once("../classes/model.Staff.php");
    require_once("../classes/controller.Staff.php");

    $staffName = trim($_POST["staffName"]);
    $status = $_POST["status"];
    $email = trim($_POST["email"]);
    $gender = $_POST["gender"];
    $address = trim($_POST["address"]);
    $oldName = trim($_POST["oldName"]);
    $id = $_POST["id"];
    $birthdate = $_POST["birthdate"];

    $staffController = new StaffController();
    $result = $staffController->changeStaffDetails($staffName, $status,  $email,  $gender, $address, $oldName, $id, $birthdate);

    if($result){
        echo "Update Success";
    }
   
}