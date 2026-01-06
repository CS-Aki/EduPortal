<?php 

// if(isset($_GET["temp"])){
//     require_once("../../../log and reg backend/classes/connection.php");
//     require_once("../classes/model.ClassRm.php");
//     require_once("../classes/controller.Lists.php");
//     require_once("../classes/controller.Student.php");
// }else{
//     require_once("../log and reg backend/classes/connection.php");
//     require_once("student backend/classes/model.ClassRm.php");
//     require_once("student backend/classes/controller.Lists.php");
//     require_once("student backend/classes/controller.Student.php");
// }


if(isset($_GET["post"])){

    if(isset($_GET["temp"])){
        require_once("../../log and reg backend/classes/connection.php");
        require_once("../classes/model.Prof.php");
        require_once("../classes/controller.Prof.php");
    }else{
        require_once("../log and reg backend/classes/connection.php");
        require_once("classes/model.Prof.php");
        require_once("classes/controller.Prof.php");
    }
    
    if (session_id() === "") session_start();   
    
    $postID =  $_GET["post"];
    $instrCtrlr = new InstructorController();

    // sleep(5);
    // $stdController = new StudentController();
    if(isset($_GET["code"])) $classCode = $_GET["code"];
    else $classCode = $_GET["class"];

    $postDetails = $instrCtrlr->getPostDetails($postID, $classCode);
    $comments = $instrCtrlr->getComments($postID, $classCode);
    $files = $instrCtrlr->getFiles($postID, $classCode);
    $startingDateTime = null;
    $deadlineDateTime = null;

    // if(isset($comments[0]["month"])){
        $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $year = $postDetails[0]["month"][0] . "" . $postDetails[0]["month"][1] . $postDetails[0]["month"][2] . "" . $postDetails[0]["month"][3];
        $month = $months[(int)($postDetails[0]["month"][5] . $postDetails[0]["month"][6]) - 1];
        $day = $postDetails[0]["month"][8] . "" . $postDetails[0]["month"][9];

    //  }else{
    //     $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    //     $year = $postDetails[0]["month"][0] . "" . $postDetails[0]["month"][1] . $postDetails[0]["month"][2] . "" . $postDetails[0]["month"][3];
    //     $month = $months[$postDetails[0]["month"][5] . "" . $postDetails[0]["month"][6] - 1];
    //     $day = $postDetails[0]["month"][8] . "" . $postDetails[0]["month"][9];
    //  }

    if(isset($_GET["temp"])){
        // $comments[count($comments) - 1]["id"] = $_SESSION["id"];
        header('content-type: application/json');
        echo json_encode($comments);
    }

    // echo var_dump($comments);
}


if(isset($_POST["fromEdit"])){
    require_once("../../log and reg backend/classes/connection.php");
    require_once("../classes/model.Prof.php");
    require_once("../classes/controller.Prof.php");
    $instrCtrlr = new InstructorController();
    $postId = $_POST["postId"];
    $classCode = $_POST["classCode"];
    $file = $instrCtrlr->getFiles($postId, $classCode);
    // echo "\n\n\n" .$postId . "\n\n\n";
    // echo $classCode . "\n\n\n";
    // echo var_dump($file);
    header('content-type: application/json');
    echo json_encode($file);
}