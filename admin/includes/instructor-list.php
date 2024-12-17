<?php 

function displayAllInstructor()
{
    if(isset($_POST["updatedProf"])){
        require_once("../classes/connection.php");
        require_once("../classes/model.Prof.php");
        require_once("../classes/controller.Prof.php");
        
    }else{
        require_once("classes/connection.php");
        require_once("classes/model.Prof.php");
        require_once("classes/controller.Prof.php");
    }

    $instController = new InstructorController();
    $instructorList = $instController->getAllProf();

    for ($i = 0; $i < count($instructorList); $i++) {
        $profId = getInstructorIdFormat($instructorList[$i]["user_id"], $instructorList[$i]["created"]);
        echo "<tr><td class='instructor_id' data-label='Instructor Code'>" . $instructorList[$i]["user_id"] . "</td>";
        echo "<td class='instructor_id_text text-break' data-label='Instructor Code'>" . $profId . "</td>";
        echo "<td class='instructor_name text-break' data-label='Instructor Name'>" . $instructorList[$i]["name"] . "</td>";
        echo "<td class='instructor_email text-break' data-label='Email'>" . $instructorList[$i]["email"] . "</td>";
        echo "<td class='instructor_status text-break' data-label='Status'>" . $instructorList[$i]["status"] . "</td>";
        echo "<td data-label='Edit'><a href='' class='view_instructor_profile'><i class='bi bi-pencil-square green1 me-2 fs-6'></i></a></td></tr>";
    }
}

if(isset($_POST["updatedProf"])){
    displayAllInstructor();
}

function getInstructorIdFormat($userId, $created){
    $year = substr($created, 0, 4);

    for($i = strlen($userId); $i < 4; $i++){
        $year .= "0";
    }
    
    $year .= $userId . "-S";
    return $year;
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