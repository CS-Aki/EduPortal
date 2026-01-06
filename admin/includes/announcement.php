<?php

if(isset($_POST["subject"])){

    require_once("../classes/connection.php");
    require_once("../classes/model.Announce.php");
    require_once("../classes/controller.Announce.php");

    $subject = $_POST["subject"]; 
    $fromDate = $_POST["fromDate"];
    $toDate = $_POST["toDate"];
    $msgType = $_POST["msgType"];
    $audience = $_POST["audience"];
    $message = $_POST["message"];

    $announceController = new AnnounceController();
    $announceController->postAnnouncement($subject, $fromDate, $toDate, $msgType, $audience, $message);
}

if(isset($_POST["announceId"])){
    require_once("../classes/connection.php");
    require_once("../classes/model.Announce.php");
    require_once("../classes/controller.Announce.php");

    $announceId = $_POST["announceId"];
    $announceController = new AnnounceController();
    $result = $announceController->getAnnouncement($announceId);

    header('content-type: application/json');
    echo json_encode($result);
}


function displayAnnouncements(){
    require_once("../classes/connection.php");

    require_once("../classes/model.Announce.php");
    require_once("../classes/controller.Announce.php");

    $announceController = new AnnounceController();
    $list = $announceController->getAllAnnouncement();

    for($i = 0; $i < count($list); $i++){
        echo "<a href='' class='view-announcement'>";
        echo "<div class='announce-id' hidden>{$list[$i]["id"]}</div>";
        echo "<div class='container-fluid bg-body-secondary rounded-3 px-lg-3 d-flex align-items-center p-2 mb-2'>";
        echo "<div><i class='bi bi-megaphone-fill green1 me-3 fs-2'></i></div>";
        echo "<div><p class='black3 fw-bold lh-1 fs-6 mb-0 pb-0' id='material-title'>{$list[$i]['title']}<span class='fw-light black3 fs-6 d-flex mt-1' id='material-date'></p></div>";
        echo "</div></a>";
    }
}

if(isset($_POST["newAnnouncement"])){
    displayAnnouncements();
}
