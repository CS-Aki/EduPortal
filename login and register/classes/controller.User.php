<?php
//Create a function to pass in as arguments to the model function
//After receiving data from model, pass it into viewer
//If error occurs, it'll still send error signal to viewer
class UserController extends User{
    private $name;
    private $email;
    private $password;
    private $repeatPass;

    function __construct($name, $email, $password, $repeatPass){
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->repeatPass = $repeatPass;
    }

    public function registerUser(){
        if($this->isEmptyInput() == true){
          header("Location: register.php?error=emptyInput");
          exit();
        }

        if($this->invalidName() == true){
          header("Location: register.php?error=invalidNameInput");
          exit();
        }

        if($this->invalidEmail() == true){
          header("Location: register.php?error=invalidEmail");
          exit();
        }

        if($this->isPasswordMatch() != true){
          header("Location: register.php?error=passwordMismatch");
          exit();
        }

    }

    private function isEmptyInput(){
       if(empty($this->name) || empty($this->email) || empty($this->password) || empty($this->repeatPass)){
         return true;
       }else{
         return false;
       }
    }

    private function invalidName(){
      if(!preg_match("/^[a-zA-Z]*$/", $this->name)){
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
      if($this->password === $this->repeatPass){
        return true;
      }else{
        return false;
      }
    }

}
