<?php
$controller = new ListController();

if (isset($_POST["searchClassCodeBtn"])) {
    $result = $controller->getClassFromCode();
    $_SESSION["searchSwitch"] = "1";
    $_SESSION["user"] = $result;
}

if (isset($_POST["searchClassBtn"])) {
    $result = $controller->getClassFromCName();
    $_SESSION["searchSwitch"] = "2";
    $_SESSION["user"] = $result;
}

if (isset($_POST["searchClassInsBtn"])) {
    // $result = $_POST["search_value"];
    // echo $result;
    
    if (empty($_POST['searchClassIns'])) {
        header("Location: admin-dashboard.php?adminBtn=Update Class");
        exit();
    }

    $result = $controller->getClassFromIns();
    $_SESSION["searchSwitch"] = "3";
    $_SESSION["user"] = $result;
}

if (isset($_POST["searchClassInstructorBtn"])) {
    $_SESSION["searchSwitch"] = 3;
}


// if (isset($_GET["searchBtn"])) {
//     switch ($_GET["searchBtn"]) {
//         case "Search Class Code":
//             break;
//         case "Search Class Name":
//             break;
//         case "Search Class Instructor":
//            header("Location: add-class.php");
//            break;
//     }
// }
