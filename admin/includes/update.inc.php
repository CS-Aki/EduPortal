<?php
if(session_id() === "") session_start();

if(isset($_POST['updateClassBtn'])){
    $_SESSION["searchSwitch"] = "all";
    $_SESSION["min"] = 1;
    $_SESSION["max"] = 5;
    header("Location: update-class.php");
}

if(isset($_POST['backBtn'])){
    unset($_SESSION["min"]);
    unset($_SESSION["max"]);
    unset($_SESSION["searchSwitch"]);
    header("Location: admin-dashboard.php");
    exit();
}
