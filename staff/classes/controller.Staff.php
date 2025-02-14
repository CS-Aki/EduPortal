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

    public function changeStaffDetails($staffName, $status,  $email,  $gender, $address, $oldName, $staffCode, $birthdate){
        if($this->invalidInput($staffName)){
            echo "Special Characters aren't allowed, please try again";
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email address.";
            return;
        } 

        $result = $this->updateStaffDetails($staffName, $status,  $email,  $gender, $address, $oldName, $staffCode, $birthdate);

        if($result == false || $result == null){
            echo "Error changeProfDetails";
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

    public function getProfileDetails($name, $email){
        $profile = $this->fetchStudentProfile($name, $email);
    
        return $profile;
    }

    public function updatePicture($userId, $profile){
        return $this->updateProfilePicture($userId, $profile);
    }
}
