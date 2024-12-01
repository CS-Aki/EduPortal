<?php

class User extends DbConnection
{
    // Function will take request from controller then interact with db
    // Return the result back to controller

    protected function insertUser($name, $email, $password)
    {
        $sql = "INSERT INTO users (`user_category`, `name`, `email`, `password`, `image`) VALUES (?, ? ,?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);

        if ($stmt->execute(array(4, $name, $email, $password, "../profiles/profile.png"))) {
            return true;
        } else {
            return false;
        }
    }

    protected function isUserRegistered($name, $email)
    {
        $sql = "SELECT name, email FROM users WHERE email = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function fetchAddress($name, $email){
        $sql = "SELECT address FROM users WHERE email = ?";
        $stmt = $this->connect()->prepare($sql);

        if ($stmt->execute(array($email))) {
            $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);
            // for($i = 0; $i < count($result); $i++){
            //        $result[$i]["status"] = "Pending";
            // }
            return $result;
       }
        // $stmt->execute(array($email));
        // $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // if ($stmt->rowCount() > 0) {
        //     $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // } else {
        //     return null;
        // }
    }

    protected function isUserCredentialCorrect($email, $password)
    {
        $sql = "SELECT password from users WHERE email = ?";
        $stmt = $this->connect()->prepare($sql);

        if (!$stmt->execute(array($email))) {
            // header("Location: index.php?error=statementFailed");
            echo "<div class='alert alert-danger' role='alert'>";
            echo "<span>Statement Failed</span>";
            echo "</div>";
            exit();
        }

        if ($stmt->rowCount() == 0) {
            echo "<div class='alert alert-danger' role='alert'>";
            echo "<span>User Not Found!</span>";
            echo "</div>";
            // header("Location: index.php?error=userNotFound");
            exit();
        }

        $hashedPass = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPass = password_verify($password, $hashedPass[0]["password"]);

        if ($checkPass == false) {
            echo "<div class='alert alert-danger' role='alert'>";
            echo "<span>Wrong Password!</span>";
            echo "</div>";
            // $_SESSION["signIn"] = "true";
            // header("Location: index.php?error=wrongPassword");
            exit();
        } else if ($checkPass == true) {

            $sql = "SELECT * from users WHERE email = ?";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute(array($email))) {
                echo "<div class='alert alert-danger' role='alert'>";
                echo "<span>Statement Failed!</span>";
                echo "</div>";
                exit();
            }

            if ($stmt->rowCount() == 0) {
                echo "<div class='alert alert-danger' role='alert'>";
                echo "<span>Error!</span>";
                echo "</div>";
                exit();
            }

            return $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    protected function getUserId($email, $name)
    {
        $sql = "SELECT user_id FROM users WHERE email = ? AND name = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(array($email, $name));
        $listOfClass = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $listOfClass;
    }

    protected function getUserCategory($email, $name)
    {
        $sql = "SELECT user_category FROM users WHERE email = ? AND name = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(array($email, $name));
        $listOfClass = $stmt->fetchAll(PDO::FETCH_ASSOC);


        return $listOfClass;
    }

    // protected function insertSession($email, $session){
    //     $sql = "UPDATE users SET session_id = ? WHERE email = ?";
    //     $stmt = $this->connect()->prepare($sql);
    //     $stmt->execute(array($session, $email));
    // }
}
