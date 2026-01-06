<?php
if (session_id() === "") session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_GET["code"])){
    require_once("../vendor/autoload.php");
    require_once("../log and reg backend/classes/connection.php");
    require_once("classes/model.Prof.php");
    require_once("classes/controller.Prof.php");
}else{
    require_once("../../vendor/autoload.php");
    require_once("../../log and reg backend/classes/connection.php");
    require_once("../classes/model.Prof.php");
    require_once("../classes/controller.Prof.php");
}

function deleteFileFromDrive($fileId)
{
    // Path to your credentials.json
    $credentialsPath = '../../log and reg backend/config/credentials.json';

    // Create a Google client
    $client = new Google_Client();
    $client->setAuthConfig($credentialsPath);
    $client->addScope(Google_Service_Drive::DRIVE);

    // Authenticate the client
    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
        $client->setAccessToken($_SESSION['access_token']);

        // Refresh the token if it has expired
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($_SESSION["refresh_token"]);
            $_SESSION['access_token'] = $client->getAccessToken(); // Update the session with the new token
        }
    } else {
        // If no token is found in the session, initiate the authentication flow
        $authUrl = $client->createAuthUrl();
        echo "Open the following link in your browser to authorize the application:\n";
        echo $authUrl;
        exit;
    }

    // Create a Google Drive service
    $driveService = new Google_Service_Drive($client);

    try {
        // Delete the file
        $driveService->files->delete($fileId);
        echo "File deleted successfully.\n";
    } catch (Exception $e) {
        echo "An error occurred: " . $e->getMessage();
    }
}

if(isset($_POST["postId"])){

    $postId = $_POST["postId"];

    if(isset($_POST["files"])){
        $files = $_POST["files"];
    }

    $instrCtrlr = new InstructorController();
    $type = $_POST["type"];

    if($type != "Quiz") $classCode = $_POST["classCode"];


    if($type == "Quiz" || $type == "Exam"){
        echo "inside";
        $instrCtrlr->removeQuiz($postId);
    }else if($type == "Activity"){
        $instrCtrlr->removeActivity($postId);
        if($files != null){
            for($i = 0; $i < count($files); $i++){
                $instrCtrlr->removeFiles($files[$i]);
                deleteFileFromDrive($files[$i]);
            }
        }

    }else if($type == "Seatwork"){
        $instrCtrlr->removeSeatwork($postId);
        if($files != null){
            for($i = 0; $i < count($files); $i++){
                $instrCtrlr->removeFiles($files[$i]);
                 deleteFileFromDrive($files[$i]);
            }
        }
    }else if($type == "Assignment"){
        $instrCtrlr->removeAssignment($postId);
        if($files != null){
            for($i = 0; $i < count($files); $i++){
                $instrCtrlr->removeFiles($files[$i]);
                 deleteFileFromDrive($files[$i]);
            }
        }
    }else{
        $instrCtrlr->removeMaterial($postId);
        if(isset($_POST["files"])){
            for($i = 0; $i < count($files); $i++){
                $instrCtrlr->removeFiles($files[$i]);
                deleteFileFromDrive($files[$i]);
            }       
         }
    }
}
