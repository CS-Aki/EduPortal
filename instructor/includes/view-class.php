<?php 

// if(isset($_POST["newClass"])){
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

require_once("../log and reg backend/classes/connection.php");
require_once("classes/model.Prof.php");
require_once("classes/controller.Prof.php");

if(isset($_GET["class"])){
    $classCode = $_GET["class"];

    // $classCode = str_replace("Class Code: ", "", $_GET["class"]);
    // $stdController = new StudentController();
    $instrCtrlr = new InstructorController();
    // $classList = $instrCtrlr->getProfClass();
    
    $details = $instrCtrlr->classDetails($classCode);
    $post = $instrCtrlr->postDetails($details[0]["class_code"]);
    // echo var_dump($details);
    // echo var_dump($post);
    // $post = $stdController->getClassDetails($details[0]["class_code"]);
    if(isset($post[0]["month"])){
        $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $year = $post[0]["month"][0] . "" . $post[0]["month"][1] . $post[0]["month"][2] . "" . $post[0]["month"][3];
        $month = $months[$post[0]["month"][5] . "" . $post[0]["month"][6] - 1];
        $day = $post[0]["month"][8] . "" . $post[0]["month"][9];
    }


    $currentDate = date("F j, Y");
        // $today = $currentDate->format("m-d-Y");

    // echo $month;
    // echo "<br>DATE " . $post[0]["month"];
    // echo "<br>Year " . $year;
    // echo var_dump($post);
 
    // echo "<br>";
    // echo var_dump($details);
}