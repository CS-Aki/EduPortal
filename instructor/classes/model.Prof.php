<?php

class Instructor extends DbConnection
{
    protected function fetchInstructorClass(){
        $sql = "SELECT class_code, class_name, users.user_id, class_teacher, class_schedule FROM `classes` INNER JOIN users ON classes.class_teacher = users.name WHERE users.user_id = ? AND class_status = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($_SESSION["user_id"], "Active"))) {
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
        $code = $this->findSimilarCode($classCode);
        // echo var_dump($code);
        $sql = "SELECT posts.post_id, posts.class_code, posts.prof_name, posts.title, posts.content_type, posts.content, posts.visibility, TIME(posts.created_at) as 'time', DATE(posts.created_at) as 'month', classes.class_name, classes.class_schedule, classes.class_teacher FROM posts INNER JOIN classes ON classes.class_code = posts.class_code WHERE posts.class_code = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($code[0]["class_code"]))) {
                if ($stmt->rowCount() == 0) {
                   return $this->fetchClassFromCode($code[0]["class_code"]);
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

    protected function findSimilarCode($classCode){
        $sql = "SELECT class_code FROM `classes` WHERE MD5(class_code) = ?";
        $stmt = $this->connect()->prepare($sql);
        // echo $classCode;
        try {
            if ($stmt->execute(array($classCode))) {
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

    protected function addPost($classCode, $type, $title, $desc, $date, $time){
        session_start();
        $newCode = $this->findSimilarCode($classCode);

        if($type != "material"){
             $sql = "INSERT INTO `posts`(`class_code`, `prof_name`, `title`, `content_type`, `content`, `visibility`) VALUES (?, ?, ?, ?, ?, ?)";
        }else{
            $sql = "INSERT INTO `posts`(`class_code`, `prof_name`, `title`, `content_type`, `content`, `visibility`) VALUES (?, ?, ?, ?, ?, ?)";
        }

        $stmt = $this->connect()->prepare($sql);

        if($type == "quiz"){
            $type = ucfirst($type);
            $stmt->execute(array($newCode[0]["class_code"], $_SESSION["name"], $title, $type, $desc, "Visible"));

            $stmt = null;

            $postID = $this->getPostId($title, $newCode[0]["class_code"]);
            $sql = "INSERT INTO `quiz`(`post_id`, `class_code`, `deadline_date`, `deadline_time`, `points`) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            if ($stmt->execute(array($postID[0]["post_id"], $newCode[0]["class_code"], $date, $time, 100))) {
                return true;
            }else{
                echo "Error statement";
                return false;
            }
          
        }else if($type == "activity"){
            $type = ucfirst($type);
            $stmt->execute(array($newCode[0]["class_code"], $_SESSION["name"], $title, $type, $desc, "Visible"));
            $postID = $this->getPostId($title, $newCode[0]["class_code"]);
            $stmt = null;
            $sql = "INSERT INTO `activity`(`post_id`, `class_code`, `deadline_date`, `deadline_time`, `points`) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            if ($stmt->execute(array($postID[0]["post_id"], $newCode[0]["class_code"], $date, $time, 100))) {
                return true;
                exit();
            }else{
                echo "Error statement";
                return false;
            }
            exit();
        }else{
            $type = ucfirst($type);
            if ($stmt->execute(array($newCode[0]["class_code"], $_SESSION["name"], $title, $type, $desc, "Visible"))) {
                return true;
            }else{
                echo "Error statement";
                return false;
            }
        }
        return false;
    }

    protected function fetchPost($classCode){
        $sql = "SELECT posts.post_id, posts.class_code, posts.prof_name, posts.title, posts.content_type, posts.content, posts.visibility, TIME(posts.created_at) as 'time', DATE(posts.created_at) as 'month', classes.class_name, classes.class_schedule FROM posts INNER JOIN classes ON classes.class_code = posts.class_code WHERE classes.class_code = ?";
        $stmt = $this->connect()->prepare($sql);

        $stmt->execute([$classCode]);

        if ($stmt->rowCount() == 0) {
            return $result = $this->fetchClassFromCode($classCode);
        }

        return $code = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function fetchPostDetails($title, $classCode){
        $sql = "SELECT posts.post_id, posts.class_code, posts.content, TIME(posts.created_at) as 'time', DATE(posts.created_at) as 'month', posts.title FROM posts WHERE MD5(posts.title) = ? AND MD5(posts.class_code) = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($title, $classCode))) {
                if ($stmt->rowCount() == 0) {
                    return $result = $this->fetchNoComment($title, $classCode);
                }
                // Add conditional statement if rowCount == 0 then call a function
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

    protected function getPost($title, $classCode){
        $sql = "SELECT posts.post_id, posts.class_code, posts.content, TIME(posts.created_at) as 'time', DATE(posts.created_at) as 'month', posts.title FROM posts WHERE posts.title = ? AND MD5(posts.class_code) = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($title, $classCode))) {
                if ($stmt->rowCount() == 0) {
                    return $result = $this->fetchNoComment($title, $classCode);
                }
                // Add conditional statement if rowCount == 0 then call a function
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

    protected function fetchNoComment($title, $classCode){
        $sql = "SELECT posts.post_id, posts.class_code, posts.content , TIME(posts.created_at) as 'time', DATE(posts.created_at) as 'month', posts.title FROM `posts` WHERE MD5(posts.title) = ? AND MD5(posts.class_code) = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($title, $classCode))) {
                // Add conditional statement if rowCount == 0 then call a function
                return $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);
                //echo var_dump($result);
                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: ";
            return null;
        }
    }

    protected function fetchComments($title, $classCode){
        $sql = "SELECT comments.post_id, comments.name, comments.comment, comments.user_id, users.image, TIME(comments.created_at) as 'time', DATE(comments.created_at) as 'month' FROM comments INNER JOIN posts ON posts.post_id = comments.post_id INNER JOIN users ON comments.user_id = users.user_id WHERE MD5(posts.title) = ? AND MD5(posts.class_code) = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($title, $classCode))) {
                if ($stmt->rowCount() == 0) {
                    return $result = null;
                }
                // Add conditional statement if rowCount == 0 then call a function
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

    protected function insertComment($title, $classCode, $comment){

        $postID = $this->getPostId($title, $classCode);
        $sql = "INSERT INTO comments (`post_id`, `class_code`, `name`, `comment`, `user_id`) VALUES(?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postID[0]["post_id"], $classCode, $_SESSION["name"], $comment, $_SESSION["id"]))) {
                // Add conditional statement if rowCount == 0 then call a function
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: ";
            return false;
        }

        return false;
    }

    protected function getPostId($title, $classCode){
        $sql = "SELECT post_id FROM posts WHERE title = ? AND class_code = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($title, $classCode))) {
                // Add conditional statement if rowCount == 0 then call a function
                return $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);
                //echo var_dump($result);
                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: ";
            return null;
        }
        return null;
    }

    protected function insertAttendance($classCode, $studentId, $date, $status){

        $newCode = $this->findSimilarCode($classCode);
        $alreadyInsert = $this->alreadyInsertedAttend($newCode[0]["class_code"], $studentId, $date);
        // echo "Code " . $newCode[0]["class_code"];\
        echo "This is {$alreadyInsert}";
        if($alreadyInsert == true){
            $sql = "UPDATE attendance SET status = ? WHERE class_code = ? AND user_id = ? AND date = ?";
            $stmt = $this->connect()->prepare($sql);

            try {
                if ($stmt->execute(array($status, $newCode[0]["class_code"], $studentId, $date))) {
                    echo "Update Success";
                } else {
                   echo "Error inserting";
                }
            } catch (PDOException $e) {
                echo "Error in insertion catch: ";
            
            }
        }else{
            $sql = "INSERT INTO attendance (`class_code`, `user_id`, `status`, `date`) VALUES(?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);

            try {
                if ($stmt->execute(array($newCode[0]["class_code"], $studentId, $status, $date))) {
                    echo "Insert Success";
                } else {
                   echo "Error inserting";
                }
            } catch (PDOException $e) {
                echo "Error in insertion catch: ";
            
            }
        }

    }

    protected function alreadyInsertedAttend($classCode, $studentId, $date){
        $sql = "SELECT * FROM attendance WHERE class_code = ? AND user_id = ? AND date = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($classCode, $studentId, $date))) {
                if ($stmt->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: ";
            return false;
        }
        return true;
    }

    protected function isSameStatus($classCode, $studentId, $date, $status){
        $newCode = $this->findSimilarCode($classCode);
        $sql = "SELECT status FROM attendance WHERE class_code = ? AND user_id = ? AND date = ? AND status = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($newCode[0]["class_code"], $studentId, $date, $status))) {
                if ($stmt->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: ";
            return false;
        }
        return true;
    }

    protected function updateProfilePicture($userId, $profile){
        $profile = "../profiles/" . $profile;
        $sql = "UPDATE users SET image = ? WHERE user_id = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($profile, $userId))) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: ";
            return false;
        }
        return false;
    }

    protected function uploadQuiz($quizTitle, $classCode, $questions, $totalPoints) {
        $realCode = $this->findSimilarCode($classCode);
        $connection = $this->connect(); // Store the connection
    
        foreach ($questions as $question) {
            $questionText = $question['question'];
            $type = $question['type'];
            $options = $question['options'];
            $ansKey = $question['ansKey'];
            $points = $question['points'];
    
            $sql = "INSERT INTO `questions`(`class_code`, `ans_key`, `points`, `question_text`, `question_type`) VALUES (?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);
    
            try {
                if ($stmt->execute(array($realCode[0]["class_code"], $ansKey, $points, $questionText, $type))) {
                    $questionId = $connection->lastInsertId(); // Use the same connection
                    foreach ($options as $option) {
                        $this->insertOptions($option, $questionId);
                    }
                } else {
                    echo "Insert failed: " . implode(", ", $stmt->errorInfo()); // Log the error
                    return false;
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage(); // Log the error
                return false;
            }
        }
        return true;
    }

    // Put data into options table
    protected function insertOptions($option, $questionId){
        $sql = "INSERT INTO `options`(`question_id`, `option_text`) VALUES (?, ?)";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($questionId, $option))) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: ";
            return false;
        }
    }

    
}
