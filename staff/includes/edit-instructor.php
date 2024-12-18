<?php

if(isset($_POST["instructorName"])){

    require_once("../classes/connection.php");
    require_once("../classes/model.Prof.php");
    require_once("../classes/controller.Prof.php");
    
    $instructorName = $_POST["instructorName"];
    $status = $_POST["status"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];
    $oldName = $_POST["oldName"];
    $birthdate = $_POST["birthdate"];
    $userId = $_POST["userId"];
    $password = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : null;
    // echo $instructorName;
    $instController = new InstructorController();
    $result = $instController->changeProfDetails($instructorName, $status, $email, $gender, $address, $oldName, $userId, $birthdate, $password);

    if($result){
        echo "Update Success";
    }
   
}