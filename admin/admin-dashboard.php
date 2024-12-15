<?php 
if (session_id() === "") session_start();
// echo "test " . $_SESSION["address"];
if(isset($_SESSION["user_category"])){
    $category = $_SESSION["user_category"];
    switch($category){
        // case 1: header("Location: ../admin/admin-dashboard.php"); exit(); break;
        case 2:  header("Location: ../staff/staff-dashboard.php"); break;
        case 3: header("Location: ../instructor/instructor-dashboard.php"); exit(); break;
        case 4: header("Location: student/student-dashboard.php"); break;
    }
}else{
    header("Location: ../");
    exit();
}9
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <?php require('inc/links.php'); ?>
</head>
<body>

  <?php require('inc/header.php'); require_once('includes/dashboard.php');
  $activeStudentCount = getActiveStudentCount();
  $activeProfessorCount = getActiveProfessorCount();
  $activeStaffCount = getActiveStaffCount();
  $activeSubjectCount = getActiveSubjectCount();
  $topSubjects = getTopClassesWithEnrollment();
  $enrollmentData = getMonthlyEnrollment(4);
  $enrollmentCounts = json_encode(array_values($enrollmentData)); // Counts
  $labels = json_encode(array_keys($enrollmentData)); 
  $examData = getMonthlyPassFail(4); 
  $passed = json_encode(array_column($examData, 'passed')); // Passed counts
  $failed = json_encode(array_column($examData, 'failed')); // Failed counts
  $months = json_encode(array_keys($examData));
    
  ?>

  <div class="container-fluid px-lg-4 px-md-2 px-sm-1 py-lg-3 py-md-3 py-sm-2" id="main-content">
      <div class="row">
          <div class="col-lg-10 ms-auto">
              <div class="container">
                  <div class="d-flex align-items-center justify-content-between">
                      <h3 class="h-font green3 me-2">Dashboard</h3>
                      <div class="line-h"></div> <!-- Ensure the line grows to fill the space --> 
                  </div>
    
                  <div class="row border-box mb-2">
                    <div class="col-lg-3 col-md-6 mb-2">
                      <div class="ps-4 green rounded-4 w-90">
                        <div class="py-2 pe-1 ps-lg-2 d-flex align-items-center">
                          <div>
                            <i class="bi bi-person-circle fs-1 me-3 white1"></i>
                          </div>
                          <div class="d-flex flex-column justify-content-center lh-1">
                            <p class="green3 fw-semibold m-0 p-0 mb-1">Students Enrolled</p>
                            <p class="fs-3 white1 fw-bold m-0 p-0 pt-0"><?= number_format($activeStudentCount) ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                      <div class="ps-4 green rounded-4 w-90">
                        <div class="py-2 pe-1 ps-lg-2 d-flex align-items-center">
                          <div>
                            <i class="bi bi-mortarboard-fill fs-1 me-3 white1"></i>
                          </div>
                          <div class="d-flex flex-column justify-content-center lh-1">
                            <p class="green3 fw-semibold m-0 p-0 mb-1">Instructors</p>
                            <p class="fs-3 white1 fw-bold m-0 p-0 pt-0"><?= number_format($activeProfessorCount) ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                      <div class="ps-4 green rounded-4 w-90">
                        <div class="py-2 pe-1 ps-lg-2 d-flex align-items-center">
                          <div>
                            <i class="bi bi-people-fill fs-1 me-3 white1"></i>
                          </div>
                          <div class="d-flex flex-column justify-content-center lh-1">
                            <p class="green3 fw-semibold m-0 p-0 mb-1">Staff</p>
                            <p class="fs-3 white1 fw-bold m-0 p-0 pt-0"><?= number_format($activeStaffCount) ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                      <div class="ps-4 green rounded-4 w-90">
                        <div class="py-2 pe-1 ps-lg-2 d-flex align-items-center">
                          <div>
                            <i class="bi bi-bookmark-fill fs-1 me-3 white1"></i>
                          </div>
                          <div class="d-flex flex-column justify-content-center lh-1">
                            <p class="green3 fw-semibold m-0 p-0 mb-1">Classes</p>
                            <p class="fs-3 white1 fw-bold m-0 p-0 pt-0"><?= number_format($activeSubjectCount) ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="border-3 bordergreen border rounded-4 py-lg-2 py-md-2 py-sm-3 py-3 px-lg-3 px-md-3 px-sm-3 px-3 mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                          <h4 class="fw-bold green2 mt-lg-2 mt-md-1">Announcements</h4>
                          <a href="" data-bs-toggle="modal" data-bs-target="#announcementModal"><i class="bi bi-plus-circle-fill green1 fs-2"></i></a>
                        </div>
                        <div id="announce-container">
                      <?php displayAnnouncements(); ?>
                       </div>
                      </div>
                      
                      
                      <div class="border-3 bordergreen border rounded-4 pt-lg-2 pt-md-2 pt-sm-3 pt-3 px-lg-3 px-md-3 px-sm-3 px-3 mb-2">
                        <h4 class="fw-bold green2 mt-lg-2 mt-md-1">Popular Courses</h4>
                          <div class="container-fluid border-bottom border-secondary-subtle border-2 rounded-3 py-3 px-lg-3 d-flex align-items-center p-2 mb-2">
                            <div>
                              <p class="black3 lh-1 fs-5 mb-0 pb-0 me-4">1</p>
                            </div>
                            <div>
                              <p class="black3 fw-bold lh-1 fs-5 mb-0 pb-0" id="material-title">
                              <?= htmlspecialchars($topSubjects['top1']) ?>
                              </p>
                            </div>
                          </div>
                 
                 
                          <div class="container-fluid border-bottom border-secondary-subtle border-2 rounded-3 py-3 px-lg-3 d-flex align-items-center p-2 mb-2">
                            <div>
                              <p class="black3 lh-1 fs-5 mb-0 pb-0 me-4">2</p>
                            </div>
                            <div>
                              <p class="black3 fw-bold lh-1 fs-5 mb-0 pb-0" id="material-title">
                              <?= htmlspecialchars($topSubjects['top2']) ?>
                              </p>
                            </div>
                          </div>
                 
            
                          <div class="container-fluid border-bottom border-secondary-subtle border-2 rounded-3 py-3 px-lg-3 d-flex align-items-center p-2 mb-2">
                            <div>
                              <p class="black3 lh-1 fs-5 mb-0 pb-0 me-4">3</p>
                            </div>
                            <div>
                              <p class="black3 fw-bold lh-1 fs-5 mb-0 pb-0" id="material-title">
                              <?= htmlspecialchars($topSubjects['top3']) ?>
                              </p>
                            </div>
                          </div>
                 
                          <div class="container-fluid border-bottom border-secondary-subtle border-2 rounded-3 py-3 px-lg-3 d-flex align-items-center p-2 mb-2">
                            <div>
                              <p class="black3 lh-1 fs-5 mb-0 pb-0 me-4">4</p>
                            </div>
                            <div>
                              <p class="black3 fw-bold lh-1 fs-5 mb-0 pb-0" id="material-title">
                              <?= htmlspecialchars($topSubjects['top4']) ?>
                              </p>
                            </div>
                          </div>

                          <div class="container-fluid  border-secondary-subtle border-2 rounded-3 py-3 px-lg-3 d-flex align-items-center p-2 mb-2">
                            <div>
                              <p class="black3 lh-1 fs-5 mb-0 pb-0 me-4">5</p>
                            </div>
                            <div>
                              <p class="black3 fw-bold lh-1 fs-5 mb-0 pb-0" id="material-title">
                              <?= htmlspecialchars($topSubjects['top5']) ?>
                              </p>
                            </div>
                          </div>
                       
                      </div>

                      <div class="border-3 bordergreen border rounded-4 py-lg-2 py-md-2 py-sm-3 py-3 px-lg-3 px-md-3 px-sm-3 px-3">
                        <h4 class="fw-bold green2 mt-lg-2 mt-md-1">Quiz/Exam Performace</h4>
                        <div class="d-flex flex-column align-items-center justify-content-center ">
                          <canvas id="performanceChart" style="height: 300; width: 300;" class="p-3"></canvas>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="border-3 bordergreen border rounded-4 py-lg-2 py-md-2 py-sm-3 py-3 px-lg-3 px-md-3 px-sm-3 px-3 mb-2">
                        <h4 class="fw-bold green2 mt-lg-2 mt-md-1">EduPortal Demographics</h4>
                        <div class="d-flex flex-column align-items-center justify-content-center ">
                          <canvas id="userRoleChart" style="height: 300; width: 300;" class="p-3"></canvas>
                        </div>
                      </div>
                      <div class="border-3 bordergreen border rounded-4 py-lg-2 py-md-2 py-sm-3 py-3 px-lg-3 px-md-3 px-sm-3 px-3">
                        <h4 class="fw-bold green2 mt-lg-2 mt-md-1">Student Enrollment</h4>
                        <div class="d-flex flex-column align-items-center justify-content-center ">
                          <canvas id="enrollmentChart" style="height: 300; width: 300;" class="p-3"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- <div class="d-flex align-items-center justify-content-between">
                      <h3 class="h-font green3 me-2">Print Report</h3>
                      <div class="line-h"></div> 
                      Ensure the line grows to fill the space 
                  </div>   -->
                   
                  <!-- <div class="row">
                    <div class="col-lg-12">
                      <div class="border-3 bordergreen border rounded-4 py-lg-2 py-md-2 py-sm-3 py-3 px-lg-3 px-md-3 px-sm-3 px-3 mb-2">
                         <form action="">
                          <div class="row">
                            <div class="col-lg-1 d-flex align-items-center">
                              <label class="form-label black3 mb-0 ">From</label>
                            </div>
                            <div class="col-lg-3">
                                <input type="date" class="form-control black3 shadow-elevation-light-3 container-fluid" value="" name="fromDate" id="from_date" required>
                            </div>
                            <div class="col-lg-1 d-flex align-items-center">
                              <label class="form-label black3 mb-0 ">To</label>
                            </div>
                            <div class="col-lg-3">
                                <input type="date" class="form-control black3 shadow-elevation-light-3 container-fluid" value="" name="fromDate" id="from_date" required>
                            </div>
                            <div class="col-lg-4">
                              <button type="submit" name="printBtn" class="btn green shadow-none border-none py-2 rounded-5 w-100" id="print_btn">Generate</button>
                            </div>
                          </div>
                        </form> 
                      </div>
                </div>
              </div> -->
          </div>
      </div>
  </div>

  <!-- CREATE ANNOUNCEMENT MODAL -->
  <div class="modal fade" id="announcementModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="announcementModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">                       
              <div class="modal-content rounded-4 px-2">
                  <div class="modal-body">
                      <form action="includes/announcement.php" method="post" id="announcementForm">
                          <div class="container-fluid d-flex justify-content-between align-items-center">
                              <div class="d-flex justify-content-center align-items-center">
                                  <div>
                                    <i class='bi bi-megaphone-fill fs-1 green1 title p-0 m-0'></i>
                                  </div>
                                  <div class="lh-sm">
                                    <h1 class="title fs-1 h-font ms-3 m-0 p-0 green1" id="className">Create Announcement</h1>
                                  </div>
                              </div>
                              <button clas="d-flex align-items-start" type="button" class="btn-close" id="close_code" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="container-fluid">
                              <div class="row mb-2">
                                  <div class="col-lg-1 d-flex align-items-center">
                                    <label class="form-label black3 mb-0 me-3">Subject</label>
                                  </div>
                                  <div class="col-lg-11">
                                      <input type="text" class="form-control black3 shadow-elevation-light-3 container-fluid" value="" name="subject" id="subject" required>
                                  </div>
                              </div>
                              <div class="row mb-2">
                                  <div class="col-lg-1 d-flex align-items-center">
                                    <label class="form-label black3 mb-0 me-3">From</label>
                                  </div>
                                  <div class="col-lg-3 d-flex align-items-center">
                                      <input type="date" class="form-control black3 shadow-elevation-light-3 container-fluid" value="" name="fromDate" id="from_date" required>
                                  </div>
                                  <div class="col-lg-4 d-flex align-items-center">
                                      <label class="form-label black3 mb-0 me-3">To</label>
                                      <input type="date" class="form-control black3 shadow-elevation-light-3" value="" name="toDate" id="to_date" required>
                                  </div>
                                  <div class="col-lg-4 d-flex align-items-center">
                                      <label class="form-label black3 mb-0 me-3">Type</label>
                                      <div class="input-group">
                                          <select class="form-select shadow-elevation-light-3 black3" id="msg_type">
                                              <option value="1">General</option>
                                              <option value="2">Maintenance</option>
                                              <option value="3">Examination</option>
                                          </select>
                                      </div>
                                  </div>
                              </div>
                              <div class="row mb-2">
                                <div class="col-lg-1 d-flex align-items-center">
                                    <label class="form-label black3 mb-0 me-3">Audience</label>
                                </div>
                                <div class="col-lg-3 d-flex align-items-center">
                                    <div class="input-group">
                                        <select class="form-select shadow-elevation-light-3 black3" id="audience_visible">
                                            <option value="5">All</option>
                                            <option value="3">Instructors</option>
                                            <option value="4">Students</option>
                                            <option value="2">Staff</option>
                                        </select>
                                    </div>
                                </div>
                              </div>
                              <div class="row mb-2">
                                <div class="col-lg-12 d-flex ">
                                    <label class="form-label black3 mb-0 me-3">Message</label>
                                    <textarea rows="10" class="form-control black3 shadow-elevation-light-3" value="" name="message" id="message-content" required></textarea>
                                </div>
                              </div>
                              <div class="d-flex justify-content-end gap-1 mt-4">
                                  <button type="submit" name="postAnnounceBtn" class="btn green shadow-none border-none rounded-5 px-4 py-2" id="post_announce_btn">Post Announcement</button>
                              </div>
                          </div>
                      </form>
                      <!-- <form action="includes/join-class.php" method="post" id="joinClassForm">
                          <div class="row d-flex justify-content-center">
                              <div class="col-10">
                                  <div class="input-group mb-3">
                                      <input type="text" class="form-control" value="Enter Class Code..." name="classCode" id="class_code" required>
                                  </div>
                              </div>
                              <div class="col-auto">
                                  <button type="submit" name="joinClassBtn" class="btn btn-primary green shadow-none rounded-5 px-5" id="join_class_btn">Join</button>
                              </div>
                          </div>
                          <div class="join-class-msg"></div>
                      </form> -->
                  </div>
              </div>                
      </div>
  </div>

  <!-- Announce modal -->
  <div class="modal fade" id="announceModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editProfLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">                       
              <div class="modal-content rounded-4 px-0">
                <div class="container-fluid rounded-top-4 general" id="announcement-type"></div> <!-- change class naalng here general, exam or maintenance -->
                  <div class="modal-body px-3 pb-3 mt-2">
                      <form action="">
                          <div class="container-fluid d-flex justify-content-between align-items-center">
                            
                              <div class="d-flex justify-content-center align-items-center mt-2">
                                  <div>
                                    <i class='bi bi-megaphone-fill fs-1 green1 title p-0 m-0'></i>
                                  </div>
                                  <div class="lh-1">
                                    <h1 class="title fs-1 h-font ms-3 m-0 p-0 green1 lh-1" id="className">Announcement</h1>
                                    <p class="fw-light black3 ms-3 fs-6 d-flex m-0 lh-1" id="date-text">October 12, 2024</p>   
                                  </div>
                              </div>
                              <button clas="d-flex align-items-start" type="button" class="btn-close" id="close_code" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="container-fluid mt-4 mb-4">
                              <div class="container-fluid">
                                  <div class="d-flex align-items-center justify-content-start">
                                    <p class="fw-bold black2 fs-6 d-flex m-0 lh-1" id="announcement-title">Announcement Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum</p>   
                                  </div>
                                  <div class="container-fluid d-flex align-items-center justify-content-start mt-4">
                                    <pre class="black2 fs-6" style="white-space: pre-wrap;" id="content">
                                      <?php 
                                      $text = <<<'ANNOUNCEMENT'
                                                  Dear UCCians,

                                                  We hope this message finds you safe and in good spirits. We would like to inform you of an important update concerning the academic schedule. Due to the incoming typhoon expected to affect our area, all classes and academic activities from October 11 to October 15 will be suspended. This decision has been made to prioritize the safety and well-being of our students, instructors, staff, and the entire UCC community.

                                                  During this period, we advise everyone to take the necessary precautions to stay safe. The typhoon is predicted to bring heavy rains, strong winds, and possible flooding, and we urge you to follow updates from local authorities and weather agencies.
                                                  Stay safe, UCCians!

                                                  Warm regards,
                                                  The UCC Admin Team
                                                  University of Caloocan City
                                                  ANNOUNCEMENT;

                                      echo trim($text);
                                      ?>
                                </pre> 
                                
                              </div>
                          </div>
                      </div>
                  </form>
              </div>
          </div>                
  </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://eduportal-wgrc.onrender.com/socket.io/socket.io.min.js"></script>

      <script>
          const socket = io("https://eduportal-wgrc.onrender.com", {
              transports: ["websocket"], // Ensure WebSocket transport
              timeout: 10000,            // Maximum time (ms) to wait for a connection
              reconnection: true,        // Enable auto-reconnection
              reconnectionAttempts: 5,   // Maximum attempts before giving up
              pingInterval: 25000,       // Send a ping every 25 seconds
              pingTimeout: 5000          // Wait 5 seconds for a pong before disconnecting
          });

          socket.on('connect_error', (err) => {
              console.error("Connection error:", err);
          });

          socket.on('connect', () => {
              console.log('Connected to Socket.IO server');
          });
      </script>
      <script src="scripts/announcement.js"></script>

  <script>
    
    const activeStudentCount = <?= $activeStudentCount ?>;
    const activeProfessorCount = <?= $activeProfessorCount ?>;
    const activeStaffCount = <?= $activeStaffCount ?>;
    const activeSubjectCount = <?= $activeSubjectCount ?>;


    const ctx = document.getElementById('userRoleChart').getContext('2d');
    const data = {
      labels: ['Students', 'Instructors', 'Staff', 'Classes'], // Example labels
      datasets: [{
        data: [activeStudentCount, activeProfessorCount, activeStaffCount, activeSubjectCount], // Example data values
        backgroundColor: [
          '#93C6AE',
          '#3D4E46',
          '#45775F',
          '#488C6C'
        ],
        borderColor: [
          '#93C6AE',
          '#3D4E46',
          '#45775F',
          '#488C6C'
        ],
        borderWidth: 1
      }]
    };
    const myChart = new Chart(ctx, {
      type: 'pie',
      data: data,
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          }
        }
      },
    });
    const enrollmentCounts = <?php echo $enrollmentCounts; ?>;
    const enrollmentLabels = <?php echo $labels; ?>;
    const enrollmentChart = document.getElementById('enrollmentChart').getContext('2d');
    const enrollmentData = {
      labels: enrollmentLabels, // Last 4 months
      datasets: [{
        label: 'Student enrollment for the past 4 months',
        data: enrollmentCounts,// Example data values
        backgroundColor: [
          '#93C6AE',
          '#3D4E46',
          '#45775F',
          '#488C6C'
        ],
        borderColor: [
          '#93C6AE',
          '#3D4E46',
          '#45775F',
          '#488C6C'
        ],
        borderWidth: 1
      }]
    };
    const myEnrollmentChart = new Chart(enrollmentChart, {
      type: 'bar',
      data: enrollmentData,
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          }
        }
      },
    });
    const passed = <?php echo $passed; ?>; 
    const failed = <?php echo $failed; ?>;
    const months = <?php echo $months; ?>;
    const performanceChart = document.getElementById('performanceChart').getContext('2d');
    const performanceData = {
      labels: ['September', 'October', 'November', 'December'], // Last 4 months
      datasets: [{
        label: 'Passed',
        tension: 0.4,
        data: passed, // Example data values
        backgroundColor: [
          '#93C6AE',
        ],
        borderColor: [
          '#93C6AE',
          
        ],
        borderWidth: 1
      },
      {
        label: 'Failed',
        tension: 0.4,
        data: failed, // Example data values
        backgroundColor: [
          '#45775F',
        ],
        borderColor: [
          '#45775F',
          
        ],
        borderWidth: 1
      }]
    };
    const myPerformanceChart = new Chart(performanceChart, {
      type: 'line',
      data: performanceData,
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          }
        }
      },
      scales: {
                    y: {
                        type: 'linear', // Linear scale for Y-axis
                        beginAtZero: true, // Start the Y-axis at 0
                        title: {
                            display: true,
                            text: 'Number of Students', // Y-axis title
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Months', // X-axis title
                        }
                    }
                }
    });


    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar-menu');
      sidebar.classList.toggle('active');
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
