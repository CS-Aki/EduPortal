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

        // echo $this->classProf;
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
      
        if($this->noChanges() == true){
            $_SESSION["msg"] = "No Changes";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidInput");
            header("Location: admin-dashboard.php?adminBtn=Update Class");
            exit();
        }

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

        if ($_SESSION['list'][0]['class_name'] != $this->className) {
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
            header("Location: admin-dashboard.php?adminBtn=Update Class");
            exit();
        } else {
            $_SESSION["msg"] = "Edit Failed";
            header("Location: admin-dashboard.php?adminBtn=Update Class");
            exit();
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

        if($this->classSchedule["startTimePeriod"] == $this->classSchedule["endTimePeriod"]){
            if($this->classSchedule["startingHour"] > $this->classSchedule["endingHour"]){
               return true;
            }else if($this->classSchedule["startingHour"] == $this->classSchedule["endingHour"]){
                if($this->classSchedule["startingMin"] >= $this->classSchedule["endingMin"]){
                    return true;
                }
            }
        }

        return false;
    }

    private function noChanges(){
        $_POST["class_code"] = $this->classCode;
        $listController = new ListController();
        $listOfClasses = $listController->getClassFromCode();
        $_SESSION["list"] = $listOfClasses;
      //  echo $listOfClasses[0]["class_num"];
        //$_SESSION['classNumber'] = 1;
        $sched = $listController->getSched();
       
        $listOfClasses[0]["daySched"] = $sched["daySched"];
        $listOfClasses[0]["startingHour"] = $sched["startingHour"];
        $listOfClasses[0]["startingMin"] = $sched["startingMin"];
        $listOfClasses[0]["startTimePeriod"] = $sched["startTimePeriod"];
        $listOfClasses[0]["endingHour"] = $sched["endingHour"];
        $listOfClasses[0]["endingMin"] = $sched["endingMin"];
        $listOfClasses[0]["endTimePeriod"] = $sched["endTimePeriod"];
      
        $_SESSION["list"] = $listOfClasses;

        $className = $_SESSION['list'][0]['class_name'];
        $classProf = $_SESSION['list'][0]['class_teacher'];

        $daySched = $_SESSION['list'][0]['daySched'];
        $startingHour = $_SESSION['list'][0]['startingHour'];
        $startingMin = $_SESSION['list'][0]['startingMin'];
        $startTimePeriod = $_SESSION['list'][0]['startTimePeriod'];
        $endingHour = $_SESSION['list'][0]['endingHour'];
        $endingMin = $_SESSION['list'][0]['endingMin'];
        $endTimePeriod = $_SESSION['list'][0]['endTimePeriod'];

        // echo $classProf;

        if($this->className ==  $className && $this->classSchedule['day'] == $daySched && $this->classSchedule['startingHour'] == 
        $startingHour && $this->classSchedule['startingMin'] == $startingMin && $this->classSchedule['startTimePeriod'] == $startTimePeriod && $this->classSchedule['endingHour'] == $endingHour &&
        $this->classSchedule['endingMin'] == $endingMin && $this->classSchedule['endTimePeriod'] == $endTimePeriod && $this->status == $_SESSION["list"][0]['class_status'] && $this->classProf == $classProf){
            return true;
        }

        return false;
    }

}
 

