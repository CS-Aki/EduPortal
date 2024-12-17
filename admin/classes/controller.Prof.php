<?php

class InstructorController extends Instructor
{
    public function getAllProf()
    {
        $instructorList = $this->fetchAllInstructor();

        if (count($instructorList) == 0 || count($instructorList) == null) {
            $_SESSION["msg"] = "No Records Founds";
            header("Location: admin-dashboard.php?adminBtn=Instructor List");
            exit();
        }

        return $instructorList;
    }

    public function searchInstructor()
    {
        $profName = $_POST["searchClassInstructor"];
        $result = $this->findInstructor($profName);
        if (count($result) == 0 || count($result) == null) {
            $_SESSION["msg"] = "No Records Founds";
            header("Location: admin-dashboard.php?adminBtn=Instructor List");
            exit();
        }
        return $result;
    }

    public function getAllProfClasses(){
        $profName = $_POST["userName"];
        $userId = $_POST["userId"];
        $list = $this->fetchAllProfClass($profName, $userId);

        if($list == 0 || $list == null){
            $profDetails = $this->findInstructor($profName, $userId);
            return $profDetails;
        }

        return $list;
    }

    public function changeProfDetails($instructorName, $status,  $email,  $gender, $address, $oldName, $birthdate, $userId){
        if($this->invalidInput($instructorName)){
            echo "Special Characters Are Not Allowed!";
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strpos($email, '@gmail.com') === false) {
            echo "Invalid email address";
            return;
        } 

        $result = $this->updateProfDetails($instructorName, $status,  $email,  $gender, $address, $oldName, $birthdate, $userId);

        if($result == false || $result == null){
            // echo "Error changeProfDetails";
            return;
        }

        return $result;
    }

    private function invalidInput($instructorName)
    {
        if (!preg_match("/^[a-zA-Z. ]*$/", $instructorName)) {
            return true;
        }

        if (!preg_match("/^[a-zA-Z0-9. ]*$/", $instructorName)) {
            return true;
        }

        return false;
    }
}
