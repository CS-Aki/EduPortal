<?php
if (session_id() === "") session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
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

        input[type="radio"] {
            appearance: none;
            /* Remove default styling */
            width: 20px;
            height: 20px;
            border: 2px solid #ccc;
            border-radius: 50%;
            outline: none;
            cursor: pointer;
            transition: border-color 0.3s, background-color 0.3s;
        }

        input[type="text"] {
            border: 1px solid #989598 !important;
            color: #989598 !important;
        }

        input[type="radio"]:checked {
            background-color: #219E53 !important;
            border-color: #219E53 !important;
        }
    </style>
    <?php require('inc/links.php'); ?>
</head>

<body>
    <?php if (isset($_GET["class"])) {
    } ?>
    <?php require('inc/header.php');  include("student backend/includes/view-quiz.php"); ?>

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
                                    <a class="nav-link active" href="class.php?class=<?php echo md5($postDetails[0]["class_code"]); ?>">Class Name</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="submittedworks.php?class=<?php echo md5($postDetails[0]["class_code"]); ?>">Submitted Works</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="list.php?class=<?php echo md5($postDetails[0]["class_code"]); ?>">List of Students</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <?php echo var_dump($submittedQuiz);?>
                    <div class="container mt-4 px-lg-5 px-sm-2">
                        <form id="quiz-answer-form">
                            <div class="form-container">
                                <h1 class="h-font green1 fs-1 me-2 mb-3" id="material-title"><?php echo $quizDetails[0]["title"]; ?></h1>
                                <!-- <input type="text" id="quiz-title" placeholder="Quiz Title" readonly><br><br> -->
                                <?php

                                $questionTitle = "";
                                $questionCount = 1;
                                $choiceCount = 1; // Pwedeng alisin 'to if pangit tignan, paki-alis nalang din nung mga variable na choiceCount below

                                for ($i = 0; $i < count($quizDetails); $i++) {
                                    if ($questionTitle == $quizDetails[$i]["question_text"]) {
                                        // For multiple-choice or true/false questions, add other choices to the existing question
                                        $choiceCount++;
                                        echo "<div class='col-lg-6 d-flex align-items-center gap-2 mb-1'>
                                                <input type='radio' id='{$quizDetails[$i]['question_id']}_{$choiceCount}' 
                                                name='{$quizDetails[$i]['question_id']}' 
                                                value='{$quizDetails[$i]["option_text"]}' required>
                                                <label for='{$quizDetails[$i]['question_id']}_{$choiceCount}'> 
                                                {$quizDetails[$i]["option_text"]}
                                                </label>
                                            </div>";
                                    } else {
                                        // Close the previous question block if it's not the first question
                                        if ($i > 0) {
                                            echo "</div>"; // Closing the row
                                            echo "</div>"; // Closing the question-container
                                        }

                                        // Start a new question block
                                        echo "<div class='question-container quizborder mb-2 py-4 rounded-4 px-5 black2 question-id-{$quizDetails[$i]['question_id']}'>";

                                        // Question Header
                                        echo "<label class='fw-semibold'>Question Number {$questionCount} :</label>
                                      <label class='fw-semibold green2'>Points : {$quizDetails[$i]["points"]}</label><br>
                                      <label class='black2 fw-bold'>Question: <span class='fw-normal'>{$quizDetails[$i]['question_text']}</span></label><br><br>";

                                        // Start the row for the choices
                                        echo "<div class='row'>";

                                        if ($quizDetails[$i]["question_type"] == "short-text") {
                                            // Short-text question
                                            echo "<div class='col-12'>
                                            <input class='w-100 rounded-4 p-2' type='text' id='{$quizDetails[$i]['question_id']}' 
                                                   name='{$quizDetails[$i]['question_id']}' required>
                                          </div><br><br>";
                                        } else {
                                            // New multiple-choice or true/false question
                                            $questionTitle = $quizDetails[$i]["question_text"];
                                            $choiceCount = 1; // Reset choice counter for new question
                                            echo "<div class='col-lg-6 d-flex align-items-center gap-2 mb-1'>
                                            <input type='radio' id='{$quizDetails[$i]['question_id']}_{$choiceCount}' 
                                                   name='{$quizDetails[$i]['question_id']}' 
                                                   value='{$quizDetails[$i]["option_text"]}' required>
                                            <label for='{$quizDetails[$i]['question_id']}_{$choiceCount}'> 
                                                 {$quizDetails[$i]["option_text"]}
                                            </label>
                                          </div>";
                                        }

                                        $questionCount++; // Increment question number
                                    }
                                }

                                if (count($quizDetails) > 0) {
                                    echo "</div>"; // Closing the row
                                    echo "</div>"; // Closing the question-container
                                }
                                ?>
                                <div class="d-flex justify-content-end align-items-center gap-2 mt-3">
                                    <button type="submit" class="btn green px-4 py-2">Submit Quiz</button>
                                    <a href="material.php?class=<?php echo md5($postDetails[0]["class_code"]); ?>&post=<?php echo md5($postDetails[0]["post_id"]); ?>"><button type="button" class="btn btn-secondary px-4 py-2">Back</button></a><br><br>
                                </div>
                                <br><br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="postIdValue" hidden><?php echo $postDetails[0]["post_id"]; ?></div>
    <div id="classCodeValue" hidden><?php echo $postDetails[0]["class_code"]; ?></div>

    <script src="scripts/submit-quiz.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>