<?php

require_once("../../log and reg backend/classes/connection.php");
require_once("../classes/model.Prof.php");
require_once("../classes/controller.Prof.php");

if(isset($_POST["post_id"])){
    $instrCtrlr = new InstructorController();
    $postId = $_POST["post_id"];
    $status = $_POST["status"];
    $classCode = $_POST["class-code"];
    $result = $instrCtrlr->changeVisibility($postId, $status);

    $details = $instrCtrlr->getClassDetails($classCode);

    header('content-type: application/json');
    echo json_encode($details);

}