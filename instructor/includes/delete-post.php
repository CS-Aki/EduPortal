<?php

require_once("../../log and reg backend/classes/connection.php");
require_once("../classes/model.Prof.php");
require_once("../classes/controller.Prof.php");

if(isset($_POST["postId"])){
    $postId = $_POST["postId"];
    $instrCtrlr = new InstructorController();
    $instrCtrlr->removeQuiz($postId);

}
