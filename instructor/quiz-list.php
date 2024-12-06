<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.19.0/js/md5.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .question {
            margin-bottom: 15px;
        }

        .options,
        .question-settings {
            margin-top: 10px;
        }

        button {
            margin-top: 20px;
        }

        textarea.form-control {
            resize: none;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .options .form-floating {
            margin-bottom: 10px;
        }

        .d-flex.align-items-center {
            display: flex;
            align-items: center;
        }
    </style>
    <?php require('inc/links.php'); if (session_id() === "") session_start();
    $_SESSION["displayQuiz"] = "display"; 
 ?>

</head>

<body>
<?php if(isset($_GET["class"])){ include("includes/view-class.php"); include("includes/view-quiz-list.php"); } ?>

    <?php require('inc/header.php'); ?>
    <div class="container-fluid p-0 m-0" id="main-content">
        <div class="row">
            <div class="col-lg-10 col-sm-12 ms-auto">
                <nav class="navbar navbar-expand-lg sticky-top line fs-5 z-2" style="background-color: white">
                    <div class="container-fluid sticky-top">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse green1" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link active" href="class.php?class=<?php echo md5($details[0]["class_code"]); ?>">Class Name</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="submittedworks.php?class=<?php echo md5($details[0]["class_code"]); ?>">Submitted Works</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="list.php?class=<?php echo md5($details[0]["class_code"]); ?>">List of Students</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>



                    <div class="p-3">
                        <!-- <h1 class="green1">Create Quiz</h1>
                        <form id="quiz-form">
                             <input type="text" id="quiz-title" placeholder="Quiz Title" required><br><br>
                            <div class="form-floating col-8 ms-3">
                                <textarea id="quiz-title" class="form-control rounded-2 question-text" placeholder="Quiz Title" required="" style="height: 2rem; width: 30vw;"></textarea>
                                <label for="floatingTextarea2" class="black3">Quiz Title</label>
                            </div>
                            <hr>
                            <div id="questions-container" class="ms-2"></div>
                            <button type="button" id="add-question" class="btn btn-secondary">Add Question</button><br><br>
                            <button type="submit" class="btn btn-info">Save Quiz</button>
                        </form> -->
                        
                        <hr>  

                        <div class="container my-5">
                            <div class="container-fluid d-flex justify-content-between align-items-center mb-2">
                                <h1 class="green1">Quiz List</h1>
                                <h1 class="h-font green1 me-2 sub-title mb-0" id="material-title"></h1>
                                <a href="post-form.php?class=<?php echo md5($details[0]["class_code"]); ?>"><button type="button" class="btn fs-5 green shadow-none white2 d-flex align-items-center justify-content-center py-0 px-4 rounded-5" data-bs-toggle="modal" data-bs-target="#createClassModal">
                                    <i class="bi bi-plus-lg white2 me-1 fs-2"></i>Create
                                </button></a>
                            </div>
                            
                            <!-- <form action="includes/quizzes.php" method="post" id="quizForm"> -->
                                <table>
                                    <thead style="background-color: var(--green2); color: white;">
                                        <tr>
                                            <th hidden>Quiz ID</th>
                                            <th>Quiz Title</th>
                                            <th>Starting Date/Time</th>
                                            <th>Deadline</th>
                                            <th>Quiz Status</th>
                                            <th colspan="2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="quizTableBody">
                                        <?php 
                                            for($i = 0; $i < count($quiz); $i++){
                                                for ($i = 0; $i < count($quiz); $i++) {
                                                    // Convert starting and deadline times into AM/PM format
                                                    $startingDateTime = date("F j, Y g:i A", strtotime($quiz[$i]["starting_date"] . " " . $quiz[$i]["starting_time"]));
                                                    $deadlineDateTime = date("F j, Y g:i A", strtotime($quiz[$i]["deadline_date"] . " " . $quiz[$i]["deadline_time"]));
                                                
                                                    echo "
                                                        <tr>
                                                            <td hidden>{$quiz[$i]["post_id"]}</td>
                                                            <td>{$quiz[$i]["title"]}</td>
                                                            <td>{$startingDateTime}</td>
                                                            <td>{$deadlineDateTime}</td>
                                                            <td>{$quiz[$i]["status"]}</td>
                                                            <td>
                                                                <a href='quiz-form.php?class=" . md5($details[0]["class_code"]) . "&post=" . md5($quiz[$i]["post_id"]) . "'>
                                                                    <i title='View' class='bi bi-eye green2 fs-2'></i>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <a href='#'>
                                                                    <i title='Remove' class='bi bi-x text-danger fs-1'></i>
                                                                </a>
                                                            </td>
                                                        </tr>";
                                                }                                                
                                            }
                                        ?>
                                        <!-- <tr>
                                            <td hidden>id here to fetch the title</td>
                                            <td>Quiz 1</td>
                                            <td>2024-12-01 10:00 AM</td>
                                            <td>2024-12-10 11:59 PM</td>
                                            <td>Active</td>
                                            <td>
                                                <a href="#"><i title="View" class="bi bi-eye green2 fs-2"></i></a>
                                            </td>
                                            <td>    
                                                <a href="#"><i title="Remove" class="bi bi-x text-danger fs-1"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td hidden>2</td>
                                            <td>Sample Quiz 2</td>
                                            <td>2024-12-02 02:00 PM</td>
                                            <td>2024-12-12 11:59 PM</td>
                                            <td>Inactive</td>
                                            <td>
                                                <a href="#"><i title="View" class="bi bi-eye green2 fs-2"></i></a>
                                            </td>
                                            <td>    
                                                <a href="#"><i title="Remove" class="bi bi-x text-danger fs-1"></i></a>
                                            </td>
                                        </tr> 
                                         di aq marunong mag add ng rows / mag detect,, willing matuto if may time -->
                                    </tbody>
                                </table>
                            <!-- </form> -->
                        </div>

                        <style>
                            table {
                                width: 100%;              
                                border-collapse: collapse; 
                                color: var(--black1)
                            }

                            th, td {
                                border: 1px solid var(--black3); 
                                text-align: center;              
                                vertical-align: middle;          
                                padding: 10px;                   
                            }
                            thead th {
                                position: sticky;       
                                top: 0;                   
                                z-index: 2;                
                                background-color: var(--green2); 
                                color: white;              
                            }
                            th[colspan] {
                                text-align: center; 
                            }
                            .scroll-btn {
                                position: fixed;
                                bottom: 20px;
                                right: 20px;
                                z-index: 1000;
                            }
                        </style>
                        
                    </div> 
                            
                    <!-- Scroll to Bottom Button -->
                    <button class="btn btn-secondary scroll-btn" onclick="scrollToBottom()">See quiz list</button>

                </div>
            </div>
        </div>

        <!-- You can see the question format inside here, try to preserve the div names and element hierarchy -->
        <!-- Check check niyo nalang din kung working siya and walang error habang ginagawa, sa console log niyo mkaikita yung messages  --> <!-- ok na no bug so far -->
        <!-- <script src="scripts/create-quiz.js">  </script> -->
        <script> 
            function scrollToBottom() {
                window.scrollTo({
                    top: document.body.scrollHeight,  // Scroll to the bottom of the page
                    // behavior: 'smooth'                // Smooth scroll animation
                });
            }
        </script>


        <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>