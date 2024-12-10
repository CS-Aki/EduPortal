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
    
    protected function fetchStudentList($classCode){
        $sql = "SELECT join_class.user_id, join_class.name, users.image FROM join_class INNER JOIN users ON users.user_id = join_class.user_id WHERE join_class.class_code = ?";
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

    protected function fetchStudentAttndList($classCode){
        date_default_timezone_set('Asia/Manila');
        $currentDate = date("Y/m/d");
        
        $sql = "SELECT users.user_id, users.name, attendance.status FROM users INNER JOIN attendance ON attendance.user_id = users.user_id WHERE attendance.class_code = ? AND attendance.date = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($classCode, $currentDate))) {
      
                if ($stmt->rowCount() > 0) {
                    $result1 =  $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $attendanceMap = [];

                    foreach ($result1 as $record) {
                        $attendanceMap[$record["user_id"]] = $record["status"];
                    }

                    $sql = "SELECT user_id, name FROM join_class WHERE class_code = ?";
                    $stmt = $this->connect()->prepare($sql);
                    
                    if ($stmt->execute(array($classCode))) {
                         $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as &$student) {
                                if (isset($attendanceMap[$student["user_id"]])) {
                                    // If user_id exists in attendance, set its status
                                    $student["status"] = $attendanceMap[$student["user_id"]];
                                } else {
                                    // If user_id is not in attendance, mark as "Pending"
                                    $student["status"] = "Pending";
                                }
                            }
                         return $result;
                    }

                }else{
                    $sql = "SELECT user_id, name FROM join_class WHERE class_code = ?";
                    $stmt = $this->connect()->prepare($sql);
                    if ($stmt->execute(array($classCode))) {
                         $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);
                         for($i = 0; $i < count($result); $i++){
                                $result[$i]["status"] = "Pending";
                         }
                         return $result;
                    }
                }

            } else {
        
            }
        } catch (PDOException $e) {
            echo "Error: " . $e;
            return null;
        }
        return null;
    }

    protected function getClasses()
    {
        $sql = "SELECT classes.class_code, classes.class_name, classes.class_teacher, classes.class_schedule from join_class INNER JOIN classes ON join_class.class_code = classes.class_code INNER JOIN users ON users.user_id = join_class.user_id WHERE join_class.user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(array($_SESSION["user_id"]));
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

    protected function fetchQuizzes($classCode){
        $sql = "SELECT quiz.*, posts.title FROM quiz INNER JOIn posts ON quiz.post_id = posts.post_id WHERE MD5(quiz.class_code) = ? AND posts.content_type = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($classCode, "Quiz"))) {
                if ($stmt->rowCount() == 0) {
                    return null;
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

    protected function fetchQuiz($classCode, $postId){
        $sql = "SELECT quiz.*, posts.title FROM quiz INNER JOIn posts ON quiz.post_id = posts.post_id WHERE MD5(quiz.class_code) = ? AND posts.content_type = ? AND MD5(quiz.post_id) = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($classCode, "Quiz", $postId))) {
                if ($stmt->rowCount() == 0) {
                    return null;
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

    protected function getActsSubInDb($classCode){
        $sql = "SELECT created, user_id, google_drive_file_id, file_size, file_name, created, post_id, class_code FROM files WHERE MD5(class_code) = ? AND user_category = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($classCode, 4))) {
                if ($stmt->rowCount() == 0) {
                    return null;
                }
                $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);
                //echo var_dump($result);
                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error getActsSubInDb: " . $e->getMessage();
            return null;
        }
    }
}