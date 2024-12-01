<?php

class Instructor extends DbConnection
{
    protected function fetchInstructorClass(){
        $sql = "SELECT class_code, class_name, users.user_id, class_teacher, class_schedule FROM `classes` INNER JOIN users ON classes.class_teacher = users.name WHERE users.user_id = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($_SESSION["user_id"]))) {
                return $classList = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    protected function fetchAllInstructor()
    {
        $sql = "SELECT user_id, name, email FROM users WHERE user_category = 3";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute()) {
                return $instList = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    protected function findInstructor($profName)
    {
        $sql = "SELECT user_id, name, email FROM users WHERE user_category = 3 AND name = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute([$profName])) {
                return $instList = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    protected function fetchAllProfClass($profName)
    {
        $sql = "SELECT class_teacher, class_code, class_name, class_schedule FROM classes WHERE class_teacher = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute([$profName])) {
                return $classList = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    } 

    protected function fetchClassDetails($classCode){
    
        $sql = "SELECT posts.post_id, posts.class_code, posts.prof_name, posts.title, posts.content_type, posts.content, posts.visibility, TIME(posts.created_at) as 'time', DATE(posts.created_at) as 'month', classes.class_name, classes.class_schedule FROM posts INNER JOIN classes ON classes.class_code = posts.class_code WHERE posts.class_code = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($classCode))) {
                if ($stmt->rowCount() == 0) {
                   return $this->fetchClassFromCode($classCode);
                }
                $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);
                //echo var_dump($result);
                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    protected function findClassCode(){
        $sql = "SELECT md5(class_code) FROM posts";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute()) {
                $codes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($codes as $code){
                    foreach($code as $c){
                        echo $c . " " . $_GET["class"] . "<br>";
                    }
                }
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    protected function fetchClassFromCode($classCode)
    {
        $sql = "SELECT class_num, class_code, class_name, class_teacher, class_schedule, class_status from classes WHERE class_code = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$classCode]);

        return $class = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function sendPostToDb($classCode, $profName, $title, $desc, $type){
        $sql = "INSERT INTO `posts`(`class_code`, `prof_name`, `title`, `content_type`, `content`, `visibility`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($classCode, $profName, $title, $type, $desc, "Visible"))) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    protected function fetchSession(){
        if (session_id() === "") session_start();
        $sql = "SELECT session_id from users WHERE email = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$_SESSION["google_email"]]);
        

        return $class = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function visibilityEdit($id, $status){
        $sql = "UPDATE posts SET visibility = ? WHERE post_id = ?";
        $stmt = $this->connect()->prepare($sql);
     
        try {
            if ($stmt->execute(array($status, $id))) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

}
