<?php
$_SESSION["searchSwitch"] = "all";
$_SESSION["min"] = 1;
$_SESSION["max"] = 5;

if(isset($_POST['backBtn'])){
    unset($_SESSION["min"]);
    unset($_SESSION["max"]);
    unset($_SESSION["searchSwitch"]);
    header("Location: admin-dashboard.php");
    exit();
}
