<?php
// Not sure if I'd keep this but we'll see
class AdminController {
    private ClassRmController $controller;

    function __construct($controller){
        $this->controller = $controller;
    }
    
    public function callAddClass(){
        $this->controller->addClass();
    }

    private function isEmptyInput(){
        if(empty($classCode) || empty($className) || empty($classSchedule) || empty($classProf)){
          return true;
        }else{
          return false;
        }
     }
 
    //  private function invalidName(){
    //    if(!preg_match("/^[a-zA-Z ]*$/", $this->name)){
    //      return true;
    //    }else{
    //      return false;
    //    }
    //  }
 
    //  private function invalidEmail(){
    //    if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
    //      return true;
    //    }else{
    //      return false;
    //    }
    //  }


}