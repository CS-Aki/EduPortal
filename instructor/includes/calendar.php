<?php 
if (session_id() === "") session_start();

require_once("../../log and reg backend/classes/connection.php");
require_once("../classes/model.Prof.php");
require_once("../classes/controller.Prof.php");

$instrCtrlr = new InstructorController();
// $classList = $instrCtrlr->getProfClass();
$taskList = $instrCtrlr->getAllQuizAndAct($_SESSION["id"]);

header('content-type: application/json');
echo json_encode($taskList);