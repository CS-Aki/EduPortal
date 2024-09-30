<?php

class LoginController extends User{
    private $email;
    private $password;

    function __construct($email, $password){
        $this->email = $email;
        $this->password = $password;
        session_start();
    }

    public function loginUser(){

        if($this->isEmptyInput() == true){
            $_SESSION["msg"] = "Please fill out all the necessary information";
          //  $view->showRegistrationErrorMsg("Please fill out all the necessary information");
            header("Location: login.php?error=emptyInput");
            exit();
        }

        if($this->invalidEmail() == true){
            $_SESSION["msg"] = "Invalid Email Format";
            //echo $view->showRegistrationErrorMsg("Invalid Email Format");
            header("Location: login.php?error=invalidEmail");
            exit();
        }

        $user = $this->isUserCredentialCorrect($this->email, $this->password);
        $_SESSION["msg"] = "Logged In";
        $_SESSION["user_id"] = $user[0]["user_id"];
        $_SESSION["user_category"] = $user[0]["user_category"];
        // $_SESSION["email"] = $user[0]["email"];
        // $_SESSION["name"] = $user[0]["name"];

        $_SESSION['google_loggedin'] = true;
        $_SESSION['google_email'] = $user[0]["email"];
        $_SESSION['google_name'] = $user[0]["name"];;
     //   $google_picture = $_SESSION['google_picture'];

        header("Location: ../login and register/profile.php");
    }

    private function isEmptyInput(){
        if(empty($this->email) || empty($this->password)){
          return true;
        }else{
          return false;
        }
     }

    private function invalidEmail(){
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            return true;
        }else{
            return false;
        }
    }

      private function isPasswordMatch(){
        // if($this->password){
        //   return true;
        // }else{
        //   return false;
        // }
      }

}
