<?php
require_once("classes/connection.php");
require_once("classes/model.ClassRm.php");
require_once("classes/model.Prof.php");
require_once("classes/controller.Prof.php");
require_once("classes/controller.Admin.php");
require_once("classes/controller.ClassRm.php");
require_once("classes/controller.Lists.php");
require_once("includes/class-list.inc.php");
require_once("includes/search.inc.php");
require_once("includes/ses-message.inc.php");
require_once("includes/paging.inc.php");
require_once("includes/prof-list.inc.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
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
  
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]); ?>" method="POST">
    <input type="text" name="searchClassInstructor" placeholder="Enter Class Instructor">
    <input type="submit" name="searchClassInstructorBtn" value="Search Class Instructor" class="btn">

    <input type="submit" name="backBtn" value="Go Back" class="btn"><br>
  </form>

  <label for="msg" id="msg"><?php displaySessionMessage("msg", 1); ?></label>

  <div class="result-container">
    <table>
      <tr>
        <th>Instructor ID</th>
        <th>Instructor Name</th>
        <th>Email</th>
        <th>View Profile Button</th>
      </tr>
      <!-- Prints out the instructor data from the db -->
      <?php

      if ($_SESSION["searchSwitch"] == "all") {
        fetchAllProf();
      } else if ($_SESSION["searchSwitch"] == "3") {
        searchProf();
        unset($_SESSION["searchSwitch"]);
      }

      ?>
    </table>
  </div>

  <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET['adminBtn']) . "&paging=prev" . "=" . urlencode($_SESSION["counter"]); ?>">Previous</a>

  <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET['adminBtn']) . "&paging=next" . "=" . urlencode($_SESSION["counter"]); ?>">Next</a>
</body>

</html>