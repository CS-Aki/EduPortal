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
for($i = 0 ; $i < count($classList); $i++){
    echo "<div class='col-lg-3 col-md-4 mb-3'>";
    ?> <a href='class.php?class=<?php echo md5($classList[$i]['class_code']);?>'class='dislay-class'>
    <?php
    echo "<div class='card shadow-elevation-light-3' style='width: 18rem; border-radius: 20px;'>";
    echo "<div class='card-img-top' style='height: 100px; background-color: var(--green1); border-radius: 20px 20px 0 0;'></div> ";
    echo "<div class='card-body' style='height: 9em;'>";
    echo "<h5 class='card-title i-font black2 mb-0 class-name'>{$classList[$i]['class_name']}</h5>";
    echo "<h6 class='card-text black3 class-sched'>{$classList[$i]['class_schedule']}</h6>";
    echo "<h6 class='card-text black3 class-instructor'>Instructor: {$classList[$i]['class_teacher']}</h6>";
    echo "<h6 class='card-text black3 class-code'>Class Code: {$classList[$i]['class_code']}</h6>";
    echo "</div>";
    echo "</div>";
    echo "</a>";
    echo "</div>";
}
?>



