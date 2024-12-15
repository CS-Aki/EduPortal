<?php

class Announcement extends DbConnection
{
    protected function postAnnouncementInDb($subject, $fromDate, $toDate, $msgType, $audience, $message){
        $sql = "INSERT INTO `announcement`(`title`, `message`, `start_date`, `end_date`, `msg_type`, `user_category`) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->connect()->prepare($sql);
      
        try {
            if ($stmt->execute(array($subject, $message, $fromDate, $toDate, $msgType, $audience))) {
                if ($stmt->rowCount() > 0) {
                    return true;
                } 
                return false;
            } else {
                return false;
            }
        } catch (PDOException $e) {
                // Log the error message
                echo "Error: " . $e->getMessage();
                return false;
        }
    }

    protected function getAllAnnouncementInDb(){
        $sql = "SELECT * FROM announcement ORDER BY id DESC LIMIT 3";

        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array())) {
                if ($stmt->rowCount() > 0) {
                    return $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } 
                return null;
            } else {
                return null;
            }
        } catch (PDOException $e) {
                // Log the error message
                echo "Error: " . $e->getMessage();
                return null;
        }
    }

    protected function getAnnouncementInDb($announceId){
        $sql = "SELECT * FROM announcement WHERE id = ?";

        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($announceId))) {
                if ($stmt->rowCount() > 0) {
                    return $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } 
                return null;
            } else {
                return null;
            }
        } catch (PDOException $e) {
                // Log the error message
                echo "Error: " . $e->getMessage();
                return null;
        }
    }

    protected function getActiveAnnounceInDb($currentDate){
        $sql = "SELECT * FROM announcement WHERE start_date <= ? AND end_date >= ? AND (user_category = ? OR user_category = ?)";

        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($currentDate, $currentDate, 2, 5))) {
                if ($stmt->rowCount() > 0) {
                    return $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } 
                return null;
            } else {
                return null;
            }
        } catch (PDOException $e) {
                // Log the error message
                echo "Error: " . $e->getMessage();
                return null;
        }
    }

    protected function getAlreadyDisplayedInDb($userId, $currentDate){
        $sql =  "SELECT announcement_id FROM announcement_logs WHERE user_id = ? AND display_date = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($userId, $currentDate))) {
                if ($stmt->rowCount() > 0) {
                    return $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } 
                return null;
            } else {
                return null;
            }
        } catch (PDOException $e) {
                // Log the error message
                echo "Error: " . $e->getMessage();
                return null;
        }
    }

    protected function insertAnnounceLogDb($userId, $announceId, $currentDate){
        $sql =  "INSERT INTO announcement_logs (user_id, announcement_id, display_date) VALUES (?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($userId, $announceId, $currentDate))) {
                if ($stmt->rowCount() > 0) {
                    return true;
                } 
                return false;
            } else {
                return false;
            }
        } catch (PDOException $e) {
                // Log the error message
                return false;
        }
    }
}
