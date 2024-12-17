<?php 

if (session_id() === "") session_start();


if(isset($_GET["code"])){
    require_once("../vendor/autoload.php");
}else{
    require_once("../../vendor/autoload.php");
}

$client = new Google_Client();
$client->setAccessType('offline'); // Request offline access
$client->setPrompt('consent'); 

if(isset($_GET["code"])){
    $client->setAuthConfig('../log and reg backend/config/credentials.json');
}else{
    $client->setAuthConfig('../../log and reg backend/config/credentials.json');
}

// if(isset($_POST["classCode"])){
//     $_SESSION["classCode"] = $_POST["classCode"];
//     $_SESSION["storedFile"] = $_FILES['files'];
// }

$client->addScope(Google_Service_Drive::DRIVE_FILE);

$client->setRedirectUri('https://cs-devops.com/EduPortal/instructor/material.php');

// Check if we have an authorization code in the query string
if (isset($_GET['code'])) {
    // Fetch the access token using the authorization code
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $token;
    $_SESSION["refresh_token"] = $token["refresh_token"];
    echo "test<br><br>";
    echo var_dump($token);
    // $_SESSION["classCode"] = $_POST["classCode"];
    // $_SESSION["storedFile"] = $_FILES['files'];
    
    // Redirect back to the page to ensure everything is set
    echo "<br><br>". $_SESSION["codeTemp"];
    echo $_SESSION["postTemp"];
    header('location: https://cs-devops.com/EduPortal/instructor/material.php?class='.$_SESSION["codeTemp"].'&post='.$_SESSION["postTemp"]);
    exit;
}

if (!isset($_SESSION['access_token'])) {
    // Redirect to the Google authentication page if no access token or it's expired
    $authUrl = $client->createAuthUrl();
    // if(isset($_POST["classCode"])){
    //     $_SESSION["classCode"] = $_POST["classCode"];
    //     $_SESSION["storedFile"] = $_FILES['files'];
    // }
    // echo $authUrl;
    // echo var_dump($authUrl);
    header("location: " .$authUrl);
    // echo json_encode(['authUrl' => $authUrl]);
    exit();
}
