<?php
//Create a function to pass in as arguments to the model function
//After receiving data from model, pass it into viewer
//If error occurs from the model function, it'll send error signal to viewer, the viewer will then display error msg

class RegisterController extends User
{
  private $name;
  private $email;
  private $password;
  private $repeatPass;
  private $birthdate;
  private $gender;
  private $address;

  function __construct($name, $email, $password, $repeatPass, $birthdate, $gender, $address)
  {
    $this->name = $name;
    $this->email = $email;
    $this->password = $password;
    $this->repeatPass = $repeatPass;
    $this->birthdate = $birthdate;
    $this->gender = $gender;
    $this->address = $address;
    
    if (session_id() === "") session_start();
  }

  // Registration of User
  // Handles error handling, communicates with model and view
  public function registerUser()
  {
    
    if ($this->isEmptyInput() == true) {
      echo "<br><div class='alert alert-danger' role='alert'>";
      echo "<span>Fill in all fields!</span>";
      echo "</div>";
      //  $view->showRegistrationErrorMsg("Please fill out all the necessary information");
      //  header("Location: index.php?error=emptyInput");
      exit();
    }

    if ($this->invalidName() == true) {
      echo "<br><div class='alert alert-danger' role='alert'>";
      echo "<span>Special Characters are not allowed in name!</span>";
      echo "</div>";
      //  echo $view->showRegistrationErrorMsg("Special Characters aren't allowed, please try again");
      // header("Location: index.php?error=invalidNameInput");
      exit();
    }

    if ($this->invalidEmail() == true) {
      echo "<br><div class='alert alert-danger' role='alert'>";
      echo "<span>Invalid Email Format!</span>";
      echo "</div>";
      //echo $view->showRegistrationErrorMsg("Invalid Email Format");
      // header("Location: index.php?error=invalidEmail");
      exit();
    }

    if($this->gender == "blank"){
      echo "<br><div class='alert alert-danger' role='alert'>";
      echo "<span>Please Choose a Gender!</span>";
      echo "</div>";
      //echo $view->showRegistrationErrorMsg("Invalid Email Format");
      // header("Location: index.php?error=invalidEmail");
      exit();
    }

    $year = date("Y"); 
    $validAge = $year - 5;
    
    if(substr($this->birthdate, 0, 4) >= $validAge){
        echo "<br><div class='alert alert-danger' role='alert'>";
        echo "<span>Invalid Birth Date, You Must Be 6 Years old or older</span>";
        echo "</div>";
        //echo $view->showRegistrationErrorMsg("Invalid Email Format");
        // header("Location: index.php?error=invalidEmail");
        exit();
    }
    

    if ($this->isUserRegistered($this->name, $this->email) == true) {
      echo "<br><div class='alert alert-danger' role='alert'>";
      echo "<span>User Already registered!</span>";
      echo "</div>";
      // echo $view->showRegistrationErrorMsg("User Already registered");
      // header("Location: index.php?error=userAlreadyRegistered");
      exit();
    }

    if ($this->isPasswordMatch() != true) {
      echo "<br><div class='alert alert-danger' role='alert'>";
      echo "<span>Password Does Not Match</span>";
      echo "</div>";
      // echo $view->showRegistrationErrorMsg("Password Mismatch");
      // header("Location: index.php?error=passwordMismatch");
      exit();
    }

    $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

    $result = $this->insertUser($this->name, $this->email, $hashedPassword, $this->birthdate, $this->gender, $this->address);

    unset($_SESSION['google_email']);
    unset($_SESSION['google_name']);
    unset($_SESSION['passwordOnly']);

    echo "<div class='alert alert-success' role='alert'>";
    echo "<span>REGISTRATION SUCCESSFULLY</span>";
    echo "</div>";

    // echo $view->showRegistrationMsg($result);
  }

  private function isEmptyInput()
  {
    if (empty($this->name) || empty($this->email) || empty($this->password) || empty($this->repeatPass)) {
      return true;
    } else {
      return false;
    }
  }

  private function invalidName()
  {
    if (!preg_match("/^[a-zA-Z ]*$/", $this->name)) {
      return true;
    } else {
      return false;
    }
  }

  private function invalidEmail()
  {
    if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
      return true;
    } else {
      return false;
    }
  }

  private function isPasswordMatch()
  {
    if ($this->password === $this->repeatPass) {
      return true;
    } else {
      return false;
    }
  }
}
