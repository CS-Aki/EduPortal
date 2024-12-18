<?php

if(isset($_POST["staffName"])){

    require_once("../classes/connection.php");
    require_once("../classes/model.Staff.php");
    require_once("../classes/controller.Staff.php");

    $staffName = $_POST["staffName"];
    $status = $_POST["status"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];
    $oldName = $_POST["oldName"];
    $id = $_POST["id"];
    $birthdate = $_POST["birthdate"];
    $password = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : null;

    $staffController = new StaffController();
    $result = $staffController->changeStaffDetails($staffName, $status, $email, $gender, $address, $oldName, $id, $birthdate, $password);

    if($result){
        echo "Update Success";
    }
   
}