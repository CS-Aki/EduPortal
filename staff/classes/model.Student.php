<?php 

class Student extends DbConnection{

    protected function fetchAllStudent(){
        
        $sql = "SELECT user_id, name, email, address, gender, status, created FROM users WHERE user_category = 4";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute()) {
                return $studList = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    protected function fetchStudentClasses($studentName, $studentId){
        $sql = "SELECT join_class.class_code, classes.class_name, classes.class_teacher, classes.class_schedule, classes.class_status FROM join_class INNER JOIN users ON users.user_id = join_class.user_id INNER JOIN classes ON join_class.class_code = classes.class_code WHERE users.name = ? AND users.user_id = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($studentName, $studentId))) {
                return $classList = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    protected function fetchStudentDetails($studentName, $studentId){
        $sql = "SELECT name, status, email, user_id, gender, address, image, birthdate, created FROM users WHERE name = ? AND user_id = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute(array($studentName, $studentId))) {
                return $classList = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    protected function updateStudentDetails($instructorName, $status,  $email,  $gender, $address, $oldName, $studentCode, $birthdate){

        $sql = "UPDATE users SET name = ?, status= ?, email = ?, gender = ?, address = ?, birthdate = ? WHERE name = ? AND user_id = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute([$instructorName, $status,  $email,  $gender, $address, $birthdate, $oldName, $studentCode])) {
                $stmt = null;
                $this->updtStudentJoinClass($instructorName, $oldName, $studentCode);
                $this->updStudentNameInComments($instructorName, $oldName, $studentCode);
                // $this->updProfNameInClass($instructorName, $oldName);
                // $this->updProfNameInPost($instructorName, $oldName);
                // $this->updProfNameInComments($instructorName, $oldName);
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {

            echo "Error inside Student Model (updateStudentDetails): " . $e->getMessage();
            return null;
        }
    }

    // Updates the join class table
    protected function updtStudentJoinClass($instructorName, $oldName, $studentCode){
        $sql = "UPDATE join_class SET name = ? WHERE name = ? AND user_id = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute([$instructorName, $oldName, $studentCode])) {
                $stmt = null;
                // $this->updProfNameInClass($instructorName, $oldName);
                // $this->updProfNameInPost($instructorName, $oldName);
                // $this->updProfNameInComments($instructorName, $oldName);
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {

            echo "Error inside Student Model (updtStudentJoinClass): " . $e->getMessage();
            return null;
        }
    }

    protected function updStudentNameInComments($instructorName, $oldName, $studentCode){
        $sql = "UPDATE comments SET name = ? WHERE name = ? AND user_id = ?";
        $stmt = $this->connect()->prepare($sql);

        try {
            if ($stmt->execute([$instructorName, $oldName, $studentCode])) {
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