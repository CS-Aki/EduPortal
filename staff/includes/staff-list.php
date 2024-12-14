<?php

function displayAllStaff()
{
    require_once("classes/connection.php");
    require_once("classes/model.Staff.php");
    require_once("classes/controller.Staff.php");

    $staffController = new StaffController();
    $staffList = $staffController->getAllStaff();

    for ($i = 0; $i < count($staffList); $i++) {
        $staffId = getStaffIdFormat($staffList[$i]["user_id"], $staffList[$i]["created"]);
        echo "<tr><td class='staff_id'>" . $staffList[$i]["user_id"] . "</td>";
        echo "<td class='staff_id_text'>" . $staffId . "</td>";
        echo "<td class='staff_name'>" . $staffList[$i]["name"] . "</td>";
        echo "<td class='staff_email'>" . $staffList[$i]["email"] . "</td>";
        echo "<td class='staff_status'>" . $staffList[$i]["status"] . "</td>";
        echo "<td><a href='' class='view_staff_profile'><i class='bi bi-pencil-square green1 me-2 fs-6'></i></a></td></tr>";
    }
}

function displayUpdatedStaffList(){
    require_once("../classes/connection.php");
    require_once("../classes/model.Staff.php");
    require_once("../classes/controller.Staff.php");

    $staffController = new StaffController();
    $staffList = $staffController->getAllStaff();

    for ($i = 0; $i < count($staffList); $i++) {
        $staffId = getStaffIdFormat($staffList[$i]["user_id"], $staffList[$i]["created"]);
        echo "<tr><td class='staff_id'>" . $staffList[$i]["user_id"] . "</td>";
        echo "<td class='staff_id_text'>" . $staffId . "</td>";
        echo "<td class='staff_name'>" . $staffList[$i]["name"] . "</td>";
        echo "<td class='staff_email'>" . $staffList[$i]["email"] . "</td>";
        echo "<td class='staff_status'>" . $staffList[$i]["status"] . "</td>";
        echo "<td><a href='' class='view_staff_profile'><i class='bi bi-pencil-square green1 me-2 fs-6'></i></a></td></tr>";
    }
}

if(isset($_POST["updatedStaff"])){
    displayUpdatedStaffList();
}

function getStaffIdFormat($userId, $created){
    $year = substr($created, 0, 4);

    for($i = strlen($userId); $i < 4; $i++){
        $year .= "0";
    }
    
    $year .= $userId . "-S";
    return $year;
}

if(isset($_POST["userId"])){
    require_once("../classes/connection.php");
    require_once("../classes/model.Staff.php");
    require_once("../classes/controller.Staff.php");

    $staffController = new StaffController();
    $staffDetail = $staffController->getStaffDetail();
    header('content-type: application/json');
    echo json_encode($staffDetail);

    // $listOfClass = $stdController->getStudentClasses();
    // $studentDetail = $stdController->getStudentDetail();

    // if($listOfClass != null){
    //     header('content-type: application/json');
    //     // echo json_encode($listOfClass);
    //     echo json_encode([
    //         'listOfClass' => $listOfClass,
    //         'studentDetail' => $studentDetail
    //     ]);
    // }else{
    //     header('content-type: application/json');
    //     echo json_encode($studentDetail);
    // }


}
