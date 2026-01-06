<?php

if (session_id() === "") session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Form</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.19.0/js/md5.min.js"></script>

    <?php require('inc/links.php'); ?>
</head>

<body style="overflow-x: hidden;">
    <?php if (isset($_GET["class"])) {
        include("includes/view-class.php");
        include("includes/view-quiz-list.php");
        include("includes/view-quiz.php");

        

        
    } ?>

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
                                <li class="nav-item">
                                    <a class="nav-link" href="grades.php?class=<?php echo md5($details[0]["class_code"]); ?>">Grades</a>
                            </li>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="grades.php?class=<?php echo md5($details[0]["class_code"]); ?>">Grades</a>
                            </li>
                            </ul>
                        </div>
                    </div>
                    
                </nav>
                <div class="container mt-4 px-lg-5 px-sm-2">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h1 id="material-title" class="h-font green1 me-2 sub-title"><?php if($postDetails[0]["content_type"] == "Exam") echo $examTitle[0]["title"]; else echo $title; ?></h1>
                            <label id="material-start-date" class="fw-light black2 fs-6 d-flex m-0">Starting Date: <?php echo $startingDateTime; ?></label>
                            <label id="material-end-date " class="fw-light black2 fs-6 d-flex m-0">Deadline Date: <?php echo $deadlineDateTime; ?></label>
                            <label class="fw-semibold green2 fs-6 m-0">Attempt(s): </label><label  id="attempt-text" class="fw-semibold green2 fs-6 ms-2 m-0"> <?php echo $attempt; ?></label>
                        </div>
                        <div class="dropdown">
                            <a class="nav-link dropdown-menu1" href="#" id="menu-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="me-2 bi bi-gear green2 fs-3 icon"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item h-font green2 fs-5" href="" data-bs-toggle="modal" data-bs-target="#editPostModal">Edit</a></li>
                                <li><a class="delete-btn dropdown-item h-font green2 fs-5" href="">Delete</a></li>
                            </ul>
                        </div>
                    </div>
               
                    <div>
                        <form id="quiz-form">
                        <br>
                        <div id="questions-container">
                            <?php if (!empty($groupedQuestions)) {
                                // echo var_dump($groupedQuestions);
                                $questionCount = 1;
                                foreach ($groupedQuestions as $question) {
                                    $questionId = $question["question_id"];
                                    $questionText = htmlspecialchars($question['question_text']);
                                    $questionType = $question['question_type'];
                                    $points = $question['points'];
                                    $options = $question['options'];
                                    $answerKey = htmlspecialchars($question['ans_key']);
                            ?>
    
                                <div class="question" data-id="<?= $questionCount ?>">
                                    <!-- Question Header -->
                                     <!-- Contaisn the question id in db NOTE: Ecrpyted -->
                                    <div class="question-num" hidden><?php echo md5($questionId); ?></div> 
                                    <div class="row mb-3 d-flex align-items-center">
                                        <div class="d-flex col-lg-6 align-items-center px-0 m-0">
                                            <div class="row container-fluid m-0">
                                                <div class="col-lg-3 d-flex align-items-center m-0 p-0">
                                                    <span class="form-label question_count black3 fs-6" >Question <?= $questionCount ?>:</span>
                                                </div>
                                                <div class="col-lg-9 d-flex align-items-center container-fluid m-0 p-0">
                                                    <textarea class="form-control question-text container-fluid black3 w-100" placeholder="Enter question" required><?= $questionText ?></textarea>
                                                </div>
                                            </div>
                                        </div>
    
                                        <!-- Question Type -->
                                        <div class="col-lg-4 d-flex align-items-center m-0 p-0">
                                            <div class="row container-fluid m-0">
                                                <div class="col-lg-3 d-flex align-items-center m-0 p-0">
                                                    <span class="form-label black3 fs-6 ">Question Type:</span>
                                                </div>
                                                <div class="col-lg-9 d-flex align-items-center container-fluid m-0 p-0">
                                                    <select class="rounded-2 question-type fs-6 form-select shadow-elevation-light-3 black3">
                                                        <option value="multiple-choice" <?= ($questionType === "multiple-choice") ? "selected" : "" ?>>Multiple Choice</option>
                                                        <option value="short-text" <?= ($questionType === "short-text") ? "selected" : "" ?>>Short Text</option>
                                                        <option value="true-false" <?= ($questionType === "true-false") ? "selected" : "" ?>>True/False</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
    
                                        <!-- Points -->
                                        <div class="d-flex col-lg-2 align-items-center m-0 p-0">
                                            <div class="row d-flex align-items-center m-0 container-fluid">
                                                <div class="col-lg-4 container-fluid d-flex align-items-center px-0 m-0">
                                                <span class="form-label black3 fs-6" >Point:</span>
                                                </div>
                                           
                                                <div class="col-lg-8 shadow-elevation-light-3 black3 rounded-2 container-fluid d-flex align-items-center px-0 m-0">
                                                <input type="number" class="points rounded-4 container-fluid border-0 py-2 black3" value="<?= $points ?>" min="1" max="100" placeholder="Enter number" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    
                                    <!-- Question Types -->
                                    <?php if ($questionType === "multiple-choice") { ?>
                                        <div class="options">
                                            <label class="black3">Choices:</label>
                                            <div class="option-container">
                                                <?php foreach ($options as $option) { ?>
                                                    <div class="option mt-1 col-lg-7 col-12 d-flex align-items-center">
                                                        <div class="form-floating col-8">
                                                            <input type="text" class="optionText form-control rounded-2" value="<?= htmlspecialchars($option) ?>" placeholder="Enter Choice" name="multiChoice[]" required>
                                                            <label class="black3">Enter Choice</label>
                                                        </div>
                                                        <a href="#" class="remove-choice"><button class="delete btn btn-secondary shadow-none fw-medium fs-6 ms-2">X</button></a>
                                                        <a href="#" class="select_ans_key"><button class="answ_key btn btn-success shadow-none fw-medium fs-6 ms-2">Answer Key</button></a>
                                                    </div>
                                                <?php } ?>
                                                <div class="ans-key-cont form-floating col-lg-7 col-12 d-flex align-items-center mt-2">
                                                    <input type="text" class="answer_key form-control rounded-2" value="<?= $answerKey ?>" placeholder="Answer Key" readonly>
                                                    <label class="black3">Answer Key</label>
                                                </div>
                                                <button type="button" class="btn btn-secondary add-choice green shadow-none mt-2 fw-medium fs-6">Add Choice</button>
                                                <button type="button" class="btn btn-danger remove-question ms-auto redbtn shadow-none mt-2 fw-medium fs-6">Remove Question</button>
                                            </div>
                                        </div>
    
                                        <div class="short-text-select" style="display: none">
                                            <div class="mt-1 col-lg-7 col-12 d-flex align-items-center">
                                                <div class="form-floating col-lg-7 col-12 container-fluid">
                                                    <input type="text" class="short_ans_key form-control rounded-2" value="<?= $answerKey ?>" placeholder="Enter Answer Key">
                                                    <label class="black3">Enter Answer Key</label>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-danger remove-question ms-auto redbtn shadow-none mt-2 fw-medium fs-6">Remove Question</button>
                                        </div>
        
                                        <div class="true-false-select col-4" style="display: none">
                                            <span class="form-label black3 fs-6">Select Answer Key:</span>
                                            <select class="booleanSelect rounded-2 fs-6 form-select shadow-elevation-light-3 black3 border-0">
                                                <option value="True">True</option>
                                                <option value="False">False</option>
                                            </select><br>
                                            <button type="button" class="btn btn-danger remove-question ms-auto redbtn shadow-none mt-2 fw-medium fs-6">Remove Question</button>
                                        </div>
    
    
                                    <?php } elseif ($questionType === "true-false") { ?>
                                        <div class="true-false-select col-4">
                                            <span class="form-label black3 fs-6">Select Answer Key:</span>
                                            <select class="booleanSelect rounded-2 fs-6 form-select shadow-elevation-light-3 black3">
                                                <option value="True" <?= ($answerKey === "True") ? "selected" : "" ?>>True</option>
                                                <option value="False" <?= ($answerKey === "False") ? "selected" : "" ?>>False</option>
                                            </select><br>
                                            <button type="button" class="btn btn-danger remove-question ms-auto redbtn shadow-none mt-2 fw-medium fs-6">Remove Question</button>
                                        </div>
    
                                        <div class="options" style="display: none">
                                            <label>CHOICES:</label>
                                            <div class="option-container">
                                                    <div class="option mt-1  col-lg-7 col-12 d-flex align-items-center">
                                                        <div class="form-floating col-8">
                                                            <input type="text" class="optionText form-control rounded-2" placeholder="Enter Choice" name="multiChoice[]">
                                                            <label class="black3">Enter Choice</label>
                                                        </div>
                                                        <a href="#" class="remove-choice"><button class="delete btn btn-secondary shadow-none fw-medium fs-6 ms-2">X</button></a>
                                                            <a href="#" class="select_ans_key"><button class="answ_key btn btn-success shadow-none mt-2 fw-medium fs-5 ms-2">Answer Key</button></a>
                                                    </div>
    
                                                <div class="ans-key-cont form-floating col-lg-7 col-12 d-flex align-items-center">
                                                    <input type="text" class="answer_key form-control rounded-2" value="<?= $answerKey ?>" placeholder="Answer Key" readonly>
                                                    <label class="black3">Answer Key</label>
                                                </div>
                                                <button type="button" class="btn btn-secondary add-choice green shadow-none mt-2 fw-medium fs-6">Add Choice</button>
                                                <button type="button" class="btn btn-danger remove-question ms-auto redbtn shadow-none mt-2 fw-medium fs-6">Remove Question</button>
                                            </div>
                                        </div>
    
                                        <div class="short-text-select" style="display: none">
                                            <div class="mt-1 col-lg-7 col-12 d-flex align-items-center">
                                                <div class="form-floating col-lg-7 col-12">
                                                    <input type="text" class="short_ans_key form-control rounded-2" value="<?= $answerKey ?>" placeholder="Enter Answer Key">
                                                    <label class="black3">Enter Answer Key</label>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-danger remove-question ms-auto redbtn shadow-none mt-2 fw-medium fs-6">Remove Question</button>
                                        </div>
    
                                    <?php } elseif ($questionType === "short-text") { ?>
                                        <div class="short-text-select">
                                            <div class="mt-1 col-lg-7 col-12 d-flex align-items-center">
                                                <div class="form-floating col-lg-7 col-12">
                                                    <input type="text" class="short_ans_key form-control rounded-2" value="<?= $answerKey ?>" placeholder="Enter Answer Key">
                                                    <label class="black3">Enter Answer Key</label>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-danger remove-question ms-auto redbtn shadow-none mt-2 fw-medium fs-6">Remove Question</button>
                                        </div><br>
    
                                        <div class="true-false-select col-4" style="display: none">
                                            <span class="ms-2 form-label black3 fs-6">Select Answer Key:</span>
                                            <select class="booleanSelect rounded-2 fs-6 form-select shadow-elevation-light-3 black3">
                                                <option value="True">True</option>
                                                <option value="False">False</option>
                                            </select>
                                            <button type="button" class="btn btn-danger remove-question ms-auto redbtn shadow-none mt-2 fw-medium fs-6">Remove Question</button>
                                        </div>
    
                                        <div class="options" style="display: none">
                                            <label>CHOICES:</label>
                                            <div class="option-container">
                                                    <div class="option mt-1  col-lg-7 col-12 d-flex align-items-center">
                                                        <div class="form-floating col-8">
                                                            <input type="text" class="optionText form-control rounded-2" placeholder="Enter Choice" name="multiChoice[]"> 
                                                            <label class="black3">Enter Choice</label>
                                                        </div>
                                                        <a href="#" class="remove-choice"><button class="delete btn btn-secondary shadow-none fw-medium fs-6 ms-2">X</button></a>
                                                        <a href="#" class="select_ans_key"><button class="answ_key btn btn-success shadow-none mt-2 fw-medium fs-5 ms-2">Answer Key</button></a>
                                                    </div>
    
                                                <div class="ans-key-cont form-floating col-lg-7 col-12 d-flex align-items-center">
                                                    <input type="text" class="answer_key form-control rounded-2" value="<?= $answerKey ?>" placeholder="Answer Key" readonly>
                                                    <label class="black3">Answer Key</label>
                                                </div>
                                                <button type="button" class="btn btn-secondary add-choice green shadow-none mt-2 fw-medium fs-6">Add Choice</button>
                                                <button type="button" class="btn btn-danger remove-question ms-auto redbtn shadow-none mt-2 fw-medium fs-6">Remove Question</button>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <hr>
                                </div>
                            <?php
                                $questionCount++;
                                }
                            } ?>
                        </div>
                         <div class="d-flex justify-content-between align-items-center mt-4">
                        <button type="button" id="add-question" class="btn btn-secondary green shadow-none fw-medium fs-6">Add Question</button>
                        <input type="submit" class="btn white2 green shadow-none fw-medium fs-6" id="saveQuiz" value="Save Quiz">
                    </div>
                </form>
                    </div>
                <div>

            <br>
            <a href="quiz-list.php?class=<?php echo md5($details[0]["class_code"]); ?>"><button class="btn btn-secondary white2 shadow-none mt-2 fw-medium fs-6">Back To Quiz List</button></a>

            </div>

            <br><br><br>
        </div>
    </div>

       <!-- EDIT POST MODAL -->
       <div class="modal fade" id="editPostModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editPostLabel" >
        <div class="modal-dialog modal-dialog-centered modal-lg">                       
                <div class="modal-content rounded-4">
                    <form method="post" id="editForm">
                    <div class="modal-body">
                            <div class="container-fluid mb-3 d-flex justify-content-between align-items-center">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div>
                                        <i class='bi bi-pencil-square fs-1 green1 title p-0 m-0'></i>
                                    </div>
                                    <div class="lh-sm">
                                        <h1 class="title fs-1 h-font ms-3 m-0 p-0 green1" id="className">Edit Post</h1>
                                    </div>
                                </div>
                                <button clas="d-flex align-items-start" type="button" class="btn-close" id="close_code" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="row px-2">
                                <div class="col-lg-12 mb-2">
                                    <label class="form-label black3 mb-0">Title</label>
                                    <input type="text" class="form-control black3 shadow-elevation-light-3 container-fluid" value="<?php echo $postDetails[0]["title"]; ?>" name="post_title" id="postTitle">
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label class="form-label black3 mb-0">Description</label>
                                    <textarea type="text" rows="4" class="form-control black3 shadow-elevation-light-3 container-fluid" value="" name="post_desc" id="postDesc"><?php echo $postDetails[0]["content"]; ?></textarea>
                                </div>

                                        <div class="col-lg-1 col-sm-12 mb-2">
                                            <label class="black3 mb-0">Attempts</label>
                                        </div>
                                        <div class="col-lg-3 col-sm-6 mb-2">
                                            <input type="number" class="attempts form-control black3 shadow-elevation-light-3 container-fluid border-0 w-100" min="1" value="<?php echo $quizContent1[0]["attempt"]; ?>" name="attempts" id="attempts">
                                        </div>
                                        <!-- <div class="col-lg-5 mb-2"></div> -->
                                        <div class="col-lg-1 col-sm-12 mb-2">
                                            <label class="black3 mb-0">From</label>
                                        </div>

                                        <div class="col-lg-3 col-sm-6 mb-2">
                                            <input type="date" class="form-control black3 shadow-elevation-light-3 container-fluid border-0 w-100" value="<?php echo $quizContent1[0]["starting_date"]; ?>" name="post_title" id="startDate">
                                        </div>
                                        <div class="col-lg-3 col-sm-6 mb-2">
                                            <input type="time" class="form-control black3 shadow-elevation-light-3 container-fluid border-0 w-100" value="<?php echo $quizContent1[0]["starting_time"]; ?>" name="post_title" id="startTime">
                                        </div>

                                        <div class="col-lg-4 mb-2"></div>
                                        <div class="col-lg-1 col-sm-12 mb-2">
                                            <label class="black3 mb-0">To</label>
                                        </div>
                            
                                        <div class="col-lg-3 col-sm-6 mb-2">
                                            <input type="date" class="form-control black3 shadow-elevation-light-3 container-fluid border-0 w-100" value="<?php echo $quizContent1[0]["deadline_date"]; ?>" name="post_title" id="deadlineDate">
                                        </div>
                                        
                                        <div class="col-lg-3 col-sm-6 mb-2">
                                            <input type="time" class="form-control black3 shadow-elevation-light-3 container-fluid border-0 w-100" value="<?php echo $quizContent1[0]["deadline_time"]; ?>" name="post_title" id="deadlineTime">
                                        </div>
                                
                                <div class="col-lg-4 mb-2"></div>
                                <div class="col-lg-12 mb-2">
                                    
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center gap-1 my-2">
                                <button type="submit" class="btn green shadow-none border-none rounded-5 px-4 py-2" id="edit_quiz">Edit Post</button>
                                <button class="btn bordergreen green1 rounded-5 px-4 py-2" type="button" class="btn-close" id="close_code" data-bs-dismiss="modal" aria-label="Close">Back</button>
                            </div>
                            <input type="file" id="fileInput" name="files[]" style="display: none;" multiple>
                            </form>   
                        </div> 
                    </div>
 
                </div>             
        </div>
    </div>
    <div id="content-type" hidden><?php echo $postDetails[0]["content_type"];?></div>

    <?php require('inc/footer.php'); ?>
    <script src="scripts/edit-post.js"></script>
    <script src="scripts/create-quiz.js"></script>
    <script src="scripts/delete-post.js"></script>

    <!-- You can see the question format inside here, try to preserve the div names and element hierarchy -->
    <!-- Check check niyo nalang din kung working siya and walang error habang ginagawa, sa console log niyo mkaikita yung messages -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>