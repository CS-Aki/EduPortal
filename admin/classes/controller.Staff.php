<?php

class StaffController extends Staff{
    public function getAllStaff()
    {
        $instructorList = $this->fetchAllStaff();

        if (count($instructorList) == 0 || count($instructorList) == null) {
            $_SESSION["msg"] = "No Records Founds";
            header("Location: admin-dashboard.php?adminBtn=Instructor List");
            exit();
        }

        return $instructorList;
    }

    public function getStaffDetail(){
        $userId = $_POST["userId"];
        $userName = $_POST["userName"];

        return $this->getStaffDetailInDb($userId, $userName);
    }

     public function changeStaffDetails($staffName, $status, $email, $gender, $address, $oldName, $staffCode, $birthdate, $password = null) {
        if ($this->invalidInput($staffName)) {
            echo "Special characters Or Numbers aren't allowed, please try again.";
            return;
        }
    
        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email address.";
            return;
        }
        
            
        if ($this->isValidPassLen($password) == false){
            echo "Password must be 4 characters or more!";
            return;
        }

        $result = $this->updateStaffDetails($staffName, $status, $email, $gender, $address, $oldName, $staffCode, $birthdate, $password);
    
        if ($result === false || $result === null) {
            echo "Error: Unable to update staff details.";
            return;
        }
    
        return $result;
    }

    private function invalidInput($staffName)
    {
        if (!preg_match("/^[a-zA-Z. ]*$/", $staffName)) {
            return true;
        }

        if (!preg_match("/^[a-zA-Z0-9. ]*$/", $staffName)) {
            return true;
        }

        return false;
    }
    
    private function isValidPassLen($password){
          if(strlen($password) < 4 && strlen($password) != 0){
              return false;
          }
          return true;
    }
}
