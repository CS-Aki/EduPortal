<?php

require_once("../../log and reg backend/classes/connection.php");
require_once("../classes/model.Announce.php");
require_once("../classes/controller.Announce.php");

if (session_id() === "") session_start();

$announceController = new AnnounceController();
$currentDate = date('Y-m-d');

// echo $currentDate;

$activeAnnouncements = $announceController->getActiveAnnounce($currentDate);
$shownAnnouncements = $announceController->getAlreadyDisplayed($_SESSION["id"], $currentDate);

// echo var_dump($activeAnnouncements);

if ($shownAnnouncements == null) {
    $shownAnnouncements = [];
}

// Extract IDs into a flat array
$shownIds = array_column($shownAnnouncements, 'announcement_id');
// echo var_dump($shownIds);

$toDisplay = [];

// Compare against active announcements
foreach ($activeAnnouncements as $announcement) {
    if (!in_array($announcement['id'], $shownIds)) {
        $toDisplay[] = $announcement;
    }
}


foreach ($toDisplay as $announce) {
    $announceController->insertAnnounceLog($_SESSION["id"], $announce['id'], $currentDate); 
}

header('content-type: application/json');
echo json_encode($toDisplay);




