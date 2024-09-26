<?php 
         
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $controller = new Controller;

        if(isset($_POST["loginBtn"])){
            echo $controller->fetchUser();
            $email = $_POST["email"];
            $password = $_POST["password"];
            echo "Login Button Clicked: " . $email;
        }


    }
