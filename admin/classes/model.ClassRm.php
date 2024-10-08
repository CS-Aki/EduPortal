<?php

class ClassRm extends DbConnection{

    protected function addNewClass($classCode, $className, $classSchedule, $classProf, $status){
        $sql = "INSERT INTO classes (`class_code`, `class_name`, `class_teacher`, `class_schedule`, `class_status`) VALUES (?, ? ,?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);

        if($stmt->execute(array($classCode, $className, $classProf, $classSchedule, $status))){
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

    protected function getClasses(){
      $sql = "SELECT class_code, class_name, class_teacher, class_schedule, class_status from classes WHERE class_num >= ? AND class_num <= ?";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$_SESSION["min"], $_SESSION["max"]]);

      return $listOfClass = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function fetchClassFromCode($classCode){
      $sql = "SELECT class_code, class_name, class_teacher, class_schedule, class_status from classes WHERE class_code = ?";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$classCode]);

      return $class = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function fetchClassFromCName($className){
      $sql = "SELECT class_code, class_name, class_teacher, class_schedule, class_status from classes WHERE class_name = ?";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$className]);

      return $class = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function fetchClassFromIns($classIns){
      $sql = "SELECT class_code, class_name, class_teacher, class_schedule, class_status from classes WHERE class_teacher = ?";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$classIns]);

      return $class = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
