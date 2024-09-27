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
        $sql = "INSERT INTO users (`user_category`, `name`, `email`, `password`) VALUES (?, ? ,?, ?)";
        $stmt = $this->connect()->prepare($sql);
        
        if($stmt->execute(array("Student", $name, $email, $password))){
            return true;
        }else{        
            return false;
        }
    }

    protected function isUserRegistered($name, $email){
        // echo "test";
        $sql = "SELECT name, email FROM users WHERE name = ? AND email = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$name, $email]);
        // if(!$stmt->execute(array($name, $email))){
        //     echo "User not found";
        //     exit();
        // }
        
        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }

    }
}
