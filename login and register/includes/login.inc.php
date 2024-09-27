<?php

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST["loginBtn"])){
        $email = $_POST["email"];
        $password = $_POST["password"];

        $loginController = new LoginController($email, $password);
        $loginController->loginUser();
    }
}
