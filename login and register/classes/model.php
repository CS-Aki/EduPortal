<?php 

class User extends DbConnection{
    // Function will take request from controller then interact with db 
    // Return the result back to controller
    protected function getUser(){
        return "Sir Vic";
    }
}