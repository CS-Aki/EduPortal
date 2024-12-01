<?php
require_once("../../log and reg backend/classes/connection.php");
require_once("../classes/model.Prof.php");
require_once("../classes/controller.Prof.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if(empty($_POST['status'])) return;
        $statuses = $_POST['status']; 
        $classCode = $_POST["class-code"];
 
        $instrCtrlr = new InstructorController();
         // echo var_dump($statuses);
        foreach ($statuses as $studentId => $statusArray) {
            // echo $studentId;
            foreach($statusArray as $status){
                $instrCtrlr->submitAttendance($classCode, $studentId, $status);
            }
        }
    }