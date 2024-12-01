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

    <script>
        $(document).ready(function () {
            let questionCount = 0;

            // Add a new question
            $('#add-question').click(function () {
                questionCount++;
            
                $('#questions-container').append(`
                    <div class="question id" data-id="${questionCount}">
                        <label class="question_count">Question ${questionCount}:</label>
                        <input type="text" class="question-text" placeholder="Enter question" required>
                        <div class="question-settings">
                            <label>Question Type:</label>
                            <select class="question-type">
                                <option value="multiple-choice">Multiple Choice</option>
                                <option value="short-text">Short Text</option>
                                <option value="true-false">True/False</option>
                            </select>
                        </div>
                        <div class="options">
                            <label>Options:</label>
                            <div class="option-container">
                                <div>
                                <input type="text" class="option remove_text" placeholder="Enter Question Choice"><a href="#" class="remove-choice"> X || </a><a href="#" class="select_ans_key"> Answer Key</a>
                                <br>
                                </div>
                                <div>
                                <input type="text" class="option remove_text" placeholder="Enter Question Choice"><a href="#" class="remove-choice"> X || </a><a href="#" class="select_ans_key"> Answer Key</a>
                                <br>
                                </div>
                                <button type="button" class="add-option">Add Option</button>
                                <br>
                                <input type="text" placeholder="Enter Answer Key" class="answer_key"><br>
                            </div>
                        </div>
                        <div class="true-false-select" style="display: none;">
                            <label>True/False:</label>
                            <select class="booleanSelect">
                                <option value="True">True</option>
                                <option value="False">False</option>
                            </select><br>
                            <input type="text" placeholder="Enter Answer Key" class="answer_key"><br>
                        </div><br>
                        <div class="short-text-select" style="display: none;"">
                             <input type="text" placeholder="Enter Answer Key" class="answer_key"><br>
                        </div>
                        <button type="button" class="remove-question">Remove Question</button>
                        <hr>
                    </div>
                `);
                updateQuestionDisplay();
            });

            function countInputFields(container) {
                var count = $(container).find('.option').length; // Count all input fields with class 'option' in the specified container
                console.log("Total input fields in this container: " + count);
                return count;
            }

            function refreshQuestionElements(questionDiv) {
                // Get the selected question type
                var questionType = $(questionDiv).find('.question-type').val();

                // Hide all specific type sections
                $(questionDiv).find('.true-false-select').hide();
                $(questionDiv).find('.short-text-select').hide();
                $(questionDiv).find('.options').show(); // Show options by default

                // Reset all input fields
                $(questionDiv).find('.option').val('');
                $(questionDiv).find('.answer_key').val('');

                // Show/hide elements based on the selected question type
                if (questionType === 'true-false') {
                    $(questionDiv).find('.true-false-select').show();
                    $(questionDiv).find('.options').hide(); // Hide options for true/false
                } else if (questionType === 'short-text') {
                    $(questionDiv).find('.short-text-select').show();
                    $(questionDiv).find('.options').hide(); // Hide options for short text
                } else {
                    $(questionDiv).find('.options').show(); // Show options for multiple choice
                }
            }

            $(document).on('click', '.remove-question', function () {
                let questionId = $(this).closest('.question').data("id");
                questionCount--;
                console.log("ID: " + $(this).closest('.question').data("id"));
                $(this).closest('.question').remove();
                $('.question').each(function () {
                    let currentId = $(this).closest('.question').data("id");
                    
                    if(currentId >= questionId){
                        console.log($(this).closest('.question').data("id"));
                        if($(this).closest('.question').data("id") != "1"){
                            $(this).closest('.question').data("id", $(this).closest('.question').data("id") - 1);
                            $(this).closest(".question").find('.question_count').text("Question " + $(this).closest('.question').data("id") + ":");
                        }
                    }

                });
            });

            // Add an option (for multiple-choice only)
            $(document).on('click', '.add-option', function () {
                // Append a new input field and remove link after the last .remove-choice sibling
                $(this).prev('div').last().after('<div><input type="text" class="option" placeholder="Enter Question Choice"><a href="#" class="remove-choice"> X || </a><a href="#" class="select_ans_key"> Answer Key</a></div>');
            });

            // Event handler for removing input fields
            $(document).on('click', 'a.remove-option', function (event) {
                event.preventDefault(); // Prevent the default anchor behavior
                $(this).prev('.option').remove(); // Remove the input field before the anchor
                $(this).remove(); // Remove the anchor itself
            });

            $(document).on('click', 'a.remove-choice', function () {
                var container = $(this).closest('.option-container');
                console.log(countInputFields(container));
                if(countInputFields(container) != 1){
                    $(this).prev('.option').remove(); 
                    $(this).prev('.option').remove(); 
                    $(this).next('.select_ans_key').remove();
                    $(this).prev('br').remove();
                    $(this).remove();
                }
              
                // $(this).siblings('.option').last().after('<input type="text" class="option" placeholder="New Option">');
            });

            $(document).on('click', 'a.select_ans_key', function (event) {
                event.preventDefault(); // Prevent the default anchor behavior
                console.log("answer key");
                var answerKey = $(this).siblings('.option').val(); // or $(this).prev('.option').val();

                console.log(answerKey);
                console.log($(this).closest('.option-container').find('.answer_key').val(answerKey));
            });

            $(document).on('change', '.booleanSelect', function () {
                 console.log($(".booleanSelect").val());
                 var answerKey = $(".booleanSelect").val();
                 $(this).closest('.true-false-select').find('.answer_key').val(answerKey);
            });

            // updates the question if changing question type
            $(document).on('change', '.question-type', function () {
                var questionDiv = $(this).closest('.question'); // Get the closest question div
                refreshQuestionElements(questionDiv); 
                updateQuestionDisplay();
            });

            // Update display based on question type
            function updateQuestionDisplay() {
                $('.question').each(function () {
                    const type = $(this).find('.question-type').val();
                    const options = $(this).find('.options');
                    const trueFalseSelect = $(this).find('.true-false-select');
                    const shortText = $(this).find('.short-text-select');
                    if (type === 'multiple-choice') {
                        options.show();
                        options.find('.option-container').show();
                        shortText.hide();
                        trueFalseSelect.hide();
                        options.find('.option').prop('required', true);
                    } else if (type === 'true-false') {
                        options.hide();
                        shortText.hide();
                        options.find('.option-container').hide();
                        trueFalseSelect.show();
                    } else {
                        options.hide();
                        trueFalseSelect.hide();
                        shortText.show();
                        options.find('.option').prop('required', false);
                        // options.append("<input type='text' placeholder='Enter Answer Key' class='answer_key'><br>");
                    }
                });
            }

            // Get class code from url and id, pass it as well
            // Submit quiz
            $('#quiz-form').submit(function (e) {
                e.preventDefault();

                const title = $('#quiz-title').val();
                const questions = [];

                $('.question').each(function () {
                    const questionText = $(this).find('.question-text').val();
                    const type = $(this).find('.question-type').val();
                    let options = [];
                    // console.log(questionText);
                    if (type === 'multiple-choice') {
                        $(this).find('.option').each(function () {
                            options.push($(this).val());
                        });
                    } else if (type === 'true-false') {
                        options = ['True', 'False'];
                    }

                    questions.push({ question: questionText, type, options });
                });



                // Send to PHP
                // $.post('save_quiz.php', { title, questions: JSON.stringify(questions) }, function (response) {
                //     alert(response.message);
                // }, 'json');
            });
        });
    </script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

</body>
</html>
