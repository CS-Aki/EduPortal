<?php

require_once("../../log and reg backend/classes/connection.php");
require_once("../classes/model.Prof.php");
require_once("../classes/controller.Prof.php");

$quizTitle = $_POST["title"];
$data = $_POST["questions"];

echo "The title is " . $quizTitle;
echo var_dump($data);