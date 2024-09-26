<?php 

class View {
    //Viewer will then arrange or design the presentation of data
    //Return to controller a presentable data for the user to view
    //If it receives an error signal from controller, render error then return to controller
    public function showUser($name){
        $temp = "<br>User: {$name}<br>";
        return $temp;
    }
}