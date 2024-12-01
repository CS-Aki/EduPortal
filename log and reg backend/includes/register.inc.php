<?php

require_once("../classes/connection.php");
require_once("../classes/model.User.php");
require_once("../classes/controller.Register.php");

if(isset($_POST["registerBtn"])){
  $firstName = $_POST["firstName"];
  $lastName = $_POST["lastName"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $repeatPass = $_POST["repeatPass"];
  
  $name = $firstName . " " . $lastName;
 
   $userController = new RegisterController($name, $email, $password, $repeatPass);
   $userController->registerUser();
}

?>