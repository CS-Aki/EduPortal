<?php

if(isset($_POST["staffName"])){

    require_once("../classes/connection.php");
    require_once("../classes/model.Staff.php");
    require_once("../classes/controller.Staff.php");

    $staffName = trim($_POST["staffName"]);
    $status = trim($_POST["status"]);
    $email = trim($_POST["email"]);
    $gender = $_POST["gender"];
    $address = trim($_POST["address"]);
    $oldName = trim($_POST["oldName"]);
    $id = $_POST["id"];
    $birthdate = $_POST["birthdate"];
    $password = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : null;

    $staffController = new StaffController();
    $result = $staffController->changeStaffDetails($staffName, $status, $email, $gender, $address, $oldName, $id, $birthdate, $password);

    if($result){
        echo "Update Success";
    }
   
}