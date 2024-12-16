<?php

require_once("../../log and reg backend/classes/connection.php");
require_once("../classes/model.Prof.php");
require_once("../classes/controller.Prof.php");

$instrCtrlr = new InstructorController();

$result = $instrCtrlr->getGradingSystem($_POST["class"]);

// echo var_dump($result);
header('content-type: application/json');
echo json_encode($result);