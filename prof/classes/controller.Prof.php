<?php

class InstructorController extends Instructor
{
    public function getProfClass(){
        $classList = $this->fetchInstructorClass();
        return $classList;
    }

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
        $profName = $_POST["user_name"];

        $list = $this->fetchAllProfClass($profName);
        if($list == 0 || $list == null){
            echo "Error";
            return;
        }

        return $list;
    }

    public function convertClassCode(){
        $classCode = $this->findClassCode();
        echo "Class Code " . $classCode;
        $details = $this->fetchClassDetails($classCode);
        return $details;
    }

    public function getClassDetails($classCode){
        // echo $classCode;
        $details = $this->fetchClassDetails($classCode);
        // echo $details[0]["class_code"];
        return $details;
      //  echo $details[0]["title"];
    }

    public function addPost(){
        $classCode = $_POST["class-code"];
        $title = $_POST["title"];
        $desc = $_POST["desc"];
        $type = $_POST["type"];
        $profName = $_POST["profName"];

        $result = $this->sendPostToDb($classCode,$profName,$title, $desc, $type);
        if($result == false){
            echo "Failed";
        }
    }

    public function getSession(){
        return $this->fetchSession();
    }

    public function changeVisibility($id, $status){
        
        if($status == "Hidden") $status = "Visible";
        else $status = "Hidden";
       
        return $this->visibilityEdit($id, $status);
    }
}
