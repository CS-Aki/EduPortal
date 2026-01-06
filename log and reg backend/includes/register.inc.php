<?php

require_once("../classes/connection.php");
require_once("../classes/model.User.php");
require_once("../classes/controller.Register.php");

if(isset($_POST["registerBtn"])){
  $firstName = trim($_POST["firstName"]);
    $middleName = trim($_POST["middleName"]);
    $lastName = trim($_POST["lastName"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $repeatPass = trim($_POST["repeatPass"]);
    $birthdate = trim($_POST["birthdate"]);
    $gender = trim($_POST["gender"]);
    $address = trim($_POST["address"]);
  
  if($middleName == ""){
    $name = $firstName . " " . $lastName;
  }else{
    $name = $firstName . " " . $middleName ." " . $lastName;
  }
 
   $userController = new RegisterController($name, $email, $password, $repeatPass, $birthdate, $gender, $address);
   $userController->registerUser();
}

?>