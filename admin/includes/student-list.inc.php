<?php

function fetchAllStudent()
{
    $instController = new InstructorController();
    $instructorList = $instController->getAllProf();
    $_SESSION["list"] = $instructorList;

    if (isset($_GET["paging"])) {
        $urlForm = htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]) . "&paging=" . urlencode($_GET["paging"]);
    } else {
        $urlForm = htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]);
    }

    echo "<form id='instructorForm' action='{$urlForm}' method=post>";
    for ($i = 0; $i < count($instructorList); $i++) {
        echo "<tr><td>" . $instructorList[$i]["user_id"] . "</td>";
        echo "<td>" . $instructorList[$i]["name"] . "</td>";
        echo "<td>" . $instructorList[$i]["email"] . "</td>";
        // Button will display same thing as add classes features
        // echo "<td><input type='submit' name='{$i}' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editClass' value='View Profile'></td></tr>";
        echo "<td><input type='submit' name='{$i}' class='btn btn-primary' value='View Profile'></td></tr>";
    }
    echo "</form>";
}

function searchStudent()
{
    $instController = new InstructorController();
    $instructor = $instController->searchInstructor();

    if (isset($_GET["paging"])) {
        $urlForm = htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]) . "&paging=" . urlencode($_GET["paging"]);
    } else {
        $urlForm = htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]);
    }

    echo "<form id='instructorForm' action='{$urlForm}' method=post>";
    echo "<tr><td>" . $instructor[0]["user_id"] . "</td>";
    echo "<td>" . $instructor[0]["name"] . "</td>";
    echo "<td>" . $instructor[0]["email"] . "</td>";

    //Might change the 'name' on the input submit to other detail from the prof
    echo "<td><input type='submit' name='{0}' class='btn btn-primary' value='View Profile'></td></tr>";

    echo "</form>";
}
