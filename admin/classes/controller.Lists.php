<?php

class ListController extends ClassRm
{
    public function getAllClass()
    {
        $resultArr = $this->getClasses();

        if (count($resultArr) == 0 || count($resultArr) == null) {
            $_SESSION["msg"] = "NO RECORD FOUND";
            //   header("Location: update-class.php?error=fetchingClassInDbError");
            //   header("Location: admin-dashboard.php?adminBtn=Update Class");

            exit();
        }

        return $resultArr;
    }

    public function getClassFromCode($classCode)
    {
        $resultArr = $this->fetchClassFromCode($classCode);

        if (count($resultArr) == 0 || count($resultArr) == null) {
            $_SESSION["msg"] = "No Record Found";
            // if ($_GET['adminBtn'] == "Class List") {
            //     header("Location: admin-dashboard.php?adminBtn=Class List");
            // }else{
            //     header("Location: admin-dashboard.php?adminBtn=Update Class");
            // }
            //   header("Location: update-class.php?error=fetchingClassInDbError");
            
            exit();
        }

        return $resultArr;
    }

    public function getClassFromCName()
    {
        $className = $_POST["searchClass"];
        $resultArr = $this->fetchClassFromCName($className);

        if (count($resultArr) == 0 || count($resultArr) == null) {
            $_SESSION["msg"] = "NO RECORD FOUND";
            if ($_GET['adminBtn'] == "Class List") {
                header("Location: admin-dashboard.php?adminBtn=Class List");
            }else{
                header("Location: admin-dashboard.php?adminBtn=Update Class");
            }
            exit();
        }

        return $resultArr;
    }

    public function getClassFromIns()
    {
        $classIns = $_POST["searchClassIns"];
        $resultArr = $this->fetchClassFromIns($classIns);

        if (count($resultArr) == 0 || count($resultArr) == null) {
            $_SESSION["msg"] = "NO RECORD FOUND";
            if ($_GET['adminBtn'] == "Class List") {
                header("Location: admin-dashboard.php?adminBtn=Class List");
            }else{
                header("Location: admin-dashboard.php?adminBtn=Update Class");
            }
            exit();
        }

        return $resultArr;
    }

    public function countClass()
    {
        return $this->fetchTotalClass();
    }

    // public function getSched(){
    //     include("../admin/includes/edit-init.inc.php");
    //     return getScheduleData();
    // }

    public function getStdFromClass($classCode){
        // $classCode = $_POST["class_code"];
        $list = $this->fetchStudentsFromClass($classCode);
        
        if($list == 0 || $list == null){
            return;
        }

        return $list;
    }

    public function getAllProf(){
        return $this->getAllProfInDb();
    }

}
