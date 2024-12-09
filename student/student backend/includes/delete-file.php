<?php
if (session_id() === "") session_start();

if(isset($_GET["code"])){
    require_once("../vendor/autoload.php");
    require_once("../log and reg backend/classes/connection.php");
    require_once("classes/model.Prof.php");
    require_once("classes/controller.Prof.php");
}else{
    require_once("../../../vendor/autoload.php");
    require_once("../../../log and reg backend/classes/connection.php");
    require_once("../../student backend/classes/model.ClassRm.php");
    require_once("../../student backend/classes/controller.Lists.php");
    require_once("../../student backend/classes/controller.Student.php");
}

function deleteFileFromDrive($fileId)
{
    // Path to your credentials.json
    $credentialsPath = '../../../log and reg backend/config/credentials.json';

    // Create a Google client
    $client = new Google_Client();
    $client->setAuthConfig($credentialsPath);
    $client->addScope(Google_Service_Drive::DRIVE);

    // Authenticate the client
    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
        $client->setAccessToken($_SESSION['access_token']);

        // Refresh the token if it has expired
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
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

// Replace 'your-file-id' with the actual file ID of the file you want to delete
$files = $_POST["files"];
echo var_dump($files);
$stdController = new StudentController();

for($i = 0; $i < count($files); $i++){
    $stdController->removeFiles($files[$i]);
    // echo $files[$i];
     deleteFileFromDrive($files[$i]);
}
// $fileId = $_POST["fileId"];
// deleteFileFromDrive($fileId);
?>
