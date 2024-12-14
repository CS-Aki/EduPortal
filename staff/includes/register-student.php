<?php

require_once("../classes/connection.php");
require_once("../classes/model.RegisterStudent.php");
require_once("../classes/controller.UserStudent.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $middleName = $_POST['middleName'];
  $email = $_POST['email'];
  $birthdate = $_POST['birthdate'];
  $gender = $_POST['gender'];
  $address = $_POST['address'];
  $password = $_POST['password'];
  $repeatPass = $_POST["repeatPass"];

  if($middleName == ""){
    $name = $firstName . " " . $lastName;
  }else{
    $name = $firstName . " " . $middleName ." " . $lastName;
  }
 
  $userController = new RegisterStudentController($name, $email, $password, $repeatPass, $birthdate, $gender, $address);
  if($userController->registerUser()){
      echo "Registration Success";
  }
}

?>