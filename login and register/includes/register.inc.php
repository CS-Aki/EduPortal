<?php

if(isset($_POST["registerBtn"]))
{
    header("Location: register.php");
}

if(isset($_POST["regBtn"])){
  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $repeatPass = $_POST["repeatPass"];

  include("classes/connection.php");
  include("classes/model.User.php");
  include("classes/controller.User.php");

  $userController = new UserController($name, $email, $password, $repeatPass);
  $userController->registerUser();
}

if(isset($_POST["backBtn"]))
{
      echo"test";
      header("Location: login.php");
}
