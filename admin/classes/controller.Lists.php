<?php

class ListController extends ClassRm{
      public function getAllClass(){
          $resultArr = $this->getClasses();

          if(count($resultArr) == 0 || count($resultArr) == null){
              $_SESSION["msg"] = "Error fetching class";
              header("Location: update-class.php?error=fetchingClassInDbError");
              exit();
          }

          return $resultArr;
      }

      public function getClassFromCode(){
          $classCode = $_POST["searchClassCode"];
          $resultArr = $this->fetchClassFromCode($classCode);

          if(count($resultArr) == 0 || count($resultArr) == null){
              $_SESSION["msg"] = "Error fetching class";
              header("Location: update-class.php?error=fetchingClassInDbError");
              exit();
          }

          return $resultArr;
      }

      public function getClassFromCName(){
          $className = $_POST["searchClass"];
          $resultArr = $this->fetchClassFromCName($className);

          if(count($resultArr) == 0 || count($resultArr) == null){
              $_SESSION["msg"] = "Error fetching class";
              header("Location: update-class.php?error=fetchingClassInDbError");
              exit();
          }

          return $resultArr;
      }

      public function getClassFromIns(){
          $classIns = $_POST["searchClassIns"];
          $resultArr = $this->fetchClassFromIns($classIns);

          if(count($resultArr) == 0 || count($resultArr) == null){
              $_SESSION["msg"] = "Error fetching class";
              header("Location: update-class.php?error=fetchingClassInDbError");
              exit();
          }

          return $resultArr;
      }

}
