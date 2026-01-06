<?php

class StudentController extends Student{
    public function getAllStudents(){
        $list = $this->fetchAllStudent();
        
        if($list == null || count($list) == 0){
            echo "No student found";
            return;
        }

        return $list;
    }

    public function getStudentClasses(){
        $studentName = $_POST["userName"];
        $studentId = $_POST["userId"];
        $list = $this->fetchStudentClasses($studentName, $studentId);
     
        if($list == null || count($list) == 0){
            // echo "No Student Record Found";
            return;
        }

        return $list;
    }

    public function getStudentDetail(){
        $studentName = $_POST["userName"];
        $studentId = $_POST["userId"];
        $studentDetail = $this->fetchStudentDetails($studentName, $studentId);

        if($studentDetail == null || count($studentDetail) == 0){
            // echo "No Student Record Found";
            return;
        }

        return $studentDetail;
    }

     public function changeStudentDetails($instructorName, $status, $email, $gender, $address, $oldName, $studentCode, $birthdate, $password = null) {
        // Check for invalid inputs in the name
        if ($this->invalidInput($instructorName)) {
            echo "Special characters Or Numbers aren't allowed, please try again.";
            return;
        }
    
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email address.";
            return;
        }
        
        if ($this->isValidPassLen($password) == true){
            echo "Password must be 4 characters or more!";
            return;
        }
    
        $result = $this->updateStudentDetails($instructorName, $status, $email, $gender, $address, $oldName, $studentCode, $birthdate, $password);
    
        if ($result === false || $result === null) {
            echo "Error updating student details.";
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

    private function isValidPassLen($password){
          if(strlen($password) < 4){
              return true;
          }
          
          return false;
          
    }
}