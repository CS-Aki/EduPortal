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

    protected function addPost($classCode, $type, $title, $desc, $endDate, $endTime, $startingDate, $startingTime, $points, $attempt){
        // echo "\n\nTHIS IS THE ATTEMPT " . $attempt . "\n\n";
        $newCode = $this->findSimilarCode($classCode);
        $connection = $this->connect();

        if($type != "material"){
             $sql = "INSERT INTO `posts`(`class_code`, `prof_name`, `title`, `content_type`, `content`, `visibility`) VALUES (?, ?, ?, ?, ?, ?)";
        }else{
            $sql = "INSERT INTO `posts`(`class_code`, `prof_name`, `title`, `content_type`, `content`, `visibility`) VALUES (?, ?, ?, ?, ?, ?)";
        }

        $stmt = $connection->prepare($sql);
       
        if($type == "quiz"){
            $type = ucfirst($type);
            $stmt->execute(array($newCode[0]["class_code"], $_SESSION["name"], $title, $type, $desc, "Visible"));
            $_SESSION["postId"] = $connection->lastInsertId();

            $postID = $this->getPostId($title, $newCode[0]["class_code"]);
           
            $sql = "INSERT INTO `quiz`(`post_id`, `class_code`, `deadline_date`, `deadline_time`, `attempt`, `starting_date`, `starting_time`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);
            if ($stmt->execute(array($_SESSION["postId"], $newCode[0]["class_code"], $endDate, $endTime, $attempt, $startingDate, $startingTime, "Pending"))) {
                // echo "trueee";
                return true;
            }else{
                echo "Error statement";
                return false;
            }
          
        }else if($type == "activity"){
            $type = ucfirst($type);
            $stmt->execute(array($newCode[0]["class_code"], $_SESSION["name"], $title, $type, $desc, "Visible"));
            $postID = $this->getPostId($title, $newCode[0]["class_code"]);
            $_SESSION["postId"] = $connection->lastInsertId();

            $stmt = null;
            $sql = "INSERT INTO `activity`(`post_id`, `class_code`, `deadline_date`, `deadline_time`, `points`, `status`, `starting_date`, `starting_time`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);
            
            if ($stmt->execute(array($_SESSION["postId"], $newCode[0]["class_code"], $endDate, $endTime, $points, "Pending", $startingDate, $startingTime))) {
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
                $postID = $this->getPostId($title, $newCode[0]["class_code"]);
                $_SESSION["postId"] = $connection->lastInsertId();
                
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

    protected function fetchPostDetails($postID, $classCode){
        // echo $title;
        $sql = "SELECT posts.post_id, posts.class_code, posts.content, TIME(posts.created_at) as 'time', DATE(posts.created_at) as 'month', posts.title, posts.content_type FROM posts WHERE MD5(posts.post_id) = ? AND MD5(posts.class_code) = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postID, $classCode))) {
                if ($stmt->rowCount() == 0) {
                    return $result = $this->fetchNoComment($postID, $classCode);
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

    protected function getPostViaId($postId, $classCode){
        $sql = "SELECT posts.post_id, posts.class_code, posts.content, TIME(posts.created_at) as 'time', DATE(posts.created_at) as 'month', posts.title FROM posts WHERE posts.post_id = ? AND MD5(posts.class_code) = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $classCode))) {
                if ($stmt->rowCount() == 0) {
                    return $result = $this->fetchNoComment($postId, $classCode);
                }
                // Add conditional statement if rowCount == 0 then call a function
                $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);
                //echo var_dump($result);
                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error post via id: " . $e->getMessage();
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

    protected function fetchComments($postId, $classCode){
        $sql = "SELECT comments.post_id, comments.name, comments.comment, comments.user_id, users.image, TIME(comments.created_at) as 'time', DATE(comments.created_at) as 'month' FROM comments INNER JOIN posts ON posts.post_id = comments.post_id INNER JOIN users ON comments.user_id = users.user_id WHERE MD5(posts.post_id) = ? AND MD5(posts.class_code) = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $classCode))) {
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

    protected function getFIlesInDb($postId, $classCode){
        $sql = "SELECT file_id, file_name, google_drive_file_id, file_size FROM files WHERE MD5(post_id) = ? AND MD5(class_code) = ? AND user_category = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $classCode, 3))) {
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

    protected function getIndivFIlesInDb($postId, $classCode, $userId){
        // echo $postId . "<br>";
        // echo $classCode;
        $sql = "SELECT file_id, file_name, google_drive_file_id, file_size, created FROM files WHERE MD5(post_id) = ? AND MD5(class_code) = ? AND user_id = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $classCode, $userId))) {
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

    protected function insertComment($postId, $classCode, $comment){
        $postID = $this->decryptPostId($postId, $classCode);
        $sql = "INSERT INTO comments (`post_id`, `class_code`, `name`, `comment`, `user_id`) VALUES(?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $classCode, $_SESSION["name"], $comment, $_SESSION["id"]))) {
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

    protected function decryptPostId($postId, $classCode){
        $sql = "SELECT post_id FROM posts WHERE MD5(post_id) = ? AND class_code = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $classCode))) {
                // Add conditional statement if rowCount == 0 then call a function
                return $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo var_dump($result);
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

    protected function decryptPostId1($postId, $classCode){
        $sql = "SELECT post_id FROM posts WHERE MD5(post_id) = ? AND MD5(class_code) = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $classCode))) {
                // Add conditional statement if rowCount == 0 then call a function
                return $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo var_dump($result);
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

    protected function getPostId($postId, $classCode){
        $sql = "SELECT post_id FROM posts WHERE MD5(post_id) = ? AND class_code = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $classCode))) {
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

    protected function fetchQuizDetails($postId, $classCode){
        $sql = "SELECT questions.question_id, questions.question_type, questions.question_text, questions.points, options.option_text, posts.title, questions.ans_key FROM quiz LEFT JOIN questions ON quiz.post_id = questions.post_id LEFT JOIN options ON options.question_id = questions.question_id LEFT JOIN posts ON posts.post_id = quiz.post_id WHERE md5(quiz.post_id) = ? AND md5(quiz.class_code) = ? ORDER BY questions.question_id";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $classCode))) {
                if ($stmt->rowCount() == 0) {
                    return null;
                }
                $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error fetchQuizDetails: " . $e;
            return null;
        }
    }

    protected function removeChoicesInDb($removedChoices){
        foreach ($removedChoices as $question) {
            $id = $question["existingId"];
            $choice = $question["choice"];
            $answerKey = $question["answerKey"];

            if($choice == $answerKey){
                $this->updateAnswerKey($answerKey, $id);
            }

            $sql = "DELETE FROM options WHERE MD5(question_id) = ? AND option_text = ?";
            $stmt = $this->connect()->prepare($sql);
    
            try {
                if ($stmt->execute(array($id, $choice))) {
                    echo "Remove choice successfull";
                } else {
                    echo "FAILED REMOVING CHOICE";
                }
            } catch (PDOException $e) {
                echo "Error: removeChoicesInDb " . $e;
                return false;
            }

        }
    }

    protected function addChoicesFromDb($removedChoices){
        // foreach ($removedChoices as $question) {
        //     $id = $question["existingId"];
        //     $choice = $question["choice"];
        //     $answerKey = $question["answerKey"];

        //     if($choice == $answerKey){
        //         $this->updateAnswerKey($answerKey, $id);
        //     }

        //     $sql = "DELETE FROM options WHERE MD5(question_id) = ? AND option_text = ?";
        //     $stmt = $this->connect()->prepare($sql);
    
        //     try {
        //         if ($stmt->execute(array($id, $choice))) {
        //             echo "Remove choice successfull";
        //         } else {
        //             echo "FAILED REMOVING CHOICE";
        //         }
        //     } catch (PDOException $e) {
        //         echo "Error: removeChoicesInDb " . $e;
        //         return false;
        //     }

        // }
    }

    protected function uploadQuiz($classCode, $questions, $totalPoints, $postId, $removedElements, $removedChoices) {
        $realCode = $this->findSimilarCode($classCode);
        $connection = $this->connect(); // Store the connection
        $newPostId = $this->decryptPostId1($postId, $classCode);
        // echo var_dump($newPostId);

        if($removedElements != null){
            $this->removingElementsInDb($newPostId[0]["post_id"], $removedElements, -1);
        }

        if($removedChoices != null){
            $this->removeChoicesInDb($removedChoices);
        }

        foreach ($questions as $question) {
            $questionText = $question['question'];
            $type = $question['type'];
            $options = $question['options'];
            $ansKey = $question['ansKey'];
            $points = $question['points'];
            $questionId = $this->decryptQuestionId($newPostId[0]["post_id"], $question['existingId']);

            // echo $questionId[0]["question_id"];
            // echo "THIS IS THE QUESTION ID " . $questionId;
            // echo $questionText . "\n";
            // echo $type . "\n";
            // echo $questionText . "\n";
            // echo $questionText . "\n";
            $this->updateQuizStatus($realCode[0]["class_code"], $newPostId[0]["post_id"]);

            $qTextResult = $this->isQuestionTextInDb($questionText, $realCode[0]["class_code"], $newPostId[0]["post_id"]);
            if($qTextResult == true){
                echo "\nQuestion Text Already in database\n";
                echo "\nUpdating Question In Database\n";

                // if($type != "short-text") $this->removingElementsInDb($newPostId[0]["post_id"], $options, $questionId[0]["question_id"]);
                if($type != "short-text") $this->insertOptions($options, $questionId[0]["question_id"]);
                // echo var_dump($options);

                $sql = "UPDATE `questions` SET `question_text`= ?, `question_type` = ?, `ans_key`= ?, `points` = ? WHERE question_id = ? AND post_id = ?";
                $stmt = $connection->prepare($sql);
                try {
                    if ($stmt->execute(array($questionText, $type, $ansKey, $points, $questionId[0]["question_id"] ,$newPostId[0]["post_id"]))) {
                        if ($stmt->rowCount() > 0) {
                            echo "update success";
                        }
                    } else {
                        echo "update failed: " . implode(", ", $stmt->errorInfo()); // Log the error
                        return false;
                    }
                } catch (PDOException $e) {
                    echo "Error inside else statement of questionId == null: " . $e->getMessage(); // Log the error
                    return false;
                }
            }else{
                // Not yet existing in database
                if($questionId == null){
                    echo "\nQuestion Text Not Yet In Database\n";
                    $sql = "INSERT INTO `questions`(`class_code`, `ans_key`, `points`, `question_text`, `question_type`, `post_id`) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $connection->prepare($sql);
            
                    try {
                        if ($stmt->execute(array($realCode[0]["class_code"], $ansKey, $points, $questionText, $type, $newPostId[0]["post_id"]))) {
                            $questionId = $connection->lastInsertId(); // Use the same connection
                            // foreach ($options as $option) {
                                $this->insertOptions($options, $questionId);
                            // }
                        } else {
                            echo "Insert failed: " . implode(", ", $stmt->errorInfo()); // Log the error
                            return false;
                        }
                    } catch (PDOException $e) {
                        echo "Error inside questionId == null: " . $e->getMessage(); // Log the error
                        return false;
                    }
                }
                 // Exist in our db just need to update value
                else{
                    echo "\nUpdating Question In Database\n";
                    $sql = "UPDATE `questions` SET `question_text`= ?, `question_type` = ?, `ans_key`= ?, `points` = ? WHERE question_id = ? AND post_id = ?";
                    $stmt = $connection->prepare($sql);
                    try {
                        if ($stmt->execute(array($questionText, $type, $ansKey, $points, $questionId[0]["question_id"] ,$newPostId[0]["post_id"]))) {
                            if ($stmt->rowCount() > 0) {
                                echo "update success";
                            }
                        } else {
                            echo "update failed: " . implode(", ", $stmt->errorInfo()); // Log the error
                            return false;
                        }
                    } catch (PDOException $e) {
                        echo "Error inside else statement of questionId == null: " . $e->getMessage(); // Log the error
                        return false;
                    }
                }

            }
        }
        return true;
    }

    protected function updateQuizStatus($classCode, $postId){
        echo $classCode;
        echo "POST ID " . $postId;
        echo "\n\nINSIDE UPDATING QUIZ\n";
        $sql = "UPDATE quiz SET status = ? WHERE class_code = ? AND post_id = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array("Active", $classCode, $postId))) {
                if ($stmt->rowCount() > 0) {
                    echo "STATUS UPDATED SUCCESS\n\n";
                    return true;
                }
                echo "STATUS UPDATED Failed\n\n";
                return false;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error in updateQuizStatus : ";
            return null;
        }
    }

    protected function removingElementsInDb($postId, $removedElements, $id){
        foreach ($removedElements as $question) {
            $removeAllQuestion = $question["removeQuestion"];
            $questionText = $question['question'];
            $type = $question['type'];
            $options = $question['options'];
            $ansKey = $question['ansKey'];
            $points = $question['points'];
            if($removeAllQuestion == 0){
                // echo "POST ID IN DELETE " .$postId;
                $questionId = $this->decryptQuestionId($postId, $question['existingId']);
                // echo "Existing ID : " . $question['existingId'] . "\n";
                echo "\NDeleting Question In Database\n";
                $sql = "DELETE FROM options WHERE question_id = ?";
                $stmt = $this->connect()->prepare($sql);
                try {
                    if ($stmt->execute(array($questionId[0]["question_id"]))) {
                        if ($stmt->rowCount() > 0) {
                            echo "\ndeletion success\n";
                        }
                    } else {
                        echo "update failed: " . implode(", ", $stmt->errorInfo()); // Log the error
                        return false;
                    }
                } catch (PDOException $e) {
                    echo "Error inside else statement of questionId == null: " . $e->getMessage(); // Log the error
                    return false;
                }
            }else{
                // echo "POST ID IN DELETE " .$postId;
                $questionId = $this->decryptQuestionId($postId, $question['existingId']);
                // echo "Existing ID : " . $question['existingId'] . "\n";
                echo "\NDeleting Question In Database\n";
                $sql = "DELETE FROM questions WHERE question_id = ?";
                $stmt = $this->connect()->prepare($sql);
                try {
                    if ($stmt->execute(array($questionId[0]["question_id"]))) {
                        if ($stmt->rowCount() > 0) {
                            echo "\ndeletion success\n";
                        }
                    } else {
                        echo "update failed: " . implode(", ", $stmt->errorInfo()); // Log the error
                        return false;
                    }
                } catch (PDOException $e) {
                    echo "Error inside else statement of questionId == null: " . $e->getMessage(); // Log the error
                    return false;
                }
            }
        }
    
    }

    protected function isQuestionTextInDb($questionText, $classCode, $postId){
        $sql = "SELECT question_text FROM questions WHERE question_text = ? AND class_code = ? AND post_id = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($questionText, $classCode, $postId))) {
                if ($stmt->rowCount() > 0) {
                    return true;
                }else{
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: isQuestionTextInDb";
            return false;
        }
    }

    protected function decryptQuestionId($postId, $questionId){
        $sql = "SELECT question_id FROM questions WHERE post_id = ? AND MD5(question_id) = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $questionId))) {
                if ($stmt->rowCount() > 0) {
                    return $instList = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }else{
                    return null;
                }
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error in decryptQuestionId : ";
            return null;
        }
    }

    // Put data into options table
    protected function insertOptions($options, $questionId){
        foreach ($options as $option) {
            echo $questionId;
            echo "This is the option " . $option . "\n\n";
            $sql = "SELECT * FROM `options` WHERE `option_text` = ? AND `question_id` = ?";
            $stmt = $this->connect()->prepare($sql);
            try {
                if ($stmt->execute(array($option ,$questionId))) {
                    if ($stmt->rowCount() > 0) {
                        echo "No new option";
                    }else{
                        echo "INSERTION NEW OPTIONS\n";
                        $sql = "INSERT INTO `options`(`question_id`, `option_text`) VALUES (?, ?)";
                        $stmt = $this->connect()->prepare($sql);
                        try {
                            if ($stmt->execute(array($questionId, $option))) {

                            } else {

                            }
                        } catch (PDOException $e) {
                            echo "Error: ";
                            return false;
                        }
                    }
                } else {
                    
                }
            } catch (PDOException $e) {
                echo "Error: ";
                return false;
            }
        }


    }

    protected function insertGdriveData($postId, $classCode, $fileName, $gdriveId, $fileSize, $userId){
        $newCode = $this->findSimilarCode($classCode);
        echo "Class Code " . $newCode[0]["class_code"] . " <br>\n";
        echo "Post Id " . $postId . " <br>\n";
        echo "Name " . $fileName . " <br>\n";
        echo "ID " . $gdriveId . " <br>\n";

        $sql = "INSERT INTO `files` (`post_id`, `class_code`, `file_name`, `google_drive_file_id`, `file_size`, `user_category`, `user_id`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $newCode[0]["class_code"], $fileName, $gdriveId, $fileSize, "3", $userId))) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e;
            return false;
        }
    }

    protected function updateAnswerKey($questionId, $answerKey){
        $empty = '';
        $sql = "UPDATE questions SET ans_key = ? WHERE MD5(question_id) = ?";
        $stmt = $this->connect()->prepare($sql);
        
        try {
            if ($stmt->execute(array($empty, $questionId))) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e;
            return false;
        }
    }

    protected function removeQuizInDb($postId){
        try {
            $conn = $this->connect();
            $conn->beginTransaction(); // Start transaction
        
            $sqlQuiz = "DELETE FROM quiz WHERE post_id = ?";
            $stmtQuiz = $conn->prepare($sqlQuiz);
            $stmtQuiz->execute([$postId]);
        
            $sqlPosts = "DELETE FROM posts WHERE post_id = ?";
            $stmtPosts = $conn->prepare($sqlPosts);
            $stmtPosts->execute([$postId]);
        
            $sqlGrades = "DELETE FROM grades WHERE post_id = ?";
            $stmtGrades = $conn->prepare($sqlGrades);
            $stmtGrades->execute([$postId]);
        
            $conn->commit(); // Commit transaction
        
            if ($stmtQuiz->rowCount() > 0 || $stmtPosts->rowCount() > 0 || $stmtGrades->rowCount() > 0) {
                echo "Success";
                return true;    
            }
            return false;
        } catch (PDOException $e) {
            $this->connect()->rollBack(); // Rollback on error
            echo "Error: " . $e->getMessage();
            return false;
        }
        
    }

    protected function deadlineAndPointsInDb($postID, $classCode){
        $sql = "SELECT starting_date, starting_time, deadline_date, deadline_time, points FROM activity WHERE MD5(post_id) = ? AND MD5(class_code) = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postID, $classCode))) {
                if ($stmt->rowCount() > 0) {
                    return $instList = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }else{
                    return null;
                }
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error in decryptQuestionId : ";
            return null;
        }
    }

    protected function insertActGradeInDb($classCode, $userId, $postId, $status, $grade){
        $sql = "INSERT INTO `grades`(`user_id`, `post_id`, `class_code`, `content_type`, `grade`, `status`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($userId, $postId, $classCode, "Activity", $grade, $status))) {
                if ($stmt->rowCount() > 0) {
                    return true;
                }

                return false;
                
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error in insertActGradeInDb : ";
            return false;
        }
    }

    protected function getActGradeInDb($postId, $classCode, $userId){
        // echo "user : " . $postId . "<br>";
        // echo "user : " . $classCode . "<br>";
        // echo "user : " . $userId . "<br>";

        $sql = "SELECT * FROM grades WHERE MD5(post_id) = ? AND MD5(class_code) = ? AND user_id = ? AND content_type = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $classCode, $userId, "Activity"))) {
                if ($stmt->rowCount() > 0) {
                    // echo "no result";
                    return $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }

                return null;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error in getActGradeInDb : ";
            return null;
        }
    }

    protected function updateActGradeInDb($postId, $classCode, $userId, $status, $grade){
        echo "\n\n\nGRADE : " . $grade . "\n\n\n";
        $sql = "UPDATE `grades` SET `grade`= ? WHERE user_id = ? AND post_id = ? AND class_code = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($grade, $userId, $postId, $classCode))) {
                if ($stmt->rowCount() > 0) {
                    return true;
                }

                return false;
                
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error in updateActGradeInDb : ";
            return false;
        }
    }

    protected function getQuiz($postId, $classCode){
        $sql = "SELECT starting_date, starting_time, deadline_date, deadline_time, attempt FROM quiz WHERE MD5(post_id) = ? AND MD5(class_code) = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $classCode))) {
                if ($stmt->rowCount() == 0) {
                    return null;
                }
                $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error getQuiz: " . $e;
            return null;
        }
    }

    protected function getQuizStatusFromDb($postId, $classCode, $userId){
        $sql = "SELECT grade, status FROM grades WHERE MD5(post_id) = ? AND MD5(class_code) = ? AND MD5(user_id) = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $classCode, $userId))) {
                if ($stmt->rowCount() == 0) {
                    return $result = null;
                }
                $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error getQuizStatusFromDb: " . $e;
            return null;
        }
    }

    protected function getQuizResultFromDb($postId, $classCode, $userId){
        $sql = "SELECT answers.user_id, answers.status, questions.points AS 'score', answers.answer_text, answers.attempt FROM `answers` INNER JOIN questions ON answers.question_id = questions.question_id WHERE md5(answers.post_id) = ? AND md5(answers.class_code) = ? AND MD5(answers.user_id) = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $classCode, $userId))) {
                if ($stmt->rowCount() == 0) {
                    return $result = null;
                }
                $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error getQuizResultFromDb: " . $e;
            return null;
        }
    }

    protected function getStudentNameInDb($userId){
        $sql = "SELECT * FROM users WHERE MD5(user_id) = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($userId))) {
                if ($stmt->rowCount() == 0) {
                    return $result = null;
                }
                $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error getQuizResultFromDb: " . $e;
            return null;
        }
    }

    protected function getQuizFormatInDb($postId, $classCode, $userId, $attempt){
        // echo "POST ID " . $postId . "<br>";
        // echo "CLASS CODE " . $classCode . "<br>";
        // echo "user id " . $userId . "<br>";
        // echo "ATTEMPT " . $attempt . "<br>";

        $sql = "SELECT answers.user_id, answers.status, questions.points AS 'score', answers.answer_text, answers.attempt, answers.question_id FROM `answers` INNER JOIN questions ON answers.question_id = questions.question_id WHERE md5(answers.post_id) = ? AND md5(answers.class_code) = ? AND MD5(answers.user_id) = ? AND answers.attempt = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $classCode, $userId, $attempt))) {
                if ($stmt->rowCount() == 0) {
                    return $result = null;
                }
                $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error getQuizFormatInDb: " . $e;
            return null;
        }
    }

    protected function fetchQuizDetailsWithTitle($postId, $classCode){
        $sql = "SELECT questions.question_id, questions.question_type, questions.question_text, questions.points, options.option_text, posts.title, questions.ans_key, quiz.deadline_date, quiz.deadline_time FROM quiz LEFT JOIN questions ON quiz.post_id = questions.post_id LEFT JOIN options ON options.question_id = questions.question_id LEFT JOIN posts ON posts.post_id = quiz.post_id WHERE md5(quiz.post_id) = ? AND md5(quiz.class_code) = ? ORDER BY questions.question_id";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $classCode))) {
                if ($stmt->rowCount() == 0) {
                    return null;
                }
                $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error fetchQuizDetails: " . $e;
            return null;
        }
    }

    protected function updatePostInDb($classCode, $title, $postId, $description, $startingDate, $startingTime, $deadlineDate, $deadlineTime, $type, $files, $points, $attempts){
        switch($type){
            case "Material":
                $this->updateMaterial($classCode, $title, $postId, $files, $description);
                break;
            case "Activity":
                $this->updateActivity($classCode, $title, $postId, $description, $startingDate, $startingTime, $deadlineDate, $deadlineTime, $points);
                break;
            case "Quiz":
                $this->updateQuiz($classCode, $title, $postId, $description, $startingDate, $startingTime, $deadlineDate, $deadlineTime, $attempts);
                break; 
            default:
                echo "NO TYPE FOUND ERROR";
                break;
        }
    }

    protected function updateQuiz($classCode, $title, $postId, $description, $startingDate, $startingTime, $deadlineDate, $deadlineTime, $attempts){
        // echo "\n\nInside Update Quiz\n\n";
        // echo "class code " . $classCode . "\n";
        // echo "title " . $title . "\n";
        // echo "postId " . $postId . "\n";
        // echo "description " . $description . "\n";
        // echo "startingDate " . $startingDate . "\n";
        // echo "startingTime " . $startingTime . "\n";
        // echo "deadlineTime  " . $deadlineDate . "\n";
        // echo "deadlineTime " . $deadlineTime . "\n";
        // echo "attempts " . $attempts . "\n";

        $sql = "START TRANSACTION;
                    UPDATE posts SET title = ?, content = ? WHERE MD5(class_code) = ? AND MD5(post_id) = ?;
                    UPDATE quiz SET starting_date = ?, starting_time = ?, deadline_date = ?, deadline_time = ?, attempt = ? WHERE MD5(class_code) = ? AND MD5(post_id) = ?;
                COMMIT;";
        $stmt = $this->connect()->prepare($sql);

        try {
        if ($stmt->execute(array($title, $description, $classCode, $postId, $startingDate, $startingTime, $deadlineDate, $deadlineTime, $attempts, $classCode, $postId))) {
            if ($stmt->rowCount() == 0) {
                return false;
            }
            return true;
        } else {
            return false;
        }
        } catch (PDOException $e) {
        echo "Error updateMaterial: " . $e;
        return false;
        }
    }

    protected function updateMaterial($classCode, $title, $postId, $files, $description){
        $sql = "UPDATE posts SET title = ?, content = ? WHERE MD5(class_code) = ? AND MD5(post_id) = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($title, $description, $classCode, $postId))) {
                if ($stmt->rowCount() == 0) {
                    return false;
                }
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error updateMaterial: " . $e;
            return false;
        }
    }

    protected function updateActivity($classCode, $title, $postId, $description, $startingDate, $startingTime, $deadlineDate, $deadlineTime, $points){
        echo "\n\n" . $classCode."\n\n\n";
        $sql = "START TRANSACTION;
                    UPDATE posts SET title = ?, content = ? WHERE MD5(class_code) = ? AND MD5(post_id) = ?;
                    UPDATE activity SET starting_date = ?, starting_time = ?, deadline_date = ?, deadline_time = ?, points = ? WHERE MD5(class_code) = ? AND MD5(post_id) = ?;
                COMMIT;";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($title, $description, $classCode, $postId, $startingDate, $startingTime, $deadlineDate, $deadlineTime, $points, $classCode, $postId))) {
                if ($stmt->rowCount() == 0) {
                    return false;
                }
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error updateMaterial: " . $e;
            return false;
        }
    }
    

    protected function removeFilesFromDb($files){
       $sql = "DELETE FROM files WHERE google_drive_file_id = ?";
       $stmt = $this->connect()->prepare($sql);

       try {
           if ($stmt->execute(array($files))) {
               if ($stmt->rowCount() == 0) {
                   return false;
               }
               return true;
           } else {
               return false;
           }
       } catch (PDOException $e) {
           echo "Error removeFilesFromDb: " . $e;
           return false;
       }
   }

   protected function removeActivityInDb($postId){
        $sql = "START TRANSACTION;
                      DELETE FROM activity WHERE MD5(post_id) = ?;
                      DELETE from posts WHERE MD5(post_id) = ?;
                      DELETE from grades WHERE MD5(post_id) = ?;
                      DELETE from comments WHERE MD5(post_id) = ?;
                COMMIT;";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $postId, $postId, $postId))) {
                if ($stmt->rowCount() == 0) {
                    return false;
                }
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error removeFilesFromDb: " . $e;
            return false;
        }
   }

   protected function removeMaterialInDb($postId){
        $sql = "START TRANSACTION;
                    DELETE from posts WHERE MD5(post_id) = ?;
                    DELETE from comments WHERE MD5(post_id) = ?;
                COMMIT;";    
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $postId))) {
                if ($stmt->rowCount() == 0) {
                    return false;
                }
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error removeFilesFromDb: " . $e;
            return false;
        }
    }

    protected function getUserCreateDateInDb($userId){
        $sql = "SELECT created FROM users WHERE user_id = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($userId))) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    protected function getAllQuizAndActInDb($userId){
        if (session_id() === "") session_start();

        $sql = "SELECT classes.class_code, activity.starting_date AS 'act start date', activity.starting_time AS 'act start time', activity.deadline_date AS 'act deadline date', activity.deadline_time AS 'act deadline time', quiz.starting_date AS 'quiz start date', quiz.starting_time AS 'quiz start time', quiz.deadline_date AS 'quiz deadline date', quiz.deadline_time AS 'quiz deadline time', posts.post_id AS 'post id', posts.content_type AS 'content type', posts.title AS 'post title' FROM posts
                INNER JOIN classes ON classes.class_code = posts.class_code
                INNER JOIN users ON users.user_id = classes.user_id
                LEFT JOIN activity ON posts.post_id = activity.post_id  
                LEFT JOIN quiz ON posts.post_id = quiz.post_id          
                WHERE (posts.content_type = ? OR posts.content_type = ?) AND users.user_id = ?;";

        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array("Quiz", "Activity", $userId))) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

}