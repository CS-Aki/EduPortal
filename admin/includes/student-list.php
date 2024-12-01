<?php

function displayAllStudent()
{
    require_once("classes/connection.php");
    require_once("classes/model.ClassRm.php");
    require_once("classes/model.Student.php");
    require_once("classes/controller.ClassRm.php");
    require_once("classes/controller.Student.php");

    $stdController = new StudentController();
    $studentList = $stdController->getAllStudents();

    for ($i = 0; $i < count($studentList); $i++) {
        echo "<tr><td class='student_id'>" . $studentList[$i]["user_id"] . "</td>";
        echo "<td class='student_name'>" . $studentList[$i]["name"] . "</td>";
        echo "<td class='student_gender'>" . $studentList[$i]["gender"] . "</td>";
        echo "<td class='student_email'>" . $studentList[$i]["email"] . "</td>";
        echo "<td><a href='' class='view_student_profile'><i class='bi bi-pencil-square green1 me-2 fs-6'></i></a></td></tr>";
    }

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

    // $listOfClass = $studentList->getAllProfClasses();
    // //echo $name;
    // header('content-type: application/json');
    // echo json_encode($listOfClass);
}