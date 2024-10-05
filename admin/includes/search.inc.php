<?php
$controller = new ListController();
if(session_id() === "") session_start();
if(isset($_POST["searchClassCodeBtn"])){
    $result = $controller->getClassFromCode();
    $_SESSION["searchSwitch"] = "1";
    $_SESSION["user"] = $result;
}

if(isset($_POST["searchClassBtn"])){
    $result = $controller->getClassFromCName();
    $_SESSION["searchSwitch"] = "2";
    $_SESSION["user"] = $result;
}

if(isset($_POST["searchClassInsBtn"])){
    $result = $controller->getClassFromIns();
    $_SESSION["searchSwitch"] = "3";
    $_SESSION["user"] = $result;
}
