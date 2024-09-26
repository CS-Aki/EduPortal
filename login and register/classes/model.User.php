<?php

class User extends DbConnection{
    // Function will take request from controller then interact with db
    // Return the result back to controller
    protected function getUser(){
        $sql = "SELECT * FROM users";
        $stmt = $this->connect()->prepare($sql);
        return "Sir Victor";
    }

    protected function insertUser($name, $email, $password){
      
    }
}
