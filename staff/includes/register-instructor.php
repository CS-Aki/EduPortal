<?php

require_once("../classes/connection.php");
require_once("../classes/model.RegisterInstructor.php");
require_once("../classes/controller.UserInstructor.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $firstName = trim($_POST['firstName']);
  $lastName = trim($_POST['lastName']);
  $middleName = trim($_POST['middleName']);
  $email = trim($_POST['email']);
  $birthdate = $_POST['birthdate'];
  $gender = $_POST['gender'];
  $address = trim($_POST['address']);
  $password = $_POST['password'];
  $repeatPass = $_POST["repeatPass"];

  if($middleName == ""){
    $name = $firstName . " " . $lastName;
  }else{
    $name = $firstName . " " . $middleName ." " . $lastName;
  }
 
  $userController = new RegisterInstructorController($name, $email, $password, $repeatPass, $birthdate, $gender, $address);
  if($userController->registerUser()){
      echo "Registration Success";
  }
}

?>