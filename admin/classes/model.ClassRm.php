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

    protected function getClasses()
    {
        $sql = "SELECT class_code, class_name, class_teacher, class_schedule, class_status from classes WHERE class_num > ? AND class_num <= ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$_SESSION["min"], $_SESSION["max"]]);
        $listOfClass = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Note this one
        $_SESSION["list"] = $listOfClass;
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
}
