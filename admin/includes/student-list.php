<?php

function displayAllStudent()
{
    if(isset($_POST["updatedStudent"])){
        require_once("../classes/connection.php");
        require_once("../classes/model.ClassRm.php");
        require_once("../classes/model.Student.php");
        require_once("../classes/controller.ClassRm.php");
        require_once("../classes/controller.Student.php");
    }else{
        require_once("classes/connection.php");
        require_once("classes/model.ClassRm.php");
        require_once("classes/model.Student.php");
        require_once("classes/controller.ClassRm.php");
        require_once("classes/controller.Student.php");
    }

    $stdController = new StudentController();
    $studentList = $stdController->getAllStudents();

    for ($i = 0; $i < count($studentList); $i++) {
        $profId = getStudentIdFormat($studentList[$i]["user_id"], $studentList[$i]["created"]);
        echo "<tr><td class='student_id text-break'>" . $studentList[$i]["user_id"] . "</td>";
        echo "<td class='student_id_text text-break'>" . $profId . "</td>";
        echo "<td class='student_name text-break'>" . $studentList[$i]["name"] . "</td>";
        echo "<td class='student_status text-break'>" . $studentList[$i]["status"] . "</td>";
        echo "<td class='student_email text-break'>" . $studentList[$i]["email"] . "</td>";
        echo "<td><a href='' class='view_student_profile'><i class='bi bi-pencil-square green1 me-2 fs-6'></i></a></td></tr>";
    }
}

if(isset($_POST["updatedStudent"])){
    displayAllStudent();
}

function getStudentIdFormat($userId, $created){
    $year = substr($created, 0, 4);

    for($i = strlen($userId); $i < 4; $i++){
        $year .= "0";
    }
    
    $year .= $userId . "-S";
    return $year;
}


if(isset($_POST["userId"])){
    require_once("../classes/connection.php");
    require_once("../classes/model.Student.php");
    require_once("../classes/controller.Student.php");

    $stdController = new StudentController();
    $listOfClass = $stdController->getStudentClasses();
    $studentDetail = $stdController->getStudentDetail();

    if($listOfClass != null){
        header('content-type: application/json');
        // echo json_encode($listOfClass);
        echo json_encode([
            'listOfClass' => $listOfClass,
            'studentDetail' => $studentDetail
        ]);
    }else{
        header('content-type: application/json');
        echo json_encode($studentDetail);
    }


}