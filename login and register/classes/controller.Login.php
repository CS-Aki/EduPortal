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

        $this->isUserCredentialCorrect($this->email, $this->password);
        $_SESSION["msg"] = "Logged In";
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