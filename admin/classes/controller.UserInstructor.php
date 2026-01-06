<?php
//Create a function to pass in as arguments to the model function
//After receiving data from model, pass it into viewer
//If error occurs from the model function, it'll send error signal to viewer, the viewer will then display error msg

class RegisterInstructorController extends UserInstructor
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
    //   echo   $this->name . "\n";
    //   echo   $this->email . "\n";
    //   echo   $this->password . "\n";
    //   echo   $this->repeatPass . "\n";
    //   echo   $this->birthdate . "\n";
    //   echo   $this->gender . "\n";
    //   echo   $this->address . "\n";

      echo "Fill in all fields!";
      
      //  $view->showRegistrationErrorMsg("Please fill out all the necessary information");
      //  header("Location: index.php?error=emptyInput");
      exit();
    }

    if ($this->invalidName() == true) {
     
      echo "Special Characters or Numbers Are Not Allowed in Name!";
     
      //  echo $view->showRegistrationErrorMsg("Special Characters aren't allowed, please try again");
      // header("Location: index.php?error=invalidNameInput");
      return;
    }

    if ($this->invalidEmail() == true) {
      
      echo "Invalid Email Format!";
    
      //echo $view->showRegistrationErrorMsg("Invalid Email Format");
      // header("Location: index.php?error=invalidEmail");
      return;
    }

    if($this->gender == "blank"){
  
      echo "Please Choose a Gender!";
    
      //echo $view->showRegistrationErrorMsg("Invalid Email Format");
      // header("Location: index.php?error=invalidEmail");
      return;
    }

    $year = date("Y"); 
    $validAge = $year - 5;
    
    if(substr($this->birthdate, 0, 4) >= $validAge){
        
        echo "Invalid Birth Date, You Must Be 6 Years old or older";
        
        //echo $view->showRegistrationErrorMsg("Invalid Email Format");
        // header("Location: index.php?error=invalidEmail");
        exit();
    }
    

    if ($this->isUserRegistered($this->name, $this->email) == true) {
     
      echo "User Already registered!>";
     
      // echo $view->showRegistrationErrorMsg("User Already registered");
      // header("Location: index.php?error=userAlreadyRegistered");
      exit();
    }
    
    if ($this->isValidPassLen() == true){
        echo "Password must be 4 characters or more!";
        exit();
    }

    if ($this->isPasswordMatch() != true) {
      
      echo "Password Does Not Match";
     
      // echo $view->showRegistrationErrorMsg("Password Mismatch");
      // header("Location: index.php?error=passwordMismatch");
      exit();
    }

    $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

    $result = $this->insertUser($this->name, $this->email, $hashedPassword, $this->birthdate, $this->gender, $this->address);

    unset($_SESSION['google_email']);
    unset($_SESSION['google_name']);
    unset($_SESSION['passwordOnly']);

    echo "Registration Success";
  

    // echo $view->showRegistrationMsg($result);
    return;
  }
  
    private function isValidPassLen(){
        if(strlen($this->password) < 4 || strlen($this->repeatPass) < 4){
          return true;
        }
        
        return false;
    
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
    if (!preg_match("/^[a-zA-Z. ]*$/", $this->name)) {
      return true;
    } else {
      return false;
    }
  }

  private function invalidEmail()
  {
    if (!filter_var($this->email, FILTER_VALIDATE_EMAIL) || strpos($this->email, '@gmail.com') === false) {
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
