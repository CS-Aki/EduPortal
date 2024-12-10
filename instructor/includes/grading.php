<?php
    require_once("../../log and reg backend/classes/connection.php");
    require_once("../classes/model.Prof.php");
    require_once("../classes/controller.Prof.php");

if(isset($_POST["points"])){
    $points = $_POST["points"];
    $maxPoints = $_POST["maxPoints"];
    $classCode = $_POST["classCode"];
    $userId = $_POST["userId"];
    $postId = $_POST["postId"];
    $status = $_POST["status"];
    $grade = ($points / $maxPoints) * 100;
    echo "Grade " . $grade;
// echo $status;
    // echo $points . "\n";
    // echo $maxPoints . "\n";
    echo $classCode . "\n";
    echo $userId . "\n";
    echo $postId . "\n";
    $isSubmit = $_POST["submit"];
    $instrCtrlr = new InstructorController();

    if($isSubmit == true){
        $instrCtrlr->insertActivityGrade($classCode, $userId, $postId, $status, $grade);
    }else{
        $instrCtrlr->updateActivityGrade($classCode, $userId, $postId, $status, $grade);
    }

}