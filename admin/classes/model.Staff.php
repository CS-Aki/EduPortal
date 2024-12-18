<?php

class Staff extends DbConnection{
    protected function fetchAllStaff(){
        $sql = "SELECT user_id, name, email, status, created, birthdate FROM users WHERE user_category = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute([2])) {
                return $instList = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    protected function getStaffDetailInDb($userId, $userName){
        $sql = "SELECT user_id, name, email, status, created, birthdate, gender, address, image FROM users WHERE user_category = ? AND user_id = ? AND name = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute([2, $userId, $userName])) {
                return $instList = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

     protected function updateStaffDetails($instructorName, $status, $email, $gender, $address, $oldName, $staffCode, $birthdate, $password = null) {

        // Base SQL query without password
        $sql = "UPDATE users SET name = ?, status = ?, email = ?, gender = ?, address = ?, birthdate = ? WHERE name = ? AND user_id = ?";
        $params = [$instructorName, $status, $email, $gender, $address, $birthdate, $oldName, $staffCode];
    
        // Add password logic if provided
        if ($password) {
            $sql = "UPDATE users SET name = ?, status = ?, email = ?, gender = ?, address = ?, birthdate = ?, password = ? WHERE name = ? AND user_id = ?";
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $params = [$instructorName, $status, $email, $gender, $address, $birthdate, $hashedPassword, $oldName, $staffCode];
        }
    
        $stmt = $this->connect()->prepare($sql);
    
        try {
            if ($stmt->execute($params)) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error inside staff Model (updateStaffDetails): " . $e->getMessage();
            return null;
        }
    }
}
