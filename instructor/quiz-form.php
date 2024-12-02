<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Maker with Question Types</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .question { margin-bottom: 15px; }
        .options, .question-settings { margin-top: 10px; }
        button { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Create Quiz</h1>
    <form id="quiz-form">
        <input type="text" id="quiz-title" placeholder="Quiz Title" required><br><br>
        <div id="questions-container"></div>
        <button type="button" id="add-question">Add Question</button><br><br>
        <button type="submit">Save Quiz</button>
    </form>

    <!-- You can see the question format inside here, try to preserve the div names and element hierarchy -->
    <script src="scripts/create-quiz.js">

    </script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

</body>
</html>
