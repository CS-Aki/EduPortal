<?php

class Instructor extends DbConnection
{
    protected function fetchAllInstructor()
    {
        $sql = "SELECT user_id, name, email, status, created, birthdate FROM users WHERE user_category = 3";
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

    protected function findInstructor($profName, $userId)
    {
        $sql = "SELECT user_id, name, email, gender, image, status, address, created, birthdate FROM users WHERE user_category = 3 AND name = ? AND user_id = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute([$profName, $userId])) {
                return $instList = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    protected function fetchAllProfClass($profName, $userId)
    {
        $sql = "SELECT classes.class_teacher, classes.class_code, classes.class_name, classes.class_schedule, classes.class_status, users.email, users.gender, users.address, users.image, users.status, classes.class_status, users.created, users.birthdate FROM classes INNER JOIN users ON users.user_id = classes.user_id WHERE classes.class_teacher = ? AND classes.user_id = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute([$profName, $userId])) {
                return $classList = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    // Update the name in users table
    protected function updateProfDetails($instructorName, $status,  $email,  $gender, $address, $oldName, $userId, $birthdate, $password = null){
         // Base SQL query without password
          // Base SQL query without password
        $sql = "UPDATE users SET name = ?, status = ?, email = ?, gender = ?, address = ?, birthdate = ? WHERE name = ? AND user_id = ?";
        $params = [$instructorName, $status, $email, $gender, $address, $birthdate, $oldName, $userId];
    
        // Add password logic if provided
        if ($password) {
            $sql = "UPDATE users SET name = ?, status = ?, email = ?, gender = ?, address = ?, birthdate = ?, password = ? WHERE name = ? AND user_id = ?";
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $params = [$instructorName, $status, $email, $gender, $address, $birthdate, $hashedPassword, $oldName, $userId];
        }
    
        $stmt = $this->connect()->prepare($sql);
        try {
            if ($stmt->execute($params)) {
                $stmt = null;
                $this->updProfNameInClass($instructorName, $oldName);
                $this->updProfNameInPost($instructorName, $oldName);
                $this->updProfNameInComments($instructorName, $oldName);
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Email already in use";
            // echo "Error inside Prof Model (updateProfDetails): " . $e->getMessage();
            return null;
        }
    }

    // Update the name in classes table
    protected function updProfNameInClass($newName, $oldName){
        $sql = "UPDATE classes SET class_teacher = ? WHERE class_teacher = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute([$newName, $oldName])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error inside Prof Model (updProfNameInClass): " . $e->getMessage();
            return null;
        }
    }

    // Update the name in posts table
    protected function updProfNameInPost($newName, $oldName){
        $sql = "UPDATE posts SET prof_name = ? WHERE prof_name = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute([$newName, $oldName])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error inside Prof Model (updProfNameInPost): " . $e->getMessage();
            return null;
        }
    }

      // Update the name in comments table
      protected function updProfNameInComments($newName, $oldName){
        $sql = "UPDATE comments SET name = ? WHERE name = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute([$newName, $oldName])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error inside Prof Model (updProfNameInComments): " . $e->getMessage();
            return null;
        }
    }


}
