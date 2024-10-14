<?php
$_SESSION["searchSwitch"] = "all";

if(isset($_POST['backBtn'])){
    unset($_SESSION["min"]);
    unset($_SESSION["max"]);
    unset($_SESSION["searchSwitch"]);
    unset($_SESSION["counter"]);
    header("Location: admin-dashboard.php");
    exit();
}

function updateButton(){
  return "update btn clicked";
}
