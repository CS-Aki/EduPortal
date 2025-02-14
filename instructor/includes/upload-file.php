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
    require_once("../log and reg backend/classes/connection.php");
    require_once("classes/model.Prof.php");
    require_once("classes/controller.Prof.php");
}else{
    require_once("../../vendor/autoload.php");
    require_once("../../log and reg backend/classes/connection.php");
    require_once("../classes/model.Prof.php");
    require_once("../classes/controller.Prof.php");
}

session_start();

$jsonFile = '../../log and reg backend/config/credentials.json';

try {
    if (!file_exists($jsonFile)) {
        throw new Exception("File not found: $jsonFile");
    }
    
    $jsonData = file_get_contents($jsonFile);

    // Decode the JSON file into an associative array
    $data = json_decode($jsonData, true);

    // Check for errors during decoding
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Error decoding JSON: " . json_last_error_msg());
    }
    // Check if the 'client_id' key exists
    if (isset($data['web']['client_id'])) {
        echo "client_id found: " . $data['web']['client_id'] . PHP_EOL;
    } elseif (isset($data['client_id'])) {
        echo "client_id found: " . $data['client_id'] . PHP_EOL;
    } else {
        echo "client_id not found in the JSON file." . PHP_EOL;
        var_dump($data);
    }
} catch (Exception $e) {
    // Handle any exceptions
    echo "Error: " . $e->getMessage() . PHP_EOL;
}


$client = new Google_Client();
// If we have an access token, proceed with file handling or whatever your logic is
$client->setAccessToken($_SESSION['access_token']);

// Check if the access token is expired and refresh it
if ($client->isAccessTokenExpired()) {
    $refreshToken = $client->getRefreshToken();
    $client->fetchAccessTokenWithRefreshToken($_SESSION["refresh_token"]);
    $_SESSION['access_token'] = $client->getAccessToken();
}

if(isset($_POST["classCode"])){
    $_SESSION["classCode"] = $_POST["classCode"];
    $_SESSION["storedFile"] = $_FILES['files'];
}
// Create Google Drive service
$service = new Google_Service_Drive($client);
// echo "RANDOM HERE";
// echo $_SESSION["postId"]["post_id"] . "\n\n\n\n";
// echo var_dump($_SESSION["postId"]) . "\n\n\n\n";

echo $_SESSION["postId"];

if ($_SESSION['access_token']) {
    $_SESSION["tmp"] = "<div class='alert alert-success' role='alert'><span>POST SUCCESS</span></div>";
    $postId = $_SESSION["postId"];
    $files = $_SESSION["storedFile"];
    // echo var_dump($files); 
    $uploadedFiles = [];
    $fileSizes = [];
    $folderName = "EduPortal";

    foreach ($files['error'] as $index => $error) {
        if ($error !== UPLOAD_ERR_OK) {
            echo "Error uploading file {$files['name'][$index]}: Error code $error\n\n";
        }else{
            echo "No error\n\n";
        }
    }

    echo "CHANGES\n\n\n";
    echo var_dump($files['tmp_name']);
    // echo "TEMP HERE " . $files[0]['tmp_name'];
    // Loop through each file in the uploaded files array
    foreach ($files['tmp_name'] as $index => $tmp_name) {
        $destination = '../uploads/' . basename($files['name'][$index]);
        // echo "<br>Destination for file {$files['name'][$index]}: " . $destination;

        if (!file_exists($tmp_name)) {
            echo "\n\nTemporary file {$tmp_name} does not exist.\n";
            continue;
        }else{echo "\nTEMP FILE EXIST\n";}
        

        if (!is_writable('../uploads/')) {
            echo "\nUploads folder is not writable.<br>";
            continue;
        }

        $fileSizeBytes = $files['size'][$index]; // File size in bytes
        $size = 0;
        $word = "";
        // Determine whether the file size is in MB or KB
        if (strlen((string)$fileSizeBytes) >= 7) {
            $size = ceil(($fileSizeBytes / (1024 * 1024))); // Convert to MB
            $word = "MB";
        } else {
            $size = ceil(($fileSizeBytes / 1024)); // Convert to KB
            $word = "KB";
        }

        $fileSizes[] = $size . " {$word}";
        // echo "\n\n\nOLCATION ".realpath('../uploads/') . "\n\n\n";
        // if(file_exists("../uploads")){
        //     echo "\n\nFOUND\n\n";
        // }else{
        //     echo "\n\NOT FOUND\n\n";
        // }
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
                    $fileNames[] = $files['name'][$index];

                    echo "File {$files['name'][$index]} uploaded to Google Drive successfully. File ID: " . $file->id . "<br>";

                    // Clean up temporary file
                    if (file_exists($destination)) {
                        unlink($destination);
                        echo "Temporary file {$files['name'][$index]} deleted from server.<br>";
                    }
                } catch (Exception $e) {
                    echo "Error uploading file {$files['name'][$index]} to Google Drive: " . $e->getMessage() . "<br>";
                    header("Location : ../../includes/auth.php");
                    exit();
                }
            } else {
                echo "File {$files['name'][$index]} does not exist at $destination. Cannot proceed with Google Drive upload.<br>";
            }
        } else {
            echo "Failed to move file {$files['name'][$index]}.<br>";
        }
    }

    unset($_SESSION["storedFile"]);
 
    $instrCtrlr = new InstructorController();
    // echo "POST ID : " . $_SESSION["postId"];
    // Provide feedback to the user
    if (count($uploadedFiles) > 0) {
        echo "Files uploaded successfully!<br>";
        $i = 0;
        foreach ($uploadedFiles as $fileId) {
            // echo "POST ID " . $_SESSION["postId"][0]["post_id"] . "\n";
            // echo "CLASS CODE " . $_SESSION["storeCode"] . "\n";
            // echo "FILE NAME " . $fileNames[$i]. "\n";
            // echo "FILE ID " . htmlspecialchars($fileId). "\n";

            $instrCtrlr->uploadGdriveData($_SESSION["postId"], $_SESSION["storeCode"], $fileNames[$i], htmlspecialchars($fileId), $fileSizes[$i], $_SESSION["id"]);
            $i++;
            // echo "File ID: " . htmlspecialchars($fileId) . "<br>";
        }
        unset($_SESSION["postId"]);
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