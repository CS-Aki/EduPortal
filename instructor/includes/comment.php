<?php

require_once("../../log and reg backend/classes/connection.php");
require_once("../classes/model.Prof.php");
require_once("../classes/controller.Prof.php");

if(isset($_POST["comment"])){
    session_start();
    $comment = $_POST["comment"];

    if(empty($comment)) return;

    // echo $comment;
    $postId =  $_POST["post-id"];
    $instrCtrlr = new InstructorController();
    // $stdController = new StudentController();
    $classCode = $_POST["class-code"];
    $postDetails = $instrCtrlr->getPostDetails($postId, $classCode);
    
    // $postDetails = $stdController->getPostDetails($postTitle, $classCode);

    // echo $postDetails[0]["class_code"];
    // echo "<br>". $postDetails[0]["title"];

    $result = $instrCtrlr->postComment($postDetails[0]["post_id"],  $postDetails[0]["class_code"], $comment);

    if($result == true){
        echo "Success Comment";
    }else{
        echo "Failed Comment";
    }

}

function isProcessRunning($pid) {
    // Check for Windows
    if (strncasecmp(PHP_OS, 'WIN', 3) === 0) {
        $output = [];
        exec("tasklist /FI \"PID eq $pid\" 2>NUL", $output);
        return count($output) > 1; // If there's more than 1 line, the process is running
    }

    // Check for Unix-based systems
    return file_exists("/proc/$pid");
}

