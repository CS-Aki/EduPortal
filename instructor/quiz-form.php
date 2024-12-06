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
    <?php require('inc/links.php'); ?>

</head>

<body>
<?php if(isset($_GET["class"])){ include("includes/view-class.php"); include("includes/view-quiz-list.php"); include("includes/view-quiz.php"); } ?>

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

                    <h1><?php echo $quiz[0]["title"]; ?></h1>
                    <form id="quiz-form">
                        <!-- <input type="text" id="quiz-title" placeholder="Quiz Title" required><br><br> -->
                         <br>
                        <div id="questions-container">
                        <?php if (!empty($groupedQuestions)) {
                                    $questionCount = 1;
                                    foreach ($groupedQuestions as $question) {
                                        $questionId = $question['question_id'];
                                        $questionType = $question['question_type'];
                                        $questionText = $question['question_text'];
                                        $points = $question['points'];
                                        $title = $question['title'];
                                        $ansKey = $question['ans_key'];
                                        $options = $question['options'];

                                        echo <<<HTML
                                        <div class="question id" data-id="{$questionId}">
                                            <div class="input-group row mb-3">
                                                <div class="d-flex col-6">
                                                    <span style="font-size: large;" class="question_count form-label col-3">Question {$questionCount}:</span>
                                                    <div class="form-floating col-8">
                                                        <textarea class="form-control rounded-2 question-text" placeholder="Enter question" required>{$questionText}</textarea>
                                                        <label for="floatingTextarea2" class="black3">Enter question</label>
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <span style="font-size: large;" class="ms-2 form-label">Question Type:</span>
                                                    <select class="rounded-2 question-type">
                                                        <option value="multiple-choice" <?php echo ($questionType == "multiple-choice") ? "selected" : ""; ?>Multiple Choice</option>
                                                        <option value="short-text" <?php echo ($questionType == "short-text") ? "selected" : ""; ?>Short Text</option>
                                                        <option value="true-false" <?php echo ($questionType == "true-false") ? "selected" : ""; ?>True/False</option>
                                                    </select>
                                                </div>

                                                <div class="d-flex col-2">
                                                    <span style="font-size: large;" class="ms-2 form-label">Point:</span>
                                                    <div class="form-floating ms-2" style="flex: 1;">
                                                        <input type="number" class="points rounded-2 ps-2" value="{$points}" min="1" max="100" placeholder="Enter number" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="options">
                                                <label>CHOICES:</label>
                                                <div class="option-container">
                                HTML;

                                        // Render each option dynamically
                                        foreach ($options as $option) {
                                            $isAnswerKey = ($option == $ansKey) ? 'selected' : '';
                                            echo <<<HTML
                                                    <div class="option mt-1 col-7 d-flex align-items-center">
                                                        <div class="form-floating col-8">
                                                            <input type="text" class="optionText form-control rounded-2 remove_text" placeholder="Enter Choice" name="multiChoice[]" value="{$option}" id="floatingText1">
                                                            <label for="floatingText" class="black3">Enter Choice</label>
                                                        </div>
                                                        <a href="#" class="remove-choice"><button class="btn btn-danger shadow-none mt-2 fw-medium fs-5 ms-2">X</button></a>
                                                        <a href="#" class="select_ans_key"><button class="btn btn-success shadow-none mt-2 fw-medium fs-5 ms-2">Answer Key</button></a>
                                                    </div>
                                HTML;
                                        }

                                        // Render the answer key
                                        echo <<<HTML
                                                    <div class="ans-key-cont form-floating col-6 d-flex align-items-center">
                                                        <input type="text" class="answer_key form-control rounded-2 remove_text" placeholder="Answer Key" name="multiChoice[]" value="{$ansKey}" id="floatingText1" readonly>
                                                        <label for="floatingText" class="black3">Answer Key</label>
                                                    </div>
                                                    <button type="button" class="btn btn-secondary add-choice">Add Choice</button>
                                                    <button type="button" class="btn btn-danger remove-question ms-auto">Remove Question</button>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                HTML;
                                    }
                                }
                        ?>

                        </div>
                        <button type="button" id="add-question" class="btn btn-secondary">Add Question</button><br><br>
                        <button type="submit" class="btn btn-info">Save Quiz</button>
                    </form>
                    <br><br><br>
                    <a href="quiz-list.php?class=<?php echo md5($details[0]["class_code"]); ?>"><button class="btn btn-secondary">Back To Quiz List</button></a>

                </div>
                
            </div>
            
        </div>

        <!-- You can see the question format inside here, try to preserve the div names and element hierarchy -->
        <!-- Check check niyo nalang din kung working siya and walang error habang ginagawa, sa console log niyo mkaikita yung messages -->
        <script src="scripts/create-quiz.js">

        </script>

        <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>