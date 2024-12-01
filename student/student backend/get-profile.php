<?php
if (session_id() === "") session_start();
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