<?php

require_once("../classes/connection.php");
require_once("../classes/model.User.php");
require_once("../classes/controller.Register.php");

if(isset($_POST["registerBtn"])){
  $firstName = $_POST["firstName"];
  $middleName = $_POST["middleName"];
  $lastName = $_POST["lastName"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $repeatPass = $_POST["repeatPass"];
  $birthdate = $_POST["birthdate"];
  $gender = $_POST["gender"];
  $address = $_POST["address"];
  
  if($middleName == ""){
    $name = $firstName . " " . $lastName;
  }else{
    $name = $firstName . " " . $middleName ." " . $lastName;
  }
 
   $userController = new RegisterController($name, $email, $password, $repeatPass, $birthdate, $gender, $address);
   $userController->registerUser();
}

?>