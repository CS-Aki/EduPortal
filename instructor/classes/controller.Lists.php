<?php

class ListController extends ClassRm
{
    public function getAllClass($userId)
    {
        $resultArr = $this->getClasses($userId);
        return $resultArr;
    }

    public function getClassFromCode()
    {
        $classCode = $_POST["class_code"];
        $resultArr = $this->fetchClassFromCode($classCode);

        if (count($resultArr) == 0 || count($resultArr) == null) {
            $_SESSION["msg"] = "No Record Found";
            if ($_GET['adminBtn'] == "Class List") {
                header("Location: admin-dashboard.php?adminBtn=Class List");
            }else{
                header("Location: admin-dashboard.php?adminBtn=Update Class");
            }
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

    public function displayList($classCode){
        return $this->fetchStudentList($classCode);
    }

    public function displayAttendanceList($classCode){
        return $this->fetchStudentAttndList($classCode);
    }

    public function displayQuizList($classCode){
        return $this->fetchQuizzes($classCode);
    }

    
    public function displayQuiz($classCode, $postId){
        return $this->fetchQuiz($classCode, $postId);
    }

    public function getActSubmission($classCode){
        return $this->getActsSubInDb($classCode);
    }

    public function getQuizSubmission($classCode){
        return $this->getQuizSubmissionInDb($classCode);
    }

}