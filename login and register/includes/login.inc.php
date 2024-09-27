<?php

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST["loginBtn"])){
        $email = $_POST["email"];
        $password = $_POST["password"];

        include("classes/connection.php");
        include("classes/model.User.php");
        include("classes/controller.Login.php");
        include("classes/view.User.php");

    }
}
