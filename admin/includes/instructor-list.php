<?php 

function displayAllInstructor()
{
    require_once("classes/connection.php");
    require_once("classes/model.Prof.php");
    require_once("classes/controller.Prof.php");
    
    $instController = new InstructorController();
    $instructorList = $instController->getAllProf();

    for ($i = 0; $i < count($instructorList); $i++) {
        echo "<tr><td class='instructor_id'>" . $instructorList[$i]["user_id"] . "</td>";
        echo "<td class='instructor_name'>" . $instructorList[$i]["name"] . "</td>";
        echo "<td class='instructor_email'>" . $instructorList[$i]["email"] . "</td>";
        echo "<td class='instructor_gender'>" . $instructorList[$i]["status"] . "</td>";
        echo "<td><a href='' class='view_instructor_profile'><i class='bi bi-pencil-square green1 me-2 fs-6'></i></a></td></tr>";
    }
}

if(isset($_POST["userId"])){
    require_once("../classes/connection.php");
    require_once("../classes/model.Prof.php");
    require_once("../classes/controller.Prof.php");

    $instController = new InstructorController();
    $listOfClass = $instController->getAllProfClasses();
    //echo $name;
    header('content-type: application/json');
    echo json_encode($listOfClass);
}