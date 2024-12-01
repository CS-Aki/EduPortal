<?php

$instrCtrlr = new InstructorController();
$classList = $instrCtrlr->getProfClass();

// echo $classList[0]["user_id"];

for($i = 0 ; $i < count($classList); $i++){
    echo "<div class='col-lg-3 col-md-4 mb-3'>";
    echo "<a href='#' class='dislay-class'>";
    echo "<div class='card shadow-elevation-light-3' style='width: 18rem; border-radius: 20px;'>";
    echo "<div class='card-img-top' style='height: 100px; background-color: var(--green1); border-radius: 20px 20px 0 0;'></div> ";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title i-font black2 mb-0' class-name>{$classList[$i]['class_name']}</h5>";
    echo "<h6 class='card-text black3 class-sched'>{$classList[$i]['class_schedule']}</h6>";
    echo "<h6 class='card-text black3 class-teacher'>Instructor: {$classList[$i]['class_teacher']}</h6>";
    // echo "<span></span>";
    echo "<h6 class='card-text black3 class-code'>Class Code: {$classList[$i]['class_code']}</h6>";
    echo "</div>";
    echo "</div>";
    echo "</a>";
    echo "</div>"; 
}