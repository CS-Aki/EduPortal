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
        $sql = "SELECT name, email FROM users WHERE name = ? AND email = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$name, $email]);
        
        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    protected function isUserCredentialCorrect($email, $password){
        $sql = "SELECT password from users WHERE email = ?";
        $stmt = $this->connect()->prepare($sql);

        if(!$stmt->execute(array($email))){
            header("Location: login.php?error=statementFailed");
            exit();
        }

        if($stmt->rowCount() == 0){
            $_SESSION["msg"] = "User Not Found";
            header("Location: login.php?error=userNotFound");
            exit();
        }

        $hashedPass = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPass = password_verify($password, $hashedPass[0]["password"]);

        if($checkPass == false){
            $_SESSION["msg"] = "Wrong Password";
            header("Location: login.php?error=wrongPassword");
            exit();
        }else if($checkPass == true){
            
            $sql = "SELECT * from users WHERE email = ?";
            $stmt = $this->connect()->prepare($sql);

            if(!$stmt->execute(array($email))){
                header("Location: login.php?error=statementFailed");
                exit();
            }

            if($stmt->rowCount() == 0){
                $_SESSION["msg"] = "Error";
                header("Location: login.php?error=error");
                exit();
            }

            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION["user_id"] = $user[0]["user_id"];
            $_SESSION["user_category"] = $user[0]["user_category"];
            $_SESSION["email"] = $user[0]["email"];
            $_SESSION["name"] = $user[0]["name"];
        }

    }
}
