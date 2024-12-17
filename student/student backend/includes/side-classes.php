<?php 
if (session_id() === "") session_start();

if(isset($_POST["newClass"])){
    require_once("../../../log and reg backend/classes/connection.php");
    require_once("../classes/model.ClassRm.php");
    require_once("../classes/controller.Lists.php");
    require_once("../classes/controller.Student.php");
}else{
    require_once("../log and reg backend/classes/connection.php");
    require_once("student backend/classes/model.ClassRm.php");
    require_once("student backend/classes/controller.Lists.php");
    require_once("student backend/classes/controller.Student.php");
}

$list = new ListController();
$classList = $list->getAllClass($_SESSION["id"]);

// echo $classList[0]['class_name'];

?>


<!-- <div class="class">
    <a href="" class="fs-5 text-truncate d-inline-block py-lg-1" style="max-width: 100%;">
        <i class="ms-3 bi bi-book me-2 greenicon"></i>Algorithm
    </a>
</div> -->