<?php

class Instructor extends DbConnection
{
    protected function fetchAllInstructor()
    {
        $sql = "SELECT user_id, name, email, status FROM users WHERE user_category = 3";
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
        $sql = "SELECT user_id, name, email, gender, image, status, address FROM users WHERE user_category = 3 AND name = ?";
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

    protected function fetchAllProfClass($profName, $userId)
    {
        $sql = "SELECT classes.class_teacher, classes.class_code, classes.class_name, classes.class_schedule, classes.class_status, users.email, users.gender, users.address, users.image, users.status, classes.class_status FROM classes INNER JOIN users ON users.user_id = classes.user_id WHERE classes.class_teacher = ? AND classes.user_id = ?";
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
    protected function updateProfDetails($instructorName, $status,  $email,  $gender, $address, $oldName){

        $sql = "UPDATE users SET name = ?, status= ?, email = ?, gender = ?, address = ? WHERE name = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute([$instructorName, $status,  $email,  $gender, $address, $oldName])) {
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
