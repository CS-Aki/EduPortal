<?php

class ClassRm extends DbConnection{

    protected function addNewClass($classCode, $className, $classSchedule, $classProf){
        $sql = "INSERT INTO classes (`class_code`, `class_name`, `class_teacher`, `class_schedule`) VALUES (?, ? ,?, ?)";
        $stmt = $this->connect()->prepare($sql);

        if($stmt->execute(array($classCode, $className, $classProf, $classSchedule))){
            return true;
        }else{
            return false;
        }
    }

    protected function isClassNameExist($clasName){
        $sql = "SELECT class_name from classes WHERE class_name = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$clasName]);

        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    protected function isClassCodeExist($classCode){
        $sql = "SELECT class_code from classes WHERE class_code = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$classCode]);

        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

}
