<?php

class ClassRmController extends ClassRm
{
    private $classCode;
    private $className;
    private $classSchedule;
    private $classProf;
    private $status;

    function __construct($classCode, $className, $classSchedule, $classProf, $status)
    {
        $this->classCode = $classCode;
        $this->className = $className;
        $this->classSchedule = $classSchedule;
        $this->classProf = $classProf;
        $this->status = $status;
        //   if(session_id() === "") session_start();
        if (isset($_SESSION["msg"])) unset($_SESSION["msg"]);
    }

    public function addClass()
    {
        while ($this->isClassCodeExist($this->classCode) == true) {
            $this->classCode = generateClassCode();
        }

        if ($this->isEmpty() == true) {
            $_SESSION["msg"] = "Please fill out all the necessary information";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidInput");
            header("Location: admin-dashboard.php?adminBtn=Add Class");
            exit();
        }

        if ($this->invalidInput() == true) {
            $_SESSION["msg"] = "Special Characters aren't allowed, please try again";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidCharacterInput");
            header("Location: admin-dashboard.php?adminBtn=Add Class");
            exit();
        }

        if ($this->isClassNameExist($this->className) == true) {
            $_SESSION["msg"] = "Class already exist";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=classAlreadyExist");
            header("Location: admin-dashboard.php?adminBtn=Add Class");
            exit();
        }

        if ($this->isEmptySched() == true) {
            $_SESSION["msg"] = "Invalid Schedule Input";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidScheduleInput");   
            header("Location: admin-dashboard.php?adminBtn=Add Class");
            exit();
        }

        if ($this->isEmptyStatus() == true) {
            $_SESSION["msg"] = "Choose a status";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidStatusOption");       
            header("Location: admin-dashboard.php?adminBtn=Add Class");
            exit();
        }

        if ($this->invalidScheduleDate() == true) {
            $_SESSION["msg"] = "Invalid Schedule Date";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidScheduleDate"); 
            header("Location: admin-dashboard.php?adminBtn=Add Class");
            exit();
        }

        // Add validator to compare to and from schedule, value should be greater than the TO schedule
        $fullSched = "(" . $this->classSchedule["day"] . ") " . $this->classSchedule["startingHour"] . ":" . $this->classSchedule["startingMin"] . " " . $this->classSchedule["startTimePeriod"] . "-" . $this->classSchedule["endingHour"] . ":" . $this->classSchedule["endingMin"] . " " . $this->classSchedule["endTimePeriod"];

        $result = $this->addNewClass($this->classCode, $this->className, $fullSched, $this->classProf, $this->status);

        if ($result == true) {
            $_SESSION["msg"] = "New Class Successfully Added";
            unset($_SESSION["msg"]);
            unset($_SESSION["className"]);
            unset($_SESSION["classProf"]);
            unset($_SESSION['daySched']);
            unset($_SESSION['startingHourSched']);
            unset($_SESSION['startingMinSched']);
            unset($_SESSION['startTimePeriod']);
            unset($_SESSION['endingHourSched']);
            unset($_SESSION['endingMinSched']);
            unset($_SESSION['endTimePeriod']);
            unset($_SESSION['status']);
        } else {
            $_SESSION["msg"] = "Failed to Add New Class";
        }
    }

    public function editClass()
    {
        if ($this->isEmpty() == true) {
            $_SESSION["msg"] = "Please fill out all the necessary information";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidInput");
            header("Location: admin-dashboard.php?adminBtn=Update Class");
            exit();
        }

        if ($this->invalidInput() == true) {
            $_SESSION["msg"] = "Special Characters aren't allowed, please try again";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidCharacterInput");
            header("Location: admin-dashboard.php?adminBtn=Update Class");
            exit();
        }

        if ($_SESSION['list'][$_SESSION['classNumber']]['class_name'] != $this->className) {
            if ($this->isClassNameExist($this->className) == true) {
                $_SESSION["msg"] = "Class already exist";
                // header("Location: admin-dashboard.php?adminBtn=Add Class error=classAlreadyExist");
                header("Location: admin-dashboard.php?adminBtn=Update Class");
                exit();
            }
        }

        if ($this->isEmptySched() == true) {
            $_SESSION["msg"] = "Invalid Schedule Input";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidScheduleInput");   
            header("Location: admin-dashboard.php?adminBtn=Update Class");
            exit();
        }

        if ($this->isEmptyStatus() == true) {
            $_SESSION["msg"] = "Choose a status";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidStatusOption");       
            header("Location: admin-dashboard.php?adminBtn=Update Class");
            exit();
        }

        if ($this->invalidScheduleDate() == true) {
            $_SESSION["msg"] = "Invalid Schedule Date";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidScheduleDate"); 
            header("Location: admin-dashboard.php?adminBtn=Update Class");
            exit();
        }
        // echo $this->className . "<br>" . $this->status;
        $fullSched = "(" . $this->classSchedule["day"] . ") " . $this->classSchedule["startingHour"] . ":" . $this->classSchedule["startingMin"] . " " . $this->classSchedule["startTimePeriod"] . "-" . $this->classSchedule["endingHour"] . ":" . $this->classSchedule["endingMin"] . " " . $this->classSchedule["endTimePeriod"];

        $result = $this->editClassInfo($this->classCode, $this->className, $fullSched, $this->classProf, $this->status);
        if ($result == true) {
            $_SESSION["msg"] = "Edit Successfully";
        } else {
            $_SESSION["msg"] = "Edit Failed";
        }
    }

    private function isEmpty()
    {
        if (empty($this->classCode) || empty($this->className) || empty($this->classSchedule) || empty($this->classProf)) {
            return true;
        } else {
            return false;
        }
    }

    private function invalidInput()
    {
        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $this->className) || !preg_match("/^[a-zA-Z0-9 .]*$/", $this->classProf)) {
            return true;
        } else {
            return false;
        }
    }

    private function isEmptySched()
    {
        foreach ($this->classSchedule as $key => $value) {
            if ($value == "blank") {
                return true;
            }
        }
        return false;
    }

    private function isEmptyStatus()
    {
        if ($this->status == "blank") {
            return true;
        }

        return false;
    }

    private function invalidScheduleDate()
    {
        // echo $this->classSchedule["startTimePeriod"] . " " . $this->classSchedule["endTimePeriod"] . "<br>";
        // echo $this->classSchedule["endingHour"] . " " . $this->classSchedule["startingHour"] . "<br>";
        // echo $this->classSchedule["endingMin"] . " " . $this->classSchedule["startingMin"] . "<br>";

        if ($this->classSchedule["startTimePeriod"] == $this->classSchedule["endTimePeriod"]) {
            if ($this->classSchedule["endingHour"] <= $this->classSchedule["startingHour"] || $this->classSchedule["endingMin"] < $this->classSchedule["startingMin"]) {
                return true;
            }
        }

        return false;
    }
}
