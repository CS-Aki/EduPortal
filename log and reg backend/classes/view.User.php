<?php

class UserView {
    // I might delete this file since it complicates a lot of things xD might just use the php files outside the folders for viewing
    //Viewer will then arrange or design the presentation of data
    //Return to controller a presentable data for the user to view
    //If it receives an error signal from controller, render error then return to controller
    public function showRegistrationMsg($result){
        if($result == false){
            echo "Registration Failed";
        }else{
          //  echo "Registration success";
        }
    }

    // Display error messages from error handler
    // We can change the display on how to render the error in this function, for now im just echoing it
    public function showRegistrationErrorMsg($result){
        return "<div class='form-group'><label>{$result}</label></div>";
    }
   
}
