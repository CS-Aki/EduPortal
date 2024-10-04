<?php

class ClassRmController extends ClassRm{
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
        if(session_id() === "") session_start();
    }

    public function addClass(){
        if($this->isEmpty() == true){
            $_SESSION["msg"] = "Please fill out all the necessary information";
            header("Location: add-class.php?error=emptyInput");
            exit();
        }

        if($this->invalidInput() == true){
            $_SESSION["msg"] = "Special Characters aren't allowed, please try again";
            header("Location: add-class.php?error=invalidCharacterInput");
            exit();
        }

        while($this->isClassCodeExist($this->classCode) == true){
            $this->classCode = generateClassCode();
        }

        if($this->isClassNameExist($this->className) == true){
            $_SESSION["msg"] = "Class already exist";
            header("Location: add-class.php?error=classAlreadyExist");
            exit();
        }

        if($this->isEmptySched() == true){
            $_SESSION["msg"] = "Invalid Schedule Input";
            header("Location: add-class.php?error=invalidScheduleInput");
            exit();
        }

        if($this->isEmptyStatus() == true){
            $_SESSION["msg"] = "Choose a status";
            header("Location: add-class.php?error=invalidStatusOption");
            exit();
        }
        
        // Add validator to compare to and from schedule, value should be greater than the TO schedule
        $fullSched = "(" . $this->classSchedule["day"] . ") " . $this->classSchedule["startingHour"] . ":" . $this->classSchedule["startingMin"] . " " . $this->classSchedule["startTimePeriod"] . "-" . $this->classSchedule["endingHour"] . ":" . $this->classSchedule["endingMin"] . " " . $this->classSchedule["endTimePeriod"];

        $result = $this->addNewClass($this->classCode, $this->className, $fullSched, $this->classProf, $this->status);

        if($result == true){
            $_SESSION["msg"] = "New Class Successfully Added";
        }else{
            $_SESSION["msg"] = "Failed to Add New Class";
        }
    }

    private function generateClassCode(){
        $alphabet = "abcdefghijklmnopqrstuvwxyz0123456789";
        $classCodeHolder = "";
        for($i = 1; $i <= 8; $i++){
          $randomCaps = rand(1, 100);
          $randomize = rand(0, strlen($alphabet) - 1);

          if(!is_numeric($alphabet[$randomize])){
              if($randomCaps >= 50){
                  $classCodeHolder .= strtoupper($alphabet[$randomize]);
                  continue;
              }
          }
          $classCodeHolder .= $alphabet[$randomize];
        }

        return $classCodeHolder;
    }

    private function isEmpty(){
        if(empty($this->classCode) || empty($this->className) || empty($this->classSchedule) || empty($this->classProf)){
            return true;
        }else{
            return false;
        }
    }

    private function invalidInput(){
        if(!preg_match("/^[a-zA-Z0-9 ]*$/", $this->className) || !preg_match("/^[a-zA-Z0-9 .]*$/", $this->classProf)){
          return true;
        }else{
          return false;
        }
    }

    private function isEmptySched(){
        foreach($this->classSchedule as $key => $value){
            if($value == "blank"){
                return true;
            }
        }
        return false;
    }

    private function isEmptyStatus(){
        if($this->status == "blank"){
            return true;
        }

        return false;
    }
}
