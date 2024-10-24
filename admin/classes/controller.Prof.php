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
        $profName = $_POST["user_name"];

        $list = $this->fetchAllProfClass($profName);
        if($list == 0 || $list == null){
            echo "Error";
            return;
        }

        return $list;

    }
}
