<?php

class ClassRm extends DbConnection
{

    protected function addNewClass($classCode, $className, $classSchedule, $classProf, $status)
    {
        $sql = "INSERT INTO classes (`class_code`, `class_name`, `class_teacher`, `class_schedule`, `class_status`) VALUES (?, ? ,?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);

        if ($stmt->execute(array($classCode, $className, $classProf, $classSchedule, $status))) {
            return true;
        } else {
            return false;
        }
    }

    protected function isClassNameExist($clasName)
    {
        $sql = "SELECT class_name from classes WHERE class_name = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$clasName]);

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function isClassCodeExist($classCode)
    {
        $sql = "SELECT class_code from classes WHERE class_code = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$classCode]);

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function getClasses($userId)
    {
        $sql = "SELECT classes.class_code, classes.class_name, classes.class_teacher, classes.class_schedule from join_class INNER JOIN classes ON join_class.class_code = classes.class_code INNER JOIN users ON users.user_id = join_class.user_id WHERE join_class.user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(array($userId));
        $listOfClass = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        //Note this one
        // $_SESSION["list"] = $listOfClass;
        return $listOfClass;
    }

    protected function fetchClassFromCode($classCode)
    {
        $sql = "SELECT class_num, class_code, class_name, class_teacher, class_schedule, class_status from classes WHERE class_code = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$classCode]);

        return $class = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function fetchClassFromCName($className)
    {
        $sql = "SELECT class_code, class_name, class_teacher, class_schedule, class_status from classes WHERE class_name = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$className]);

        return $class = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function fetchClassFromIns($classIns)
    {
        $min = (int) $_SESSION["min"];
        $max = (int) $_SESSION["max"];  

        $sql = "SELECT class_code, class_name, class_teacher, class_schedule, class_status from classes WHERE class_teacher = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$classIns]);
        // $stmt->execute([$_SESSION["min"], $_SESSION["max"]]);
        return $class = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function fetchTotalClass()
    {
        $sql = "SELECT COUNT('class_num') AS 'count' FROM `classes`";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        return $total = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function editClassInfo($classCode, $className, $classSchedule, $classProf, $status)
    {
        //   var_dump($classCode, $className, $classSchedule, $classProf, $status);
        $sql = "UPDATE classes SET class_name = ?, class_teacher = ?, class_schedule = ?, class_status = ? WHERE class_code = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($className, $classProf, $classSchedule, $status, $classCode))) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Log the error message
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    protected function getClassNum($classCode){
        $sql = "SELECT class_num from classes WHERE class_code = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(array($classCode));
        $classNum = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $classNum;
    }

    protected function joiningClass($userId, $userName, $classCode, $classNum){
        $sql = "INSERT INTO join_class VALUES (?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(array($userId, $userName, $classCode, $classNum));

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function alreadyInClass($classCode, $userId){
        $sql = "SELECT class_num from join_class WHERE class_code = ? AND user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(array($classCode, $userId));
    
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function fetchClassDetails($classCode){
        // $code = $this->findSimilarCode($classCode);
        // echo "<br> Inside of " . $classCode;
        // $code = $this->findSimilarCode($classCode);

        $sql = "SELECT posts.post_id, posts.class_code, posts.prof_name, posts.title, posts.content_type, posts.content, posts.visibility, TIME(posts.created_at) as 'time', DATE(posts.created_at) as 'month', classes.class_name, classes.class_schedule FROM posts INNER JOIN classes ON classes.class_code = posts.class_code WHERE classes.class_code = ? AND visibility = ? AND posts.content_type = ?";
        $stmt = $this->connect()->prepare($sql);

        $stmt->execute([$classCode, "Visible", "Material"]);

        if ($stmt->rowCount() == 0) {
            return $result = $this->fetchClassFromCode($classCode);
        }

        return $code = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function fetchClassDetails1($classCode){
        // $code = $this->findSimilarCode($classCode);
        // echo "<br> Inside of " . $classCode;
        $code = $this->findSimilarCode($classCode);

        // $sql = "SELECT posts.post_id, posts.class_code, posts.prof_name, posts.title, posts.content_type, posts.content, posts.visibility, TIME(posts.created_at) as 'time', DATE(posts.created_at) as 'month', classes.class_name, classes.class_schedule FROM posts INNER JOIN classes ON classes.class_code = posts.class_code WHERE MD5(classes.class_code) = ?";
        // $stmt = $this->connect()->prepare($sql);

        $sql = "SELECT class_code, class_name, class_teacher, class_schedule, class_status from classes WHERE class_code = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$code[0]["class_code"]]);

        return $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function findSimilarCode($classCode){
        $sql = "SELECT class_code FROM `classes` WHERE MD5(class_code) = ?";
        $stmt = $this->connect()->prepare($sql);

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

    protected function fetchPostDetails($postID, $classCode){
        // echo $title;
        $sql = "SELECT posts.post_id, posts.class_code, posts.content, TIME(posts.created_at) as 'time', DATE(posts.created_at) as 'month', posts.title, posts.content_type FROM posts WHERE MD5(posts.post_id) = ? AND MD5(posts.class_code) = ? AND posts.visibility = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postID, $classCode, "Visible"))) {
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

    protected function fetchSubmittedInPost($postId, $classCode, $userId){
        $sql = "SELECT * FROM files WHERE md5(class_code) = ? AND md5(post_id) = ? AND user_id = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($classCode, $postId, $userId))) {
                if ($stmt->rowCount() == 0) {
                    return $result = null;
                }
                $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e;
            return null;
        }
    }

    protected function fetchComments($postID, $classCode){
        $sql = "SELECT comments.post_id, comments.name, comments.comment, comments.user_id, users.image, TIME(comments.created_at) as 'time', DATE(comments.created_at) as 'month' FROM comments INNER JOIN posts ON posts.post_id = comments.post_id INNER JOIN users ON comments.user_id = users.user_id WHERE MD5(posts.post_id) = ? AND MD5(posts.class_code) = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postID, $classCode))) {
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

    protected function fetchStudentList($classCode){
        $sql = "SELECT join_class.user_id, join_class.name, users.image, classes.class_teacher FROM join_class INNER JOIN users ON users.user_id = join_class.user_id INNER JOIN classes ON classes.class_code = join_class.class_code WHERE join_class.class_code = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($classCode))) {
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

    protected function fetchStudentProfile($name, $email){
            // Will add more columns here
            $sql = "SELECT user_id FROM users WHERE name = ? AND email = ?";
            $stmt = $this->connect()->prepare($sql);

            try {
                if ($stmt->execute(array($name, $email))) {
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

    protected function findInstructor($profName)
    {
        $sql = "SELECT user_id, name, email, image FROM users WHERE user_category = 3 AND name = ?";
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

    protected function isClassActive($classCode){
        $sql = "SELECT class_status FROM classes WHERE class_code = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($classCode))) {
                if ($stmt->rowCount() > 0) {
                   $status = $stmt->fetchAll(PDO::FETCH_ASSOC);
                   if($status[0]["class_status"] == "Archived"){
                      return false;
                   }else{
                      return true;
                   }
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Log the error message
            echo "Error in isUserActive (ClassRm Model): " . $e->getMessage();
            return false;
        }
    }

    protected function fetchStudentAttendance($studentId, $classCode, $currentDate){
    
        $sql = "SELECT status FROM attendance WHERE user_id = ? AND MD5(class_code) = ? AND date = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($studentId, $classCode, $currentDate))) {
                if ($stmt->rowCount() > 0) {
                   return $status = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error in fetchStudentAttendance (ClassRm Model): " . $e->getMessage();
            return null;
        }
    }

    protected function getFIlesInDb($postId, $classCode){
        // echo $postId . "<br>";
        // echo $classCode;
        $sql = "SELECT file_id, file_name, google_drive_file_id, file_size FROM files WHERE MD5(post_id) = ? AND MD5(class_code) = ? AND user_category = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $classCode, "3"))) {
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

    protected function findId($postId, $classCode){
        $sql = "SELECT post_id FROM posts WHERE MD5(post_id) = ? AND MD5(class_code) = ?";
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

    protected function insertGdriveData($postId, $classCode, $fileName, $gdriveId, $fileSize, $userId){
        $newCode = $this->findSimilarCode($classCode);
        $newId = $this->findId($postId, $classCode);
        echo $classCode;
        echo "\n\nClass Code " . $newCode[0]["class_code"] . " <br>\n";
        echo "\nPost Id " . $postId . " <br>\n";
        echo "\nName " . $fileName . " <br>\n";
        echo "\nID " . $gdriveId . " <br>\n";

        $sql = "INSERT INTO `files` (`post_id`, `class_code`, `file_name`, `google_drive_file_id`, `file_size`, `user_category`, `user_id`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($newId[0]["post_id"], $newCode[0]["class_code"], $fileName, $gdriveId, $fileSize, "4", $userId))) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e;
            return false;
        }
    }

    protected function fetchSubmissions($classCode){
        $sql = "SELECT files.file_name, posts.title, posts.post_id, files.created FROM `files` INNER JOIN posts ON posts.post_id = files.post_id WHERE md5(files.class_code) = ? AND files.user_category = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($classCode, "4"))) {
                if ($stmt->rowCount() == 0) {
                    return $result = null;
                }
                $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: fetchSubmissions " . $e;
            return null;
        }
    }

    protected function fetchQuizDetails($postId, $classCode){
        $sql = "SELECT questions.question_id, questions.question_type, questions.question_text, questions.points, options.option_text, posts.title, questions.ans_key, quiz.deadline_date, quiz.deadline_time FROM quiz LEFT JOIN questions ON quiz.post_id = questions.post_id LEFT JOIN options ON options.question_id = questions.question_id LEFT JOIN posts ON posts.post_id = quiz.post_id WHERE md5(quiz.post_id) = ? AND md5(quiz.class_code) = ? ORDER BY questions.question_id";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $classCode))) {
                if ($stmt->rowCount() == 0) {
                    return $result = $this->fetchQuizTitle($postId, $classCode);;
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

    protected function fetchQuizTitle($postId, $classCode){
        return null;
    }

    protected function submitAnswersToQuiz($userId, $postId, $classCode, $status, $answer, $questionId, $attempt){
        $sql = "INSERT INTO `answers`(`user_id`, `post_id`, `class_code`, `status`, `answer_text`, `question_id`, `attempt`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($userId, $postId, $classCode, $status, $answer, $questionId, $attempt))) {
                if ($stmt->rowCount() == 0) {
                    return false;
                }

                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error inside submitAnswersToQuiz: " . $e;
            return false;
        }
    }

    protected function getQuizStatusFromDb($postId, $classCode, $userId){
        $sql = "SELECT grade, status FROM grades WHERE MD5(post_id) = ? AND MD5(class_code) = ? AND user_id = ?";
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
        $sql = "SELECT answers.user_id, answers.status, questions.points AS 'score', answers.answer_text, answers.attempt FROM `answers` INNER JOIN questions ON answers.question_id = questions.question_id WHERE md5(answers.post_id) = ? AND md5(answers.class_code) = ? AND answers.user_id = ?";
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

    protected function getAnsweredQuizInDb($classCode, $userId){
        // SELECT DISTINCT answers.post_id, answers.created FROM `answers` LEFT JOIN quiz ON quiz.class_code = answers.class_code WHERE answers.user_id = 15 AND quiz.class_code = "3fCPK434" GROUP BY answers.post_id ORDER BY answers.post_id
        $sql = "SELECT DISTINCT answers.post_id, answers.created FROM `answers` INNER JOIN quiz ON quiz.class_code = answers.class_code WHERE answers.user_id = ? AND MD5(quiz.class_code) = ? GROUP BY answers.post_id ORDER BY answers.post_id";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($userId, $classCode))) {
                if ($stmt->rowCount() == 0) {
                    return $result = null;
                }
                $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error getAnsweredQuizInDb: " . $e;
            return null;
        }
    }

    protected function getQuizInClass($classCode){
        $sql = "SELECT posts.post_id, TIME(posts.created_at) as 'time', DATE(posts.created_at) as 'month', posts.title, posts.content_type, posts.content, quiz.starting_date, quiz.starting_time, quiz.deadline_date, quiz.deadline_time, quiz.status FROM `posts` INNER JOIN quiz ON quiz.post_id = posts.post_id WHERE posts.class_code = ? AND quiz.starting_date <= NOW() AND quiz.starting_time <= NOW()";
        $stmt = $this->connect()->prepare($sql);

        $stmt->execute([$classCode]);

        if ($stmt->rowCount() == 0) {
            return null;
        }

        return $code = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function getActsInClass($classCode){
        $sql = "SELECT posts.post_id, TIME(posts.created_at) as 'time', DATE(posts.created_at) as 'month', posts.title, posts.content_type, posts.content, activity.starting_date, activity.starting_time, activity.deadline_date, activity.deadline_time, activity.status FROM `posts` INNER JOIN activity ON activity.post_id = posts.post_id WHERE posts.class_code = ? AND activity.starting_date <= NOW()";
        $stmt = $this->connect()->prepare($sql);

        $stmt->execute([$classCode]);

        if ($stmt->rowCount() == 0) {
            return null;
        }

        return $code = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    protected function getQuizAttemptDb($postId, $userId){
        $sql = "SELECT attempt, starting_time, deadline_date, deadline_time, attempt FROM answers WHERE MD5(post_id) = ? AND user_id = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId, $userId))) {
                if ($stmt->rowCount() == 0) {
                    return null;
                }
                $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error getQuizAttemptDb: " . $e;
            return null;
        }
    }

    protected function getQuizFormatInDb($postId, $classCode, $userId, $attempt){
        // echo "POST ID " . $postId . "<br>";
        // echo "CLASS CODE " . $classCode . "<br>";
        // echo "user id " . $userId . "<br>";
        // echo "ATTEMPT " . $attempt . "<br>";

        $sql = "SELECT answers.user_id, answers.status, questions.points AS 'score', answers.answer_text, answers.attempt FROM `answers` INNER JOIN questions ON answers.question_id = questions.question_id WHERE md5(answers.post_id) = ? AND md5(answers.class_code) = ? AND answers.user_id = ? AND answers.attempt = ?";
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

    protected function getTotalItemsInDb($postId){
        $sql = "SELECT COUNT(post_id) as totalItems FROM `questions` WHERE MD5(post_id) = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($postId))) {
                if ($stmt->rowCount() == 0) {
                    return $result = null;
                }
                $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error getTotalItemsInDb: " . $e;
            return null;
        }
    }

    protected function insertGradeInDb($userId, $postId, $classCode, $contentType, $grade, $status){
        // INSERT INTO `grades`(`user_id`, `post_id`, `class_code`, `content_type`, `grade`) VALUES ()
        $sql = "INSERT INTO `grades`(`user_id`, `post_id`, `class_code`, `content_type`, `grade`, `status`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($userId, $postId, $classCode, $contentType, $grade, $status))) {
                if ($stmt->rowCount() == 0) {
                    return false;
                }
        
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error insertGradeInDb: " . $e;
            return false;
        }
    }
}