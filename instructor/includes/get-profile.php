<?php
if (session_id() === "") session_start();

require_once("../log and reg backend/classes/connection.php");
require_once("classes/model.Prof.php");
require_once("classes/controller.Prof.php");

$instrCtrlr = new InstructorController();
$created = $instrCtrlr->getUserCreateDate($_SESSION["id"]);

$folder = '../profiles/';
$images = glob($folder . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

foreach ($images as $image) {
    $fileInfo = pathinfo($image);

    $fileType = strtolower($fileInfo['extension']);

    if(file_exists("../profiles/". $_SESSION["id"] . ".". $fileType)){
        $_SESSION["profile"] = $_SESSION["id"] . ".". $fileType;
        break;
    }
}

// echo $created[0]["created"];
$year = substr($created[0]["created"], 0, 4);

for($i = strlen($_SESSION["id"]); $i < 4; $i++){
    $year .= "0";
}

$year .= $_SESSION["id"] . "-S";
$_SESSION["id-code"] = $year;

// echo $_SESSION["id-code"];