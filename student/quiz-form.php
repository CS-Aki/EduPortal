<?php 
    if (session_id() === "") session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Maker with Question Types</title>
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
<?php if(isset($_GET["class"])){ include("student backend/includes/view-quiz.php"); } ?>
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
                <!-- Display this if quiz has not been answered -->
                <?php if($submittedQuiz == null){ ?>
                   <form id="quiz-answer-form">
                        <div class="form-container">
                        <h1><?php echo $quizDetails[0]["title"]; ?></h1>
                        <!-- <input type="text" id="quiz-title" placeholder="Quiz Title" readonly><br><br> -->
                    <?php        
                        $questionTitle = "";
                        $questionCount = 1;
                        $choiceCount = 1; // Pwedeng alisin 'to if pangit tignan, paki-alis nalang din nung mga variable na choiceCount below

                        for ($i = 0; $i < count($quizDetails); $i++) {
                            if ($questionTitle == $quizDetails[$i]["question_text"]) {
                                // Add other choices to questions (for true/false or multiple-choice questions)
                                $choiceCount++;
                                echo "<input type='radio' id='{$quizDetails[$i]['question_id']}_{$choiceCount}' 
                                      name='{$quizDetails[$i]['question_id']}' 
                                      value='{$quizDetails[$i]["option_text"]}' required>
                                      <label for='{$quizDetails[$i]['question_id']}_{$choiceCount}'> 
                                      Choice {$choiceCount} : {$quizDetails[$i]["option_text"]}</label><br><br>";
                            } else {
                                // HTML Elements for Short Text
                                if ($quizDetails[$i]["question_type"] == "short-text") {
                                    echo "<div class='question-id-{$quizDetails[$i]['question_id']}'>";
                                    echo "<label>Question Number {$questionCount} : </label> 
                                          <label>POINTS : {$quizDetails[$i]["points"]}</label><br>";
                                    echo "<label>Question Text : {$quizDetails[$i]['question_text']} </label><br><br>";
                                    echo "<input type='text' id='{$quizDetails[$i]['question_id']}' 
                                          name='{$quizDetails[$i]['question_id']}' required><br><br>";
                                    echo "</div>";
                                } else {
                                    $questionTitle = $quizDetails[$i]["question_text"];
                                    $choiceCount = 1;
                                    echo "<div class='question-id-{$quizDetails[$i]['question_id']}'>";
                                    echo "<label>Question Number {$questionCount} : </label> 
                                          <label>POINTS : {$quizDetails[$i]["points"]}</label><br>";
                                    echo "<label>Question Text : {$quizDetails[$i]['question_text']} </label><br><br>";
                                    echo "<input type='radio' id='{$quizDetails[$i]['question_id']}_{$choiceCount}' 
                                          name='{$quizDetails[$i]['question_id']}' 
                                          value='{$quizDetails[$i]["option_text"]}' required>
                                          <label for='{$quizDetails[$i]['question_id']}_{$choiceCount}'> 
                                          Choice {$choiceCount} : {$quizDetails[$i]["option_text"]}</label><br><br>";
                                    echo "</div>";
                                }
                                $questionCount++;
                            }
                        } 
                    ?>

                        <button type="submit" class="btn btn-info">Submit Quiz</button>
                        <button type="button" id="add-question" class="btn btn-secondary">Back</button><br><br>
                        </div>
                    </form>

                     <!-- Display Quiz Results -->
                    <?php } else{ echo var_dump($submittedQuiz);
                                    echo "<label></label>";
                                    $questionTitle = "";
                                    $questionCount = 1;
                                    $choiceCount = 1; // Pwedeng alisin 'to if pangit tignan, paki-alis nalang din nung mga variable na choiceCount below

                                    for ($i = 0; $i < count($quizDetails); $i++) {
                                        if ($questionTitle == $quizDetails[$i]["question_text"]) {
                                            // Add other choices to questions (for true/false or multiple-choice questions)
                                            $choiceCount++;
                                            echo "<input type='radio' id='{$quizDetails[$i]['question_id']}_{$choiceCount}' 
                                                name='{$quizDetails[$i]['question_id']}' 
                                                value='{$quizDetails[$i]["option_text"]}' required>
                                                <label for='{$quizDetails[$i]['question_id']}_{$choiceCount}'> 
                                                Choice {$choiceCount} : {$quizDetails[$i]["option_text"]}</label><br><br>";
                                        } else {
                                            // HTML Elements for Short Text
                                            if ($quizDetails[$i]["question_type"] == "short-text") {
                                                echo "<div class='question-id-{$quizDetails[$i]['question_id']}'>";
                                                echo "<label>Question Number {$questionCount} : </label> 
                                                    <label>POINTS : {$quizDetails[$i]["points"]}</label><br>";
                                                echo "<label>Question Text : {$quizDetails[$i]['question_text']} </label><br><br>";
                                                echo "<input type='text' id='{$quizDetails[$i]['question_id']}' 
                                                    name='{$quizDetails[$i]['question_id']}' required><br><br>";
                                                echo "</div>";
                                            } else {
                                                $questionTitle = $quizDetails[$i]["question_text"];
                                                $choiceCount = 1;
                                                echo "<div class='question-id-{$quizDetails[$i]['question_id']}'>";
                                                echo "<label>Question Number {$questionCount} : </label> 
                                                    <label>POINTS : {$quizDetails[$i]["points"]}</label><br>";
                                                echo "<label>Question Text : {$quizDetails[$i]['question_text']} </label><br><br>";
                                                echo "<input type='radio' id='{$quizDetails[$i]['question_id']}_{$choiceCount}' 
                                                    name='{$quizDetails[$i]['question_id']}' 
                                                    value='{$quizDetails[$i]["option_text"]}' required>
                                                    <label for='{$quizDetails[$i]['question_id']}_{$choiceCount}'> 
                                                    Choice {$choiceCount} : {$quizDetails[$i]["option_text"]}</label><br><br>";
                                                echo "</div>";
                                            }
                                            $questionCount++;
                                        }
                                    } 
                                }
                     ?>
                </div>
            </div>
        </div>

        <div id="postIdValue" hidden><?php echo $postDetails[0]["post_id"];?></div>
        <div id="classCodeValue" hidden><?php echo $postDetails[0]["class_code"];?></div>

        <script src="scripts/submit-quiz.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>