<?php
//Create a function to pass in as arguments to the model function
//After receiving data from model, pass it into viewer
//If error occurs from the model function, it'll send error signal to viewer, the viewer will then display error msg

class RegisterController extends User{
    private $name;
    private $email;
    private $password;
    private $repeatPass;

    function __construct($name, $email, $password, $repeatPass){
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->repeatPass = $repeatPass;
        if(session_id() === "")session_start();
    }

    // Registration of User
    // Handles error handling, communicates with model and view
    public function registerUser(){

        $view = new UserView;

        if($this->isEmptyInput() == true){
          $_SESSION["msg"] = "Please fill out all the necessary information";
        //  $view->showRegistrationErrorMsg("Please fill out all the necessary information");
          header("Location: register.php?error=emptyInput");
          exit();
        }

        if($this->invalidName() == true){
          $_SESSION["msg"] = "Special Characters aren't allowed in name, please try again";
      //  echo $view->showRegistrationErrorMsg("Special Characters aren't allowed, please try again");
          header("Location: register.php?error=invalidNameInput");
          exit();
        }

        if($this->invalidEmail() == true){
          $_SESSION["msg"] = "Invalid Email Format";
          //echo $view->showRegistrationErrorMsg("Invalid Email Format");
          header("Location: register.php?error=invalidEmail");
          exit();
        }

        if($this->isPasswordMatch() != true){
          $_SESSION["msg"] = "Password Mismatch";
         // echo $view->showRegistrationErrorMsg("Password Mismatch");
          header("Location: register.php?error=passwordMismatch");
          exit();
        }

        if($this->isUserRegistered($this->name, $this->email) == true){
           $_SESSION["msg"] = "User Already registered";
          // echo $view->showRegistrationErrorMsg("User Already registered");
           header("Location: register.php?error=userAlreadyRegistered");
           exit();
        }

        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        $result = $this->insertUser($this->name, $this->email, $hashedPassword);
        $_SESSION["msg"] = "SUCCESSFULLY REGISTERED";
        unset($_SESSION['google_email']);
        unset($_SESSION['google_name']);
        unset($_SESSION['passwordOnly']);
       // echo $view->showRegistrationMsg($result);
    }

    private function isEmptyInput(){
       if(empty($this->name) || empty($this->email) || empty($this->password) || empty($this->repeatPass)){
         return true;
       }else{
         return false;
       }
    }

    private function invalidName(){
      if(!preg_match("/^[a-zA-Z ]*$/", $this->name)){
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
