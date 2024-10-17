  <?php
    if (isset($_GET["paging"])) {
        $urlForm = htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]) . "&paging=" . urlencode($_GET["paging"]);
    } else {
        $urlForm = htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]);
    }
    
    ?>
  
  <div class="modal fade" id="editClass" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editClassLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h1 class="modal-title fs-5" id="editClassLabel">Update Class Information</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <form action="<?php echo $urlForm; ?>" method="post">
                  <div class="modal-body">
                      <div class="form-group">
                          <label>Class Name</label><br>
                          <input type="text" name="className" placeholder="Enter Class Name" id="className" class="form-control" value="<?php echo $_SESSION['list'][$_SESSION['classNumber']]['class_name']; ?>">
                      </div>

                      <label>Class Schedule:</label>
                      <div class="form-group">
                          <br>
                          <label>Day</label>
                          <select name="daySched" id="daySched">
                              <option value="Monday" <?php if ($daySched == "Monday") echo "selected"; ?>>Monday</option>
                              <option value="Tuesday" <?php if ($daySched == "Tuesday") echo "selected"; ?>>Tuesday</option>
                              <option value="Wednesday" <?php if ($daySched == "Wednesday") echo "selected"; ?>>Wednesday</option>
                              <option value="Thursday" <?php if ($daySched == "Thursday") echo "selected"; ?>>Thursday</option>
                              <option value="Friday" <?php if ($daySched == "Friday") echo "selected"; ?>>Friday</option>
                              <option value="Saturday" <?php if ($daySched == "Saturday") echo "selected"; ?>>Saturday</option>
                              <option value="Sunday" <?php if ($daySched == "Sunday") echo "selected"; ?>>Sunday</option>
                          </select>

                          <label>From</label>
                          <select name="startingHourSched" id="startingHourSched">
                              <?php for ($i = 1; $i <= 12; $i++): ?>
                                  <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if ($startingHour == str_pad($i, 2, "0", STR_PAD_LEFT)) echo "selected"; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                              <?php endfor; ?>
                          </select>

                          <select name="startingMinSched" id="startingMinSched">
                              <option value="blank"> </option>
                              <?php for ($i = 0; $i < 60; $i += 10): ?>
                                  <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if ($startingMin == str_pad($i, 2, "0", STR_PAD_LEFT)) echo "selected"; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                              <?php endfor; ?>
                          </select>

                          <select name="startTimePeriod" id="timePeriod">
                              <option value="AM" <?php if ($startingPeriod == "AM") echo "selected"; ?>>AM</option>
                              <option value="PM" <?php if ($startingPeriod == "PM") echo "selected"; ?>>PM</option>
                          </select>

                          <label>To</label>
                          <select name="endingHourSched" id="endingHourSched">
                              <?php for ($i = 1; $i <= 12; $i++): ?>
                                  <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if ($endingHour == str_pad($i, 2, "0", STR_PAD_LEFT)) echo "selected"; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                              <?php endfor; ?>
                          </select>

                          <select name="endingMinSched" id="endingMinSched">
                              <?php for ($i = 0; $i < 60; $i += 10): ?>
                                  <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if ($endingMin == str_pad($i, 2, "0", STR_PAD_LEFT)) echo "selected"; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                              <?php endfor; ?>
                          </select>

                          <select name="endTimePeriod" id="timePeriod">
                              <option value="AM" <?php if ($endingPeriod == "AM") echo "selected"; ?>>AM</option>
                              <option value="PM" <?php if ($endingPeriod == "PM") echo "selected"; ?>>PM</option>
                          </select>
                      </div>

                      <div class="form-group">
                          <label>Class Status</label>
                          <select name="status" id="status">
                              <option value="Active" <?php if ($_SESSION['list'][$_SESSION['classNumber']]['class_status'] == "Active") echo "selected"; ?>>Active</option>
                              <option value="Inactive" <?php if ($_SESSION['list'][$_SESSION['classNumber']]['class_status'] == "Inactive") echo "selected"; ?>>Inactive</option>
                          </select><br><br>
                      </div>

                      <div class="form-group">
                          <label>Class Instructor</label><br>
                          <input type="text" name="classProf" placeholder="Assign Class Instructor" value="<?php echo $_SESSION['list'][$_SESSION['classNumber']]['class_teacher']; ?>"><br><br>
                      </div>

                  </div>

                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" name="editClassBtn">Update Class</button>
                  </div>
              </form>

          </div>
      </div>
  </div>