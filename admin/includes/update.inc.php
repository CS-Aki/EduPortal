<?php
//if(session_id() === "") session_start();
$_SESSION["searchSwitch"] = "all";

if(isset($_POST['backBtn'])){
    unset($_SESSION["min"]);
    unset($_SESSION["max"]);
    unset($_SESSION["searchSwitch"]);
    header("Location: admin-dashboard.php");
    exit();
}

function updateButton(){
  return "update btn clicked";
}
