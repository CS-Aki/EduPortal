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

  <!-- View Profile Modal -->
  <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="profileModalLabel">Teacher Profile</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="">
            <div class="form-group">
              <label>Class Teacher</label><br>
              <div name="classProf" id="class_prof" class="form-control"></div>
            </div>
           
            <div>
              <!-- <label>CLASSES</label> -->
              <table id="class_list">
                  
              </table>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>


  <script>
    $(document).ready(function() {

      $('.view_profile').click(function(e) {
        e.preventDefault();
        var user_name = $(this).closest('tr').find('.user_name').text();

        $.ajax({
          method: "POST",
          url: "includes/prof-list.inc.php",
          data: {
            'click_view_btn': true,
            'user_name': user_name,
          },

          success: function(response) {
              //  $('#class_prof').val(response[0]['class_teacher']);
            $('#class_prof').empty();
            $('#class_list').empty();
            $('#class_list').append("<tr><th colspan='3'>Classes</th></tr>");
            $('#class_prof').append("<label>"+response[0]['class_teacher'] +"</label>");
            $('#class_list').append("<tr><th>Class Code </th><th> Class Name </th><th>Class Sched</th></tr>");

            $.each(response, function(key, value) {
              
              $('#class_list').append("<tr>");
              $('#class_list').append("<td>"+value["class_code"]+"</td>");
              $('#class_list').append("<td>"+value["class_name"]+"</td>");
              $('#class_list').append("<td>"+value["class_schedule"]+"</td>");
              // $('#class_list').append("</tr>");

            });
            $('#class_list').append("</table>");
            // $('#class_num').val(value['class_num']);

            $('#profileModal').modal('show');
          }
        });

      });

    });
  </script>

</body>

</html>