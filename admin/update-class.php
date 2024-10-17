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
require_once("includes/paging.inc.php");
// require_once("includes/edit-init.inc.php");
// echo "Min: " . $_SESSION["min"] . " Max: " . $_SESSION["max"];

// // echo $_SESSION['classNumber'];

?>

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

<?php
if (isset($_GET["paging"])) {
  $urlForm = htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]) . "&paging=" . urlencode($_GET["paging"]);
} else {
  $urlForm = htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]);
}

?>

<!-- Edit Modal -->
<div class="modal fade" id="editClassModal" tabindex="-1" aria-labelledby="editClassModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editClassModalLabel">Edit Class Form</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="<?php echo $urlForm; ?>" method="post">

        <div class="modal-body">
           <input type="text" name="classNum" id="class_num" hidden>
          <div class="form-group">
            <label>Class Code</label><br>
            <input type="text" name="class_code" id="classCode" class="form-control" disabled>
          </div>

          <div class="form-group">
            <label>Class Name</label><br>
            <input type="text" name="className" placeholder="Enter Class Name" id="className" class="form-control">
          </div>

          <label>Class Schedule:</label>
          <div class="form-group mb-3">
            <br>
            <label>Day</label>
            <select name="daySched" id="daySched">
              <option value="Monday">Monday</option>
              <option value="Tuesday">Tuesday</option>
              <option value="Wednesday">Wednesday</option>
              <option value="Thursday">Thursday</option>
              <option value="Friday">Friday</option>
              <option value="Saturday">Saturday</option>
              <option value="Sunday">Sunday</option>
            </select>

            <label>From</label>
            <select name="startingHourSched" id="startingHourSched">
              <?php for ($i = 1; $i <= 12; $i++): ?>
                <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>"><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
              <?php endfor; ?>
            </select>

            <select name="startingMinSched" id="startingMinSched">
              <?php for ($i = 0; $i < 60; $i += 10): ?>
                <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>"><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
              <?php endfor; ?>
            </select>

            <select name="startTimePeriod" id="startTimePeriod">
              <option value="AM">AM</option>
              <option value="PM">PM</option>
            </select>

            <label>To</label>
            <select name="endingHourSched" id="endingHourSched">
              <?php for ($i = 1; $i <= 12; $i++): ?>
                <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>"><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
              <?php endfor; ?>
            </select>

            <select name="endingMinSched" id="endingMinSched">
              <?php for ($i = 0; $i < 60; $i += 10): ?>
                <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>"><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
              <?php endfor; ?>
            </select>

            <select name="endTimePeriod" id="endTimePeriod">
              <option value="AM">AM</option>
              <option value="PM">PM</option>
            </select>
          </div>

          <div class="form-group mb-3">
            <label>Class Status</label>
            <select name="status" id="status">
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select><br><br>
          </div>

          <div class="form-group mb-3">
            <label>Class Instructor</label><br>
            <input type="text" name="classProf" placeholder="Assign Class Instructor" id="classInstructor"><br><br>
          </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="editClassBtn" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

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


<script>
  $(document).ready(function() {

    $('.edit_data').click(function(e) {
      e.preventDefault();
      var class_code = $(this).closest('tr').find('.class_code').text();
      // var btn_num = $(this).closest('tr').find('.btn_num').text();
     
      $.ajax({
        method: "POST",
        url: "update-class.php",
        data: {
          'click_edit_btn': true,
          'class_code': class_code,
          // 'btn_num' : btn_num,
        },

        success: function(response) {

          $.each(response, function(key, value) {
            $('#class_num').val(value['class_num']);
            $('#classCode').val(value['class_code']);
            $('#className').val(value['class_name']);
            $('#daySched').val(value['daySched']);
            $('#startingHourSched').val(value['startingHour']);
            $('#startingMinSched').val(value['startingMin']);
            $('#startTimePeriod').val(value['startTimePeriod']);
            $('#endingHourSched').val(value['endingHour']);
            $('#endingMinSched').val(value['endingMin']);
            $('#endTimePeriod').val(value['endTimePeriod']);
            $('#status').val(value['class_status']); 
            $('#classInstructor').val(value['class_teacher']);

          });

          //   // Parse the JSON response
          console.log(response);
          // //  $('.edit_class_data').html(response);
          $('#editClassModal').modal('show');
        }
      });

    });

  });
</script>