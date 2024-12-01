<?php 

require_once("../log and reg backend/classes/connection.php");
require_once("classes/model.Prof.php");
require_once("classes/controller.Prof.php");

$instrCtrlr = new InstructorController();
$sessionId = $instrCtrlr->getSession();

echo $sessionId[0]["session_id"];