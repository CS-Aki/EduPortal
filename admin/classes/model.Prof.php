<?php

class Instructor extends DbConnection
{
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
}
