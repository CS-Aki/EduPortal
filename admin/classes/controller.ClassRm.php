<?php

class ClassRmController extends ClassRm{
    private $classCode;
    private $className;
    private $classSchedule;
    private $classProf;

    function __construct($classCode, $className, $classSchedule, $classProf)
    {
        $this->classCode = $classCode;
        $this->className = $className;
        $this->classSchedule = $classSchedule;
        $this->classProf = $classProf;
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

        $result = $this->addNewClass($this->classCode, $this->className, $this->classSchedule, $this->classProf);

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
        if(!preg_match("/^[a-zA-Z ]*$/", $this->className)){
          return true;
        }else{
          return false;
        }

        if(!preg_match("/^[a-zA-Z ]*$/", $this->classProf)){
            return true;
        }else{
            return false;
        }

      }


}