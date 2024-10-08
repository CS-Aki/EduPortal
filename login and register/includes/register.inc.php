<?php
if(session_id() === "") session_start();

if(isset($_POST["registerBtn"]))
{
    header("Location: register.php");
}

// Register Button inside register.php
// Gets the user input and instantiate the controller to pass in arguments

if(isset($_POST["regBtn"])){
  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $repeatPass = $_POST["repeatPass"];

  $userController = new RegisterController($name, $email, $password, $repeatPass);
  $userController->registerUser();
}

if(isset($_POST["backBtn"]))
{
  unset($_SESSION['google_email']);
  unset($_SESSION['google_name']);
  unset($_SESSION['passwordOnly']);

  echo "back";
  header("Location: login.php");
}
