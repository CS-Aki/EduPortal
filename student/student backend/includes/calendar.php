<?php 
if (session_id() === "") session_start();

require_once("../../../log and reg backend/classes/connection.php");
require_once("../classes/model.ClassRm.php");
require_once("../classes/controller.Lists.php");
require_once("../classes/controller.Student.php");

$list = new ListController();
$classList = $list->getAllClass($_SESSION["id"]);

header('content-type: application/json');
echo json_encode($classList);