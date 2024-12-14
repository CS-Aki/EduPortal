<?php

if(isset($_POST["studentName"])){

    require_once("../classes/connection.php");
    require_once("../classes/model.Student.php");
    require_once("../classes/controller.Student.php");
    
    $studentName = $_POST["studentName"];
    $status = $_POST["status"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];
    $oldName = $_POST["oldName"];
    $id = $_POST["id"];
    $birthdate = $_POST["birthdate"];

    $stdController = new StudentController();
    $result = $stdController->changeStudentDetails($studentName, $status,  $email,  $gender, $address, $oldName, $id, $birthdate);

    if($result){
        echo "Update Success";
    }
   
}