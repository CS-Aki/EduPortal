<?php

function fetchAllClasses()
{
  $listController = new ListController();
  $listOfClasses = $listController->getAllClass();
  $_SESSION["list"] = $listOfClasses;

  //Used for displaying list of classes from the database into the client
  if (isset($_GET["paging"])) {
    $urlForm = htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]) . "&paging=" . urlencode($_GET["paging"]);
  } else {
    $urlForm = htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]);
  }

  if ($_GET['adminBtn'] == "Class List") {
    echo "<form id='editForm' action='{$urlForm}' method=post>";
    for ($i = 0; $i < count($listOfClasses); $i++) {
      echo "<tr><td>" . $listOfClasses[$i]["class_code"] . "</td>";
      echo "<td>" . $listOfClasses[$i]["class_name"] . "</td>";
      echo "<td>" . $listOfClasses[$i]["class_teacher"] . "</td>";
      echo "<td>" . $listOfClasses[$i]["class_schedule"] . "</td>";
      echo "<td>" . $listOfClasses[$i]["class_status"] . "</td>";
      // Button will display same thing as add classes features
    }
    echo "</form>";
  } else {
    echo "<form id='editForm' action='{$urlForm}' method=post>";
    for ($i = 0; $i < count($listOfClasses); $i++) {
      echo "<tr><td>" . $listOfClasses[$i]["class_code"] . "</td>";
      echo "<td>" . $listOfClasses[$i]["class_name"] . "</td>";
      echo "<td>" . $listOfClasses[$i]["class_teacher"] . "</td>";
      echo "<td>" . $listOfClasses[$i]["class_schedule"] . "</td>";
      echo "<td>" . $listOfClasses[$i]["class_status"] . "</td>";
      // Button will display same thing as add classes features
      echo "<td><input type='submit' name='{$i}' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editClass' value='Edit'></td></tr>";
    }
    echo "</form>";
  }
}

function fetchAllClasses1()
{
  $listController = new ListController();
  $listOfClasses = $listController->getAllClass();
  $_SESSION["list"] = $listOfClasses;

  //Used for displaying list of classes from the database into the client
  if (isset($_GET["paging"])) {
    $urlForm = htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]) . "&paging=" . urlencode($_GET["paging"]);
  } else {
    $urlForm = htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]);
  }

  if ($_GET['adminBtn'] == "Class List") {
    echo "<form id='editForm' action='{$urlForm}' method=post>";
    for ($i = 0; $i < count($listOfClasses); $i++) {
      echo "<tr><td>" . $listOfClasses[$i]["class_code"] . "</td>";
      echo "<td>" . $listOfClasses[$i]["class_name"] . "</td>";
      echo "<td>" . $listOfClasses[$i]["class_teacher"] . "</td>";
      echo "<td>" . $listOfClasses[$i]["class_schedule"] . "</td>";
      echo "<td>" . $listOfClasses[$i]["class_status"] . "</td>";
      // Button will display same thing as add classes features
    }
    echo "</form>";
  } else {

    for ($i = 0; $i < count($listOfClasses); $i++) {
      echo "<tr><td class='class_code'>" . $listOfClasses[$i]["class_code"] . "</td>";
      // echo "<tr><td class='btn_num'>" . $i . "</td>";
      echo "<td class='class_name'>" . $listOfClasses[$i]["class_name"] . "</td>";
      echo "<td class='class_teacher'>" . $listOfClasses[$i]["class_teacher"] . "</td>";
      echo "<td class='class_schedule'>" . $listOfClasses[$i]["class_schedule"] . "</td>";
      echo "<td class_status>" . $listOfClasses[$i]["class_status"] . "</td>";
      // Button will display same thing as add classes features
      echo "<td><a href='#' class='btn btn-success btn-sm edit_data'>Edit</a></td></tr>";
    }
  }
}

function displayClassWithCode($result)
{

  if (isset($_GET["paging"])) {
    $urlForm = htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]) . "&paging=" . urlencode($_GET["paging"]);
  } else {
    $urlForm = htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]);
  }

  if ($_GET['adminBtn'] == "Class List") {
    echo "<form action='{$urlForm}' method=post>";
    echo "<tr><td>" . $result[0]["class_code"] . "</td>";
    echo "<td>" . $result[0]["class_name"] . "</td>";
    echo "<td>" . $result[0]["class_teacher"] . "</td>";
    echo "<td>" . $result[0]["class_schedule"] . "</td>";
    echo "<td>" . $result[0]["class_status"] . "</td>";
    // Button will display same thing as add classes features
    echo "</form>";
  } else {
    echo "<form action='{$urlForm}' method=post>";
    echo "<tr><td>" . $result[0]["class_code"] . "</td>";
    echo "<td>" . $result[0]["class_name"] . "</td>";
    echo "<td>" . $result[0]["class_teacher"] . "</td>";
    echo "<td>" . $result[0]["class_schedule"] . "</td>";
    echo "<td>" . $result[0]["class_status"] . "</td>";
    // Button will display same thing as add classes features
    echo "<td><input type='submit' name='1' value='Edit'></td></tr>";
    echo "</form>";
  }
}

function displayClassWithCName($result)
{

  if (isset($_GET["paging"])) {
    $urlForm = htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]) . "&paging=" . urlencode($_GET["paging"]);
  } else {
    $urlForm = htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]);
  }

  if ($_GET['adminBtn'] == "Class List") {
    echo "<form action='{$urlForm}' method=post>";
    echo "<tr><td>" . $result[0]["class_code"] . "</td>";
    echo "<td>" . $result[0]["class_name"] . "</td>";
    echo "<td>" . $result[0]["class_teacher"] . "</td>";
    echo "<td>" . $result[0]["class_schedule"] . "</td>";
    echo "<td>" . $result[0]["class_status"] . "</td>";
    // Button will display same thing as add classes features
    echo "</form>";
  } else {
    echo "<form action='{$urlForm}' method=post>";
    echo "<tr><td>" . $result[0]["class_code"] . "</td>";
    echo "<td>" . $result[0]["class_name"] . "</td>";
    echo "<td>" . $result[0]["class_teacher"] . "</td>";
    echo "<td>" . $result[0]["class_schedule"] . "</td>";
    echo "<td>" . $result[0]["class_status"] . "</td>";
    // Button will display same thing as add classes features
    echo "<td><input type='submit' name='1' value='Edit'></td></tr>";
    echo "</form>";
  }
}

function displayClassWithIns($result)
{
  if (isset($_GET["paging"])) {
    $urlForm = htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]) . "&paging=" . urlencode($_GET["paging"]);
  } else {
    $urlForm = htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]);
  }

  if ($_GET['adminBtn'] == "Class List") {
    echo "<form action='{$urlForm}' method=post>";
    for ($i = 0; $i < count($result); $i++) {
      echo "<tr><td>" . $result[$i]["class_code"] . "</td>";
      echo "<td>" . $result[$i]["class_name"] . "</td>";
      echo "<td>" . $result[$i]["class_teacher"] . "</td>";
      echo "<td>" . $result[$i]["class_schedule"] . "</td>";
      echo "<td>" . $result[$i]["class_status"] . "</td>";
      // Button will display same thing as add classes features
    }
    echo "</form>";
  } else {
    echo "<form action='{$urlForm}' method=post>";
    for ($i = 0; $i < count($result); $i++) {
      echo "<tr><td>" . $result[$i]["class_code"] . "</td>";
      echo "<td>" . $result[$i]["class_name"] . "</td>";
      echo "<td>" . $result[$i]["class_teacher"] . "</td>";
      echo "<td>" . $result[$i]["class_schedule"] . "</td>";
      echo "<td>" . $result[$i]["class_status"] . "</td>";
      // Button will display same thing as add classes features
      echo "<td><input type='submit' name='{$i}' value='Edit'></td></tr>";
    }
    echo "</form>";
  }
}


if (isset($_POST['click_edit_btn'])) {
 
  $classCode = $_POST['class_code'];
  $listController = new ListController();
  $listOfClasses = $listController->getClassFromCode();
  $_SESSION["list"] = $listOfClasses;
//  echo $listOfClasses[0]["class_num"];
  //$_SESSION['classNumber'] = 1;
  $sched = $listController->getSched();
 
  $listOfClasses[0]["daySched"] = $sched["daySched"];
  $listOfClasses[0]["startingHour"] = $sched["startingHour"];
  $listOfClasses[0]["startingMin"] = $sched["startingMin"];
  $listOfClasses[0]["startTimePeriod"] = $sched["startTimePeriod"];
  $listOfClasses[0]["endingHour"] = $sched["endingHour"];
  $listOfClasses[0]["endingMin"] = $sched["endingMin"];
  $listOfClasses[0]["endTimePeriod"] = $sched["endTimePeriod"];

  $_SESSION["list"] = $listOfClasses;
  
  header('content-type: application/json');
  echo json_encode($listOfClasses);

  exit();
}
