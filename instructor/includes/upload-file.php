<?php 

// require_once("../classes/gdrive.php");
// require_once("../../log and reg backend/config/config.php");
header("Access-Control-Allow-Origin: *"); // Allows requests from all origins, change '*' to your specific domain if needed
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow these HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With"); // Allow these headers
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // If it's a preflight request, respond with a 200 status and allow the cross-origin request
    http_response_code(200);
    exit();
}

if(isset($_GET["code"])){
    require_once("../vendor/autoload.php");
}else{
    require_once("../../vendor/autoload.php");
}

session_start();

// if (!isset($_SESSION['access_token'])) {
//     header('Location: auth.php'); // Redirect to authentication
//     exit();
// }

// $client = new Google_Client();
// if(isset($_GET["code"])){
//     $client->setAuthConfig('../log and reg backend/config/credentials.json');
// }else{
//     $client->setAuthConfig('../../log and reg backend/config/credentials.json');
// }
// // if(isset($_POST["classCode"])){
// //     $_SESSION["classCode"] = $_POST["classCode"];
// //     $_SESSION["storedFile"] = $_FILES['files'];
// // }

// $client->addScope(Google_Service_Drive::DRIVE_FILE);
// $client->setRedirectUri('http://localhost/EduPortal/instructor/post-form.php');

// // Check if we have an authorization code in the query string
// if (isset($_GET['code'])) {
//     // Fetch the access token using the authorization code
//     $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
//     $_SESSION['access_token'] = $token;

//     // $_SESSION["classCode"] = $_POST["classCode"];
//     // $_SESSION["storedFile"] = $_FILES['files'];
    
//     // Redirect back to the page to ensure everything is set
//     header('Location: http://localhost/EduPortal/instructor/includes/upload-file.php');
//     exit;
// }

// if (!isset($_SESSION['access_token'])) {
//     // Redirect to the Google authentication page if no access token or it's expired
//     $authUrl = $client->createAuthUrl();
//     // if(isset($_POST["classCode"])){
//     //     $_SESSION["classCode"] = $_POST["classCode"];
//     //     $_SESSION["storedFile"] = $_FILES['files'];
//     // }
//     echo $authUrl;
//     echo json_encode(['authUrl' => $authUrl]);
//     exit();
// }

// If there's no access token, or it has expired, we need to redirect to Google OAuth
// if (!isset($_SESSION['access_token']) || $client->isAccessTokenExpired()) {
//     // Redirect the user to Google's OAuth 2.0 consent screen
//     $authUrl = $client->createAuthUrl();
//     header("Location: " . $authUrl);
//     exit;
// }
echo "test";
$client = new Google_Client();
// If we have an access token, proceed with file handling or whatever your logic is
$client->setAccessToken($_SESSION['access_token']);

// Check if the access token is expired and refresh it
if ($client->isAccessTokenExpired()) {
    $refreshToken = $client->getRefreshToken();
    $client->fetchAccessTokenWithRefreshToken($refreshToken);
    $_SESSION['access_token'] = $client->getAccessToken();
}

if(isset($_POST["classCode"])){
    $_SESSION["classCode"] = $_POST["classCode"];
    $_SESSION["storedFile"] = $_FILES['files'];
}
// Create Google Drive service
$service = new Google_Service_Drive($client);

if ($_SESSION['access_token']) {
    $_SESSION["tmp"] = "<div class='alert alert-success' role='alert'><span>POST SUCCESS</span></div>";

    $files = $_SESSION["storedFile"];
    echo var_dump($files); // Debugging line to inspect the uploaded files
    $uploadedFiles = [];
    $folderName = "EduPortal";

    // Loop through each file in the uploaded files array
    foreach ($files['tmp_name'] as $index => $tmp_name) {
        $destination = '../uploads/' . basename($files['name'][$index]);
        echo "<br>Destination for file {$files['name'][$index]}: " . $destination;

        // Move the uploaded file to the server
        if (move_uploaded_file($tmp_name, $destination)) {
            echo "File {$files['name'][$index]} moved to $destination<br>";

            // Check if file exists after moving
            if (file_exists($destination)) {
                echo "File {$files['name'][$index]} exists at $destination. Ready to upload to Google Drive.<br>";

                // Initialize Google Drive API service (assuming $service is already initialized)
                try {
                    // Check if the folder exists or create it
                    $query = "mimeType='application/vnd.google-apps.folder' and name='$folderName' and trashed=false";
                    $response = $service->files->listFiles([ 
                        'q' => $query,
                        'fields' => 'files(id, name)',
                    ]);

                    $folderId = null;
                    if (count($response->files) > 0) {
                        // Folder exists, get its ID
                        $folderId = $response->files[0]->id;
                        echo "Folder '$folderName' already exists with ID: $folderId<br>";
                    } else {
                        // Folder doesn't exist, create it
                        $folderMetadata = new Google_Service_Drive_DriveFile([
                            'name' => $folderName,
                            'mimeType' => 'application/vnd.google-apps.folder',
                        ]);

                        $folder = $service->files->create($folderMetadata, [
                            'fields' => 'id',
                        ]);
                        $folderId = $folder->id;
                        echo "Folder '$folderName' created with ID: $folderId<br>";
                    }

                    // Prepare file metadata
                    $fileMetadata = new Google_Service_Drive_DriveFile([
                        'name' => basename($destination), // Use the file name
                        'parents' => [$folderId],         // Set parent folder ID
                    ]);

                    // Detect MIME type
                    $mime_type = mime_content_type($destination);
                    if (pathinfo($files['name'][$index], PATHINFO_EXTENSION) === 'css') {
                        $mime_type = 'text/css';
                    }

                    // Read the file content
                    $fileContent = file_get_contents($destination);

                    // Upload the file to Google Drive
                    $file = $service->files->create($fileMetadata, [
                        'data' => $fileContent,
                        'mimeType' => $mime_type,
                        'uploadType' => 'multipart',
                        'fields' => 'id',
                    ]);

                    // Change file permissions to public
                    $permission = new Google_Service_Drive_Permission([
                        'type' => 'anyone',
                        'role' => 'reader',
                    ]);
                    $service->permissions->create($file->id, $permission);

                    $uploadedFiles[] = $file->id;

                    echo "File {$files['name'][$index]} uploaded to Google Drive successfully. File ID: " . $file->id . "<br>";

                    // Clean up temporary file
                    if (file_exists($destination)) {
                        unlink($destination);
                        echo "Temporary file {$files['name'][$index]} deleted from server.<br>";
                    }

                } catch (Exception $e) {
                    echo "Error uploading file {$files['name'][$index]} to Google Drive: " . $e->getMessage() . "<br>";
                }
            } else {
                echo "File {$files['name'][$index]} does not exist at $destination. Cannot proceed with Google Drive upload.<br>";
            }
        } else {
            echo "Failed to move file {$files['name'][$index]}.<br>";
        }
    }

    unset($_SESSION["storedFile"]);
    // Provide feedback to the user
    if (count($uploadedFiles) > 0) {
        echo "Files uploaded successfully!<br>";
        foreach ($uploadedFiles as $fileId) {
            echo "File ID: " . htmlspecialchars($fileId) . "<br>";
        }
        // Redirect or exit
        // header("location: ../post-form.php?class=" . $_SESSION["tmp"]);
        exit();
    } else {
        echo "No files were uploaded to Google Drive.<br>";
    }
} else {
    echo "No files were selected.<br>";
}

// Handle file uploads

// if (isset($_SESSION["classCode"]) && isset($_SESSION["storedFile"])) {

//     $_SESSION["tmp"] = "<div class='alert alert-success' role='alert'><span>POST SUCCESS</span></div>";
//     // $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
//     // $_SESSION['access_token'] = "testing";

//     $files = $_SESSION["storedFile"];
//     $uploadedFiles = [];
//     $folderName = "EduPortal";
//     for ($i = 0; $i < count($files['name']); $i++) {
//         try {
//             // Check if the folder exists or create it
//             $query = "mimeType='application/vnd.google-apps.folder' and name='$folderName' and trashed=false";
//             $response = $service->files->listFiles(array(
//                 'q' => $query,
//                 'fields' => 'files(id, name)',
//             ));
        
//             $folderId = null;
//             if (count($response->files) > 0) {
//                 // Folder exists, get its ID
//                 $folderId = $response->files[0]->id;
//                 echo "Folder '$folderName' already exists with ID: $folderId<br>";
//             } else {
//                 // Folder doesn't exist, create it
//                 $folderMetadata = new Google_Service_Drive_DriveFile(array(
//                     'name' => $folderName,
//                     'mimeType' => 'application/vnd.google-apps.folder',
//                 ));
        
//                 $folder = $service->files->create($folderMetadata, array(
//                     'fields' => 'id',
//                 ));
//                 $folderId = $folder->id;
//                 echo "Folder '$folderName' created with ID: $folderId<br>";
//             }
        
//             // Check if the file exists and is a valid uploaded file
//             if (is_uploaded_file($files['tmp_name'][$i]) && file_exists($files['tmp_name'][$i])) {
//                 $fileMetadata = new Google_Service_Drive_DriveFile(array(
//                     'name' => $files['name'][$i],
//                     'parents' => array($folderId),
//                 ));
        
//                 // Read the content safely
//                 $content = file_get_contents($files['tmp_name'][$i]);
        
//                 // Upload to Google Drive
//                 $file = $service->files->create($fileMetadata, array(
//                     'data' => $content,
//                     'mimeType' => $files['type'][$i],
//                     'uploadType' => 'multipart',
//                     'fields' => 'id'
//                 ));
        
//                 // Change file permission to public
//                 $permission = new Google_Service_Drive_Permission();
//                 $permission->setType('anyone');
//                 $permission->setRole('reader');
//                 $service->permissions->create($file->id, $permission);
        
//                 $uploadedFiles[] = $file->id;
//             } else {
//                 // Handle missing or invalid files
//                 echo "Invalid file: " . htmlspecialchars($files['name'][$i]) . "<br>";
//             }
//         } catch (Exception $e) {
//             // Log or display the error (optional)
//             echo "Error uploading file: " . htmlspecialchars($files['name'][$i]) . " - " . $e->getMessage() . "<br>";
//         }
//     }
//     // Provide feedback to the user
//     if (count($uploadedFiles) > 0) {
    
//         header("location: ../post-form.php?class=" . $_POST["classCode"]);
//         exit();
//         echo "Files uploaded successfully!<br>";
//         foreach ($uploadedFiles as $fileId) {
//             echo "File ID: " . htmlspecialchars($fileId) . "<br>";
//         }
//     } else {
//         echo "No files were uploaded.";
//     }
// } else {
//     echo "No files were selected";
// }

// if (isset($_POST["classCode"])) {
//     require_once("../../log and reg backend/config/config.php");
//     $classCode = $_POST["classCode"];
//     // echo "Class Code: " . $classCode . "\n";

//     if (isset($_FILES['files'])) {
//         foreach ($_FILES['files']['name'] as $key => $name) {
//             $tmpName = $_FILES['files']['tmp_name'][$key];
//             $uploadDir = "../uploads/";
//             $uploadFile = $uploadDir . basename($name);

//             if (move_uploaded_file($tmpName, $uploadFile)) {
//                 // echo "File uploaded: " . $name . "\n";
//                 header("Location: " . $googleOauthURL);
//             } else {
//                 echo "Failed to upload file: " . $name . "\n";
//             }
//         }
//     } else {
//         echo "No files uploaded.";
//     }
// } else {
//     echo "classCode is not set.";
// }

// if(isset($_GET['code'])){ 
//     echo "<br>We have code";
//     $GoogleDriveApi = new GoogleDriveApi(); 
// }


// if(isset($_POST["type"])){
//     require_once("../../vendor/autoload.php");
// }else{
//     require_once("../vendor/autoload.php");
// }

// if(isset($_POST["type"])){
//     require_once("../classes/gdrive.php");
// }else{
//     require_once("classes/gdrive.php");
// }

// $drive = new Gdrive();

// $clientId = $drive->getClientId();
// $clientSecret = $drive->getClientSecret();
// $redirectUrl = $drive->getRedirectUrl();


// if (session_id() === "") session_start();

// $client = new Google_Client();

// $client->setApplicationName("EduPortal");
// $client->setClientId($clientId);
// $client->setClientSecret($clientSecret);
// $client->setRedirectUri($redirectUrl);

// $client->setScopes(array("https://www.googleapis.com/auth/drive.file"));

// $client->setAccessType("offline");
// $client->setApprovalPrompt("force");

// if(isset($_GET["code"])){
//     $client->fetchAccessTokenWithAuthCode($_GET['code']);
//     $_SESSION["token"] = $client->getAccessToken();

//     // if (isset($_GET['state']) && isset($_GET['code'])) {
//     //     $stateData = json_decode($_GET['state'], true); // Decode JSON
//     //     $class = $stateData['class'] ?? null;

//     //     // $codeData = json_decode($_GET['code'], true);
//     //     $code = $_GET['code'] ?? null;
//     //     if ($class) {
//     //         header("Location: http://localhost/EduPortal/instructor/post-form.php?class=$class&code=$code");
//     //         return;
//     //     }
//     // }
//     // $redirect = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"];

// }

// if(isset($_SESSION["token"])){
//     $client->setAccessToken($_SESSION["token"]);
// }


// if(isset($_FILES["uploadedFile"])){
//     $file = $_FILES["uploadedFile"];
//     if($file["error"] === UPLOAD_ERR_OK){
//         $uploadDirectory = "uploads/";
//         $uploadPath = $uploadDirectory . basename($file["name"]);
        
//         if(move_uploaded_file($file["tmp_name"], $uploadPath)){
//             $gdrive = neW Gdrive();
//             $gdrive->fileRequest = $uploadPath;
//             $gdrive->initialize();
//         }
//     }
// }

?>