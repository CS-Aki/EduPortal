<?php

if(isset($_POST["studentName"])){

    require_once("../classes/connection.php");
    require_once("../classes/model.Student.php");
    require_once("../classes/controller.Student.php");
    
    $studentName = trim($_POST["studentName"]);
    $status = $_POST["status"];
    $email = trim($_POST["email"]);
    $gender = $_POST["gender"];
    $address = trim($_POST["address"]);
    $oldName = trim($_POST["oldName"]);
    $id = $_POST["id"];
    $birthdate = $_POST["birthdate"];
    $password = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : null;

    $stdController = new StudentController();
    $result = $stdController->changeStudentDetails($studentName, $status, $email, $gender, $address, $oldName, $id, $birthdate, $password);

    if($result){
        echo "Update Success";
    }
   
}