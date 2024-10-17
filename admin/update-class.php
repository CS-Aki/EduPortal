<?php
require_once("classes/connection.php");
require_once("classes/model.ClassRm.php");
require_once("classes/controller.Admin.php");
require_once("classes/controller.ClassRm.php");
require_once("classes/controller.Lists.php");
include("includes/update.inc.php");
require_once("includes/class-list.inc.php");
require_once("includes/search.inc.php");
require_once("includes/ses-message.inc.php");
require_once("includes/paging.inc.php");
// echo "Min: " . $_SESSION["min"] . " Max: " . $_SESSION["max"];

// // echo $_SESSION['classNumber'];

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title></title>
</head>

<style media="screen">
  body {
    background-color: #556;
  }

  #form label {
    background-color: white;
  }

  .btn {
    margin-top: 10px;
  }

  table {
    margin-top: 50px;
  }

  table,
  th,
  td {
    border: 2px solid black;
    background-color: rgb(38, 39, 124);
    text-align: center;
  }

  th,
  td {
    background-color: rgb(104, 106, 214);
    color: rgba(243, 243, 243, 0.993);
    padding: 5px;
  }

  a {
    display: inline-block;
    text-decoration: none;
    color: orange;
    padding: 10px 20px;
    border: thin solid #d4d4d4;
    transition: all 0.3s;
    font-size: 18px;
  }

  a.active {
    background-color: #0d81cd;
    color: #fff;
  }
</style>

<body>

  <!-- FINDS THE NUMBER OF EDIT BUTTON CLICKED -->
  <?php
  $temp = 20;
  $j = 0;
  // echo "test";

  while ($j < $temp) {
    if (isset($_POST[$j])) {
      $temp = $j;
      $_SESSION['classNumber'] = $temp;
    //  echo $_SESSION['classNumber'];
      $_SESSION['show_modal'] = true;
      echo $_SESSION['show_modal'];
      // include("edit-pop.php");
      include("includes/edit-init.inc.php");
     // header("Location: " . $_SERVER['PHP_SELF'] . "?adminBtn=" . urlencode($_GET["adminBtn"]));
      break;
    }
    $j++;
  }
  ?>

  <!-- PHP file for the modal elements -->
  <?php include("modal.php"); ?>

  <!-- Checks if an edit button is already clicked then display the modal pop up -->
  <script>
   
    <?php if (isset($_SESSION['show_modal']) && $_SESSION['show_modal'] === true): ?>
      <?php ?>
    
      var myModal = new bootstrap.Modal(document.getElementById('editClass'), {});
      console.log("JavaScript is working!");
      myModal.show();
      
      <?php unset($_SESSION['show_modal']); ?>
    <?php endif; ?>
  </script>

  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]); ?>" method="POST">
    <label for="searchClassCode">Search Class</label>
    <input type="text" name="searchClassCode" placeholder="Enter Class Code" value="<?php  ?>">
    <input type="submit" name="searchClassCodeBtn" value="Search Class Code" class="btn">

    <label for="searchClassBtn">Search Class</label>
    <input type="text" name="searchClass" placeholder="Enter Class">
    <input type="submit" name="searchClassBtn" value="Search Class Name" class="btn">

    <label for="searchClassInsBtn">Search Class</label>
    <input type="text" name="searchClassIns" placeholder="Enter Class Instructor">
    <input type="submit" name="searchClassInsBtn" value="Search Class Instructor" class="btn">

    <input type="submit" name="backBtn" value="Go Back" class="btn"><br>
  </form>

  <label for="msg" id="msg"><?php displaySessionMessage("msg", 1); ?></label>

  <div class="result-container">
    <table>
      <tr>
        <th>Class Code</th>
        <th>Class Name</th>
        <th>Class Instructor</th>
        <th>Class Schedule</th>
        <th>Class Status</th>
        <th>Edit Button</th>
      </tr>
      <!-- Prints out the class data from the db -->
      <?php
      if ($_SESSION["searchSwitch"] == "all") {
        fetchAllClasses1();
      } else if ($_SESSION["searchSwitch"] == "1") {
        displayClassWithCode($_SESSION["user"]);
      } else if ($_SESSION["searchSwitch"] == "2") {
        displayClassWithCName($_SESSION["user"]);
      } else if ($_SESSION["searchSwitch"] == "3") {
        displayClassWithIns($_SESSION["user"]);
      }
      ?>
    </table>
  </div>

  <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET['adminBtn']) . "&paging=prev" . "=" . urlencode($_SESSION["counter"]); ?>">Previous</a>

  <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET['adminBtn']) . "&paging=next" . "=" . urlencode($_SESSION["counter"]); ?>">Next</a>


</body>

</html>