<?php
    require_once("classes/connection.php");
    require_once("classes/model.ClassRm.php");
    require_once("classes/controller.Admin.php");
    require_once("classes/controller.ClassRm.php");
    require_once("classes/controller.Lists.php");
    require_once("includes/update.inc.php");
    require_once("includes/class-list.inc.php");
    require_once("includes/search.inc.php");
    require_once("includes/ses-message.inc.php");
   // if(session_id() === "") session_start();
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>

  <style media="screen">
      body {
      background-color: #34495e;
      }

      #form label{
          background-color: white;
      }

      .btn{
          margin-top: 10px;
      }

      table{
          margin-top: 50px;
      }

      table, th, td{
          border: 2px solid black;
          background-color:rgb(38, 39, 124);
          text-align: center;
      }

      th, td{
          background-color:rgb(104, 106, 214);
          color: rgba(243, 243, 243, 0.993);
          padding: 5px;
      }
  </style>

  <body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . $_GET["adminBtn"];?>" method="POST">
        <label for="searchClassCode">Search Class</label>
        <input type="text" name="searchClassCode" placeholder="Enter Class Code">
        <input type="submit" name="searchClassCodeBtn" value="Search Class Code" class="btn"><br>

        <label for="searchClassBtn">Search Class</label>
        <input type="text" name="searchClass" placeholder="Enter Class">
        <input type="submit" name="searchClassBtn" value="Search Class Name" class="btn"><br>

        <label for="searchClassInsBtn">Search Class</label>
        <input type="text" name="searchClassIns" placeholder="Enter Class Instructor">
        <input type="submit" name="searchClassInsBtn" value="Search Class Instructor" class="btn"><br>

        <input type="submit" name="backBtn" value="Go Back" class="btn"><br>
        <label for="msg" id="msg"><?php displaySessionMessage("msg", 1); ?></label>
    </form>

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
            if($_SESSION["searchSwitch"] == "all"){
              fetchAllClasses();
            }else if($_SESSION["searchSwitch"] == "1"){
              displayClassWithCode($_SESSION["user"]);
            }else if($_SESSION["searchSwitch"] == "2"){
              displayClassWithCName($_SESSION["user"]);
            }else if($_SESSION["searchSwitch"] == "3"){
              displayClassWithIns($_SESSION["user"]);
            }
        ?>
      </table>
    </div>

    <!-- <label><?php echo $_SESSION["searchSwitch"];?></label> -->

  </body>

</html>
