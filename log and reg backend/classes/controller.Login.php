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
            echo "<div class='alert alert-danger' role='alert'>";
            echo "<span>Fill in all fields!</span>";
            echo "</div>";
            // $_SESSION["msg"] = "Please fill out all the necessary information";
            // header("Location: index.php?error=emptyInput");
            exit();
        }  

        if($this->invalidEmail() == true){
            echo "<div class='alert alert-danger' role='alert'>";
            echo "<span>Invalid Email Format!</span>";
            echo "</div>";
            // $_SESSION["msg"] = "Invalid Email Format";
            // header("Location: index.php?error=invalidEmail");
            exit();
        }

        if($this->isUserActive($this->email) == false){
            echo "<div class='alert alert-danger' role='alert'>";
            echo "<span>User Account Suspended or Does Not Exist!</span>";
            echo "</div>";
            // $_SESSION["msg"] = "Invalid Email Format";
            // header("Location: index.php?error=invalidEmail");
            exit();
        }



        $user = $this->isUserCredentialCorrect($this->email, $this->password);
        $_SESSION["msg"] = "Logged In";
        $num = $user[0]["user_id"];
        $_SESSION["user_id"] = $user[0]["user_id"];
        $_SESSION["user_category"] = $user[0]["user_category"];
        $_SESSION["email"] = $user[0]["email"];
        // $_SESSION["name"] = $user[0]["name"];
        $_SESSION["name"] = $user[0]["name"];
        $_SESSION["address"] = $user[0]["address"];
        $_SESSION['google_loggedin'] = true;
        $_SESSION['google_email'] = $user[0]["email"];
        $_SESSION['google_name'] = $user[0]["name"];
        $_SESSION["birthdate"] = $user[0]["birthdate"];
        $_SESSION["gender"] = $user[0]["gender"];
     //   $google_picture = $_SESSION['google_picture'];
        $userId = $this->getUserId($_SESSION['google_email'], $_SESSION['google_name']);
        $_SESSION['user_id'] = $userId[0]['user_id'];
     //   echo  $_SESSION['google_email'] . "<br>" . $_SESSION['user_id'];
         echo "<div class='alert alert-success' role='alert'>";
         echo "<span>{$user[0]["user_category"]}</span>";
         echo "<span>Login Successfully</span>";
         echo "</div>";
         session_regenerate_id();

         $_SESSION['unset'] = "unset";

    }

    // public function sendSession($email, $session){
    //     $this->insertSession($email, $session);
    // }

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
