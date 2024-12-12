<?php 

if (session_id() === "") session_start();

if(isset($_GET["code"])){
    require_once("../vendor/autoload.php");
}else{
    require_once("../vendor/autoload.php");
}
$client = new Google_Client();
$client->setAccessType('offline'); // Request offline access
$client->setPrompt('consent'); 
if(isset($_GET["code"])){
    $client->setAuthConfig('../log and reg backend/config/credentials.json');
}else{
    $client->setAuthConfig('../log and reg backend/config/credentials.json');
}
// if(isset($_POST["classCode"])){
//     $_SESSION["classCode"] = $_POST["classCode"];
//     $_SESSION["storedFile"] = $_FILES['files'];
// }

$client->addScope(Google_Service_Drive::DRIVE_FILE);
$client->setRedirectUri('http://localhost/EduPortal/instructor/post-form.php');

// Check if we have an authorization code in the query string
if (isset($_GET['code'])) {
    // Fetch the access token using the authorization code
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $token;
    $_SESSION["refresh_token"] = $token["refresh_token"];
    echo var_dump( $token);
    // $_SESSION["classCode"] = $_POST["classCode"];
    // $_SESSION["storedFile"] = $_FILES['files'];
    
    // Redirect back to the page to ensure everything is set
    header('Location: http://localhost/EduPortal/instructor/post-form.php?class='.$_SESSION["storeCode"]);
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
    header("location: " .$authUrl);
    // echo json_encode(['authUrl' => $authUrl]);
    exit();
}
