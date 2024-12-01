<?php
if (session_id() === "") session_start();
require_once("../../log and reg backend/classes/connection.php");
require_once("../classes/model.Prof.php");
require_once("../classes/controller.Prof.php");

if(isset($_FILES['file']['name'])){
    $instrCtrlr = new InstructorController();
    $directory = "../../profiles/";

    imageAlreadyInFolder($directory, $_SESSION["id"]);  // Checks if user has profile, if yes, delete the image then upload a new one

    $_FILES['file']['name'] = $_SESSION["id"];
    $type = str_replace("image/", ".", $_FILES['file']['type']);
    $_SESSION["profile"] = $_FILES['file']['name'] . "" . $type;

    if(!empty($_FILES['file']['name'])){
        $fileToUpload = $directory.basename("../../". $_FILES['file']['name'] . $type);

        if(move_uploaded_file($_FILES['file']['tmp_name'], $fileToUpload)){
            if($instrCtrlr->updatePicture($_SESSION["id"], $_SESSION["profile"]) == false){
                echo "Error updating picture in database";
            }

            switch($type){
                case ".jpeg":
                    $image = imagecreatefromjpeg($fileToUpload);
                    break;
                case ".jpg":
                    $image = imagecreatefromjpeg($fileToUpload);
                    break;
                case ".png":
                    $image = imagecreatefrompng($fileToUpload);
                   
                    break;
            }
    
            $imgResized = imagescale($image , 702, 702);
    
            switch($type){
                case ".jpeg":
                    imagejpeg($imgResized, $fileToUpload);
                    break;
                case ".jpg":
                    imagejpeg($imgResized, $fileToUpload);
                    break;
                case ".png":
                    imagepng($imgResized, $fileToUpload);
                    break;
            }
            
            echo $_SESSION["profile"];
        }else{
            echo "<script>alert('Failed');</script>";
            unset($_SESSION["profile"]);
        }
    }
}

function imageAlreadyInFolder($filePath, $id){
    $types = array(".png", ".jpg", ".jpeg");
    for($i = 0; $i < count($types); $i++){
        $img = $filePath . "" . $id . "" . $types[$i];
        if(file_exists($img)){
            unlink($img);
        }
    }
  
}