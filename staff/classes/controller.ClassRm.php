<?php

class ClassRmController extends ClassRm
{
    private $classCode;
    private $className;
    private $classSchedule;
    private $classProf;
    private $status;
    private $tempClassName;
    private $userId;

    function __construct($classCode, $className, $classSchedule, $classProf, $status, $tempClassName, $userId)
    {
        $this->classCode = $classCode;
        $this->className = $className;
        $this->classSchedule = $classSchedule;
        $this->classProf = $classProf;
        $this->status = $status;
        $this->tempClassName = $tempClassName;
        $this->userId = $userId;
        //   if(session_id() === "") session_start();
        if (isset($_SESSION["msg"])) unset($_SESSION["msg"]);

        // echo $this->classProf;
    }

    public function addClass()
    {
    
        while ($this->isClassCodeExist($this->classCode) == true) {
            $this->classCode = $this->generateClassCode();
        }

        if ($this->isEmpty() == true) {
            echo "Please fill out all the necessary information";
            // $_SESSION["msg"] = "Please fill out all the necessary information";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidInput");
            // header("Location: admin-dashboard.php?adminBtn=Add Class");
            return;
        }

        if ($this->invalidInput() == true) {
            echo "Special Characters aren't allowed, please try again";
            // $_SESSION["msg"] = "Special Characters aren't allowed, please try again";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidCharacterInput");
            // header("Location: admin-dashboard.php?adminBtn=Add Class");
            return;
        }

        if ($this->isClassNameExist($this->className) == true) {
            echo "Class already exist";
            // $_SESSION["msg"] = "Class already exist";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=classAlreadyExist");
            // header("Location: admin-dashboard.php?adminBtn=Add Class");
            return;
        }

        if ($this->isEmptySched() == true) {
            echo "Invalid Schedule Input";
            // $_SESSION["msg"] = "Invalid Schedule Input";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidScheduleInput");   
            // header("Location: admin-dashboard.php?adminBtn=Add Class");
            return;
        }

        if ($this->isEmptyStatus() == true) {
            echo "Choose a status";
            // $_SESSION["msg"] = "Choose a status";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidStatusOption");       
            // header("Location: admin-dashboard.php?adminBtn=Add Class");
            return;
        }

        if ($this->invalidScheduleDate() == true) {
            echo "Invalid Schedule Date";
            // $_SESSION["msg"] = "Invalid Schedule Date";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidScheduleDate"); 
            // header("Location: admin-dashboard.php?adminBtn=Add Class");
            return;
        }

        // Add validator to compare to and from schedule, value should be greater than the TO schedule
        $fullSched = "(" . $this->classSchedule["day"] . ") " . $this->classSchedule["startingHour"] . ":" . $this->classSchedule["startingMin"] . " " . $this->classSchedule["startTimePeriod"] . "-" . $this->classSchedule["endingHour"] . ":" . $this->classSchedule["endingMin"] . " " . $this->classSchedule["endTimePeriod"];

        $result = $this->addNewClass($this->classCode, $this->className, $fullSched, $this->classProf, $this->status, $this->userId);

        if ($result == true) {
            echo "New Class Successfully Added";
            // $_SESSION["msg"] = "New Class Successfully Added";
        } else {
            echo "Failed to Add New Class";
            // $_SESSION["msg"] = "Failed to Add New Class";
        }
    }

    public function editClass()
    {
      
        // if($this->noChanges() == true){
        //     $_SESSION["msg"] = "No Changes";
        //     // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidInput");
        //     header("Location: admin-dashboard.php?adminBtn=Update Class");
        //     exit();
        // }

        if ($this->isEmpty() == true) {
            echo "Please fill out all the necessary information";
            $_SESSION["msg"] = "Please fill out all the necessary information";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidInput");
            // header("Location: admin/classes.php");
            return;
        }

        if ($this->invalidInput() == true) {
            echo "Special Characters aren't allowed, please try again";
            $_SESSION["msg"] = "Special Characters aren't allowed, please try again";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidCharacterInput");
            // header("Location: admin/classes.php");
            return;
        }

        if ($this->tempClassName != $this->className) {
            if ($this->isClassNameExist($this->className) == true) {
                echo "Class already exist";
                $_SESSION["msg"] = "Class already exist";
                // header("Location: admin-dashboard.php?adminBtn=Add Class error=classAlreadyExist");
                // header("Location: admin/classes.php");
                return;
            }
        }

        if ($this->isEmptySched() == true) {
            echo "Invalid Schedule Input";
            $_SESSION["msg"] = "Invalid Schedule Input";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidScheduleInput");   
            // header("Location: admin/classes.php");
            return;
        }

        if ($this->isEmptyStatus() == true) {
            $_SESSION["msg"] = "Choose a status";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidStatusOption");       
            header("Location: admin/classes.php");
            exit();
        }

        if ($this->invalidScheduleDate() == true) {
            echo "Invalid Schedule Date";
            $_SESSION["msg"] = "Invalid Schedule Date";
            // header("Location: admin-dashboard.php?adminBtn=Add Class error=invalidScheduleDate"); 
            // header("Location: admin/classes.php");
            return;
        }
        // echo $this->className . "<br>" . $this->status;
        $fullSched = "(" . $this->classSchedule["day"] . ") " . $this->classSchedule["startingHour"] . ":" . $this->classSchedule["startingMin"] . " " . $this->classSchedule["startTimePeriod"] . "-" . $this->classSchedule["endingHour"] . ":" . $this->classSchedule["endingMin"] . " " . $this->classSchedule["endTimePeriod"];

        $result = $this->editClassInfo($this->classCode, $this->className, $fullSched, $this->classProf, $this->status, $this->userId);
        if ($result == true) {
            echo "Edit Successfully";
            $_SESSION["msg"] = "Edit Successfully";
            // header("Location: admin/classes.php");
            return;
        } else {
            echo "Edit Failed";
            $_SESSION["msg"] = "Edit Failed";
            // header("Location: admin/classes.php");
            return;
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
        if (!preg_match("/^[a-zA-Z ]*$/", $this->classProf)) {
            return true;
        }

        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $this->className)) {
            return true;
        }

        return false;
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

    // private function noChanges(){
    //     $_POST["class_code"] = $this->classCode;
    //     $listController = new ListController();
    //     $listOfClasses = $listController->getClassFromCode();
    //     $_SESSION["list"] = $listOfClasses;
    //   //  echo $listOfClasses[0]["class_num"];
    //     //$_SESSION['classNumber'] = 1;
    //     // $sched = $listController->getSched();
       
    //     $listOfClasses[0]["daySched"] = $sched["daySched"];
    //     $listOfClasses[0]["startingHour"] = $sched["startingHour"];
    //     $listOfClasses[0]["startingMin"] = $sched["startingMin"];
    //     $listOfClasses[0]["startTimePeriod"] = $sched["startTimePeriod"];
    //     $listOfClasses[0]["endingHour"] = $sched["endingHour"];
    //     $listOfClasses[0]["endingMin"] = $sched["endingMin"];
    //     $listOfClasses[0]["endTimePeriod"] = $sched["endTimePeriod"];
      
    //     $_SESSION["list"] = $listOfClasses;

    //     $className = $_SESSION['list'][0]['class_name'];
    //     $classProf = $_SESSION['list'][0]['class_teacher'];

    //     $daySched = $_SESSION['list'][0]['daySched'];
    //     $startingHour = $_SESSION['list'][0]['startingHour'];
    //     $startingMin = $_SESSION['list'][0]['startingMin'];
    //     $startTimePeriod = $_SESSION['list'][0]['startTimePeriod'];
    //     $endingHour = $_SESSION['list'][0]['endingHour'];
    //     $endingMin = $_SESSION['list'][0]['endingMin'];
    //     $endTimePeriod = $_SESSION['list'][0]['endTimePeriod'];

    //     // echo $classProf;

    //     if($this->className ==  $className && $this->classSchedule['day'] == $daySched && $this->classSchedule['startingHour'] == 
    //     $startingHour && $this->classSchedule['startingMin'] == $startingMin && $this->classSchedule['startTimePeriod'] == $startTimePeriod && $this->classSchedule['endingHour'] == $endingHour &&
    //     $this->classSchedule['endingMin'] == $endingMin && $this->classSchedule['endTimePeriod'] == $endTimePeriod && $this->status == $_SESSION["list"][0]['class_status'] && $this->classProf == $classProf){
    //         return true;
    //     }

    //     return false;
    // }

    function generateClassCode()
    {
        $alphabet = "abcdefghijklmnopqrstuvwxyz0123456789";
        $classCodeHolder = "";
        for ($i = 1; $i <= 8; $i++) {
            $randomCaps = rand(1, 100);
            $randomize = rand(0, strlen($alphabet) - 1);

            if (!is_numeric($alphabet[$randomize])) {
                if ($randomCaps >= 50) {
                    $classCodeHolder .= strtoupper($alphabet[$randomize]);
                    continue;
                }
            }
            $classCodeHolder .= $alphabet[$randomize];
        }

        return $classCodeHolder;
    }

}
 

