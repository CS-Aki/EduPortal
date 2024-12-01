<?php

if(isset($_POST["displayClass"])){
    updatedClassDetails();
}

function displayClassList(){
    require_once("classes/connection.php");
    require_once("classes/model.ClassRm.php");
    require_once("classes/controller.ClassRm.php");
    require_once("classes/controller.Lists.php");

    $listController = new ListController();
    $listOfClasses = $listController->getAllClass();
    // header('content-type: application/json');
    // echo json_encode($listOfClasses);

    for ($i = 0; $i < count($listOfClasses); $i++) {
        echo "<tr><td class='class_code'>" . $listOfClasses[$i]["class_code"] . "</td>";
        echo "<td class='class_name'>" . $listOfClasses[$i]["class_name"] . "</td>";
        echo "<td class='class_teacher'>" . $listOfClasses[$i]["class_teacher"] . "</td>";
        echo "<td class='class_schedule'>" . $listOfClasses[$i]["class_schedule"] . "</td>";
        echo "<td class = 'class_status'>" . $listOfClasses[$i]["class_status"] . "</td>";
        echo "<td><a href='' class='view_class'><i class='bi bi-pencil-square green1 me-2 fs-6'></i></a></td></tr>";
        // echo "<td><a href='#' class='btn btn-success btn-sm view_class'>View Class</a></td></tr>";
        // <a href=""><i class="bi bi-eye green1 fs-6"></i></a>
    } 
}

function updatedClassDetails(){
    require_once("../classes/connection.php");
    require_once("../classes/model.ClassRm.php");
    require_once("../classes/controller.ClassRm.php");
    require_once("../classes/controller.Lists.php");

    $listController = new ListController();
    $listOfClasses = $listController->getAllClass();
    header('content-type: application/json');
    echo json_encode($listOfClasses);

}

// Retrieves the student list for the modal
if(isset($_POST["classCode"])){
    // echo "testing";
    require_once("../classes/connection.php");
    require_once("../classes/model.ClassRm.php");
    require_once("../classes/controller.ClassRm.php");
    require_once("../classes/controller.Lists.php");

    $classCode = $_POST["classCode"];
    $listController = new ListController();
    $class = $listController->getClassFromCode($classCode);
    $classDetail = $listController->getStdFromClass($classCode);
    
    // echo var_dump($classDetail);
    if($classDetail != null){
        header('content-type: application/json');
        echo json_encode([
            'class' => $class,
            'classDetail' => $classDetail
        ]);
    }else{
        header('Content-Type: application/json');
        echo json_encode([
            'class' => $class,
            'noStudent' => 'No Students'
        ]);
    }
}



   