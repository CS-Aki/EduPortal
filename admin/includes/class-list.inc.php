<?php

function fetchAllClasses(){
    $listController = new ListController();
    $listOfClasses = $listController->getAllClass();
    $_SESSION["list"] = $listOfClasses;
    //Used for displaying list of classes from the database into the client
    if(isset($_GET["paging"])){
      $urlForm = htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]) . "&paging=" . urlencode($_GET["paging"]);
    }else{
      $urlForm = htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]);
    }

    echo"<form action='{$urlForm}' method=post>";
    for($i = 0; $i < count($listOfClasses); $i++){
        echo "<tr><td>" . $listOfClasses[$i]["class_code"] . "</td>";
        echo "<td>". $listOfClasses[$i]["class_name"] . "</td>";
        echo "<td>" . $listOfClasses[$i]["class_teacher"] . "</td>";
        echo "<td>" . $listOfClasses[$i]["class_schedule"] . "</td>";
        echo "<td>" . $listOfClasses[$i]["class_status"] . "</td>";
        // Button will display same thing as add classes features
        echo "<td><input type='submit' name='{$i}' value='Edit'></td></tr>";
    }
      echo"</form>";
}

function displayClassWithCode($result){
      echo "<tr><td>" . $result[0]["class_code"] . "</td>";
      echo "<td>". $result[0]["class_name"] . "</td>";
      echo "<td>" . $result[0]["class_teacher"] . "</td>";
      echo "<td>" . $result[0]["class_schedule"] . "</td>";
      echo "<td>" . $result[0]["class_status"] . "</td>";
      // Button will display same thing as add classes features
      echo "<td><button>Edit</button></td></tr>";
}

function displayClassWithCName($result){
    echo "<tr><td>" . $result[0]["class_code"] . "</td>";
    echo "<td>". $result[0]["class_name"] . "</td>";
    echo "<td>" . $result[0]["class_teacher"] . "</td>";
    echo "<td>" . $result[0]["class_schedule"] . "</td>";
    echo "<td>" . $result[0]["class_status"] . "</td>";
    // Button will display same thing as add classes features
    echo "<td><button>Edit</button></td></tr>";
}

function displayClassWithIns($result){
    for($i = 0; $i < count($result); $i++){
      echo "<tr><td>" . $result[$i]["class_code"] . "</td>";
      echo "<td>". $result[$i]["class_name"] . "</td>";
      echo "<td>" . $result[$i]["class_teacher"] . "</td>";
      echo "<td>" . $result[$i]["class_schedule"] . "</td>";
      echo "<td>" . $result[$i]["class_status"] . "</td>";
      // Button will display same thing as add classes features
      echo "<td><button>Edit</button></td></tr>";
    }
}
?>
