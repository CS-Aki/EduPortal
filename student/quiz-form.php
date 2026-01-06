<?php
if (session_id() === "") session_start();

if(isset($_SESSION["user_category"])){
    $category = $_SESSION["user_category"];
    switch($category){
        case 1: header("Location: ../admin/admin-dashboard.php"); exit(); break;
        case 2: header("Location: ../staff/staff-dashboard.php"); break;
        case 3: header("Location: ../instructor/instructor-dashboard.php"); exit(); break;
        // case 4: header("Location: student/student-dashboard.php"); break;
    }
}else{
    header("Location: ../");
    exit();
}

$_SESSION[$_GET["post"]] = $_GET["attempt"];

if(isset($_SESSION["user_category"])){
    $category = $_SESSION["user_category"];
    switch($category){
        case 1: header("Location: ../admin/admin-dashboard.php"); exit(); break;
        case 2: header("Location: ../staff/staff-dashboard.php"); break;
        case 3: header("Location: ../instructor/instructor-dashboard.php"); exit(); break;
        // case 4: header("Location: student/student-dashboard.php"); break;
    }
}else{
    header("Location: ../");
    exit();
}

$_SESSION[$_GET["post"]] = $_GET["attempt"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Form</title>
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
        .question-container {
            padding: 1000px; /* Increase padding */
            margin: 0px; /* Increase margin */
            border-radius: 12px; /* Adjust border radius if needed */
            background-color: #f8f9fa; /* Change background color (optional) */
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); /* Add shadow for depth */
            display: none; /* Hide all questions initially */
        }

        .active {
            display: block; /* Show active question */
        }

        .navigation {
            display: flex;
            justify-content: flex-end; /* Align items to the right */
        }

        .question-text {
            font-size: 1.2rem; /* Bigger question text */
            font-weight: bold;
        }


    </style>
    <?php require('inc/links.php'); ?>
</head>

<body>
    <?php if (isset($_GET["class"])) {
        // $_SESSION[$_GET["class"]] = $_GET["attempt"];
        include("student backend/includes/view-quiz.php");
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
                <!-- If need mo makita yung nasa loob ng display na 'to and na-submit mo yung form na may answers, truncate mo lang yung answers table sa db -->
                <?php ?>
                    <div class="container mt-4 px-lg-5 px-sm-2">
                        <form id="quiz-answer-form">
                            <div class="form-container">
                                <!-- <h1 class="h-font green1 fs-1 me-2 mb-3" id="material-title"><?php echo $quizDetails1[0]["title"]; ?></h1> -->
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="col-lg-9">
                                        <h1 class="h-font green1 fs-1 me-2" id="material-title">
                                            <?php echo $quizDetails1[0]["title"]; ?>
                                        </h1>
                                        <p class="fw-semibold green2 fs-5 lh-sm">
                                            <?php echo "ATTEMPT : " . $_GET["attempt"]; ?>
                                        </p>
                                        <p class="fw-semibold red fs-8 lh-sm">Deadline: 
                                            <?php echo $quizDetails1[0]["deadline_date"] . " - ". $formattedTime; ?>
                                        </p>
                                    </div>

                                    <div class="col-lg-2 ms-auto">
                                        <div class='d-flex flex-column'>
                                            <div>
                                                <p class="fw-semibold green2 fs-5 lh-sm">SCORE: 
                                                    <?php echo"? / " . $numberOfItems; ?>
                                                </p>
                                            </div>
                                            <div>
                                                <select class="form-select shadow-elevation-light-3 black3" name="item-num" id="item-num">
                                                    <?php for($i = 0; $i < count($quizDetails1); $i++){
                                                        $temp = $i + 1;
                                                        echo "<option value='{$temp}'>{$temp}</option>";
                                                    }?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- <input type="text" id="quiz-title" placeholder="Quiz Title" readonly><br><br> -->
                                <?php
                                    shuffle($quizDetails1);
                                    $questionTitle = "";
                                    $questionCount = 1;
                                    $choiceCount = 1;
                                    $j = 0;

                                    for ($i = 0; $i < count($quizDetails1); $i++) {
                                        $options = explode(', ', $quizDetails1[$i]["option_text"]); 
                                    
                                        if ($questionTitle == $quizDetails1[$i]["question_text"]) {
                                            foreach ($options as $choice) {
                                                $choiceCount++;
                                                echo "<div class='col-lg-12 d-flex align-items-center gap-3 mb-3'>
                                                        <input class='choice-radio' type='radio' id='{$quizDetails1[$i]['question_id']}_{$choiceCount}' 
                                                            name='{$quizDetails1[$i]['question_id']}' 
                                                            value='{$choice}' >
                                                        <label class='choice-label' for='{$quizDetails1[$i]['question_id']}_{$choiceCount}'> 
                                                            {$choice}
                                                        </label>
                                                    </div>";
                                            }
                                        } else {
                                            if ($i > 0) {
                                                $j++;
                                                echo "</div>"; 
                                                echo "</div>"; 
                                            }
                                    
                                            echo "<div class='question-container quizborder mb-4 py-5 px-5 rounded-4 black2 question-id-{$quizDetails1[$i]['question_id']}'>";
                                    
                                            echo "<div class='d-flex justify-content-between align-items-center mb-4'>
                                                    <label class='question-number fw-bold'>Question {$questionCount}</label>
                                                    <label class='question-points fw-semibold green2'>Points: {$quizDetails1[$i]["points"]}</label>
                                                  </div>
                                                  <p class='question-text fw-bold mb-4'>Question: <span>{$quizDetails1[$i]['question_text']}</span></p>";
                                    
                                    
                                            echo "<div class='row'>";
                                    
                                            if ($quizDetails1[$i]["question_type"] == "short-text") {
                                          
                                                echo "<div class='col-12'>
                                                        <input class='w-100 rounded-4 p-3 text-input' type='text' id='{$quizDetails1[$i]['question_id']}' 
                                                            name='{$quizDetails1[$i]['question_id']}' >
                                                    </div><br><br>";
                                            } else {
                                          
                                                $questionTitle = $quizDetails1[$i]["question_text"];
                                                $choiceCount = 1; 
                                    
                                                foreach ($options as $choice) {
                                                    echo "<div class='col-lg-12 d-flex align-items-center gap-3 mb-3'>
                                                            <input class='choice-radio' type='radio' id='{$quizDetails1[$i]['question_id']}_{$choiceCount}' 
                                                                name='{$quizDetails1[$i]['question_id']}' 
                                                                value='{$choice}' >
                                                            <label class='choice-label' for='{$quizDetails1[$i]['question_id']}_{$choiceCount}'> 
                                                                {$choice}
                                                            </label>
                                                        </div>";
                                                    $choiceCount++; 
                                                }
                                            }
                                    
                                            $questionCount++; 
                                        }
                                    }
                                    
                                    if (count($quizDetails1) > 0) {
                                        $j++;
                                        echo "</div>"; 
                                        echo "</div>"; 
                                    }
                                    ?>
                                    

                                <div class="d-flex justify-content-between align-items-center gap-2 mt-3">
                                    <a href='#'><button type="button" id="prevBtn"  class="btn green px-4 py-2">Prev</button></a>
                                    <a href='#'><button type="button" id="nextBtn" class="btn green px-4 py-2">Next</button></a>
                                </div>

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
    <div id="contentType" hidden><?php echo $postDetails[0]["content_type"]; ?></div>
    <div id="date" hidden><?php echo $quizDetails1[0]["deadline_date"]; ?></div>
    <div id="time" hidden><?php echo $quizDetails1[0]["deadline_time"]; ?></div>

    <!-- <div id="totalItems"><?php echo $j; ?>SASASASA</div> -->
    <?php require('inc/footer.php'); $_SESSION["total" . $_GET["post"]] = $numberOfItems; ?>
    <?php require('inc/footer.php'); $_SESSION["total" . $_GET["post"]] = $numberOfItems; ?>

    <script src="scripts/submit-quiz.js"></script>

    <script src="scripts/quiz-answer.js">

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>