$(document).ready(function () {
    let questionCount = 0;
    let inputCount = 1;
    // Add a new question
    $('#add-question').click(function () {
        questionCount++;
        
        $('#questions-container').append(`
            <div class="question id" data-id="${questionCount}">
                <label class="question_count">Question ${questionCount}:</label>
                <input type="text" class="question-text" placeholder="Enter question" required> 
                     <label>Points </label>
                     <input type="number" class="points" name="points" min="1" max="100" value="1" required>
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
                        <input type="text" class="option remove_text" name="multiChoice[]" placeholder="Enter Question Choice"><a href="#" class="remove-choice"> X || </a><a href="#" class="select_ans_key"> Answer Key</a>
                        <br>
                        </div>
                        <div>
                        <input type="text" class="option remove_text" name="multiChoice[]" placeholder="Enter Question Choice"><a href="#" class="remove-choice"> X || </a><a href="#" class="select_ans_key"> Answer Key</a>
                        <br>
                        </div>
                        <button type="button" class="add-option">Add Option</button>
                        <br>
                        <label>Answer Key</label>
                        <input type="text" placeholder="Enter Answer Key" class="answer_key"><br>
                    </div>
                </div>
                <div class="true-false-select" style="display: none;">
                    <label>Select Answer Key:</label>
                    <select class="booleanSelect">
                        <option value="True">True</option>
                        <option value="False">False</option>
                    </select><br>
                    <label>Answer Key</label>
                    <input type="text" name="trueOrFalse" placeholder="Enter Answer Key" class="boolean_answer_key"><br>
                </div><br>
                <div class="short-text-select" style="display: none;"">
                     <label>Answer Key</label>
                     <input type="text" placeholder="Enter Answer Key" class="short_ans_key"><br>
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
        $(this).prev('div').last().after('<div><input type="text" class="option" placeholder="Enter Question Choice" name="multipleChoice[]"><a href="#" class="remove-choice"> X || </a><a href="#" class="select_ans_key"> Answer Key</a></div>');
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
         var answerKey = $(this).closest('.true-false-select').find('.boolean_answer_key');
         answerKey.val($(this).val());
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
            const answerKey = $(this).find('.answer_key'); 

            if (type === 'multiple-choice') {

                options.show();
                options.find('.option-container').show();
                shortText.hide();
                trueFalseSelect.hide();
                options.find('.option').prop('required', true); // Make multiple-choice options required
                answerKey.prop('readonly', true).show(); // Make answer key visible and readonly
                
            } else if (type === 'true-false') {
       
                options.hide();
                options.find('.option-container').hide();
                options.find('.option').prop('required', false); // Remove required attribute from hidden inputs
                
                trueFalseSelect.show();
                shortText.hide();
                answerKey.prop('readonly', true).show(); // Make answer key visible and readonly

                const selectedValue = trueFalseSelect.find('.booleanSelect').val();
                $(this).find(".boolean_answer_key").val(selectedValue);
                answerKey.val(selectedValue); 

            } else if (type === 'short-text') {

                options.hide();
                options.find('.option-container').hide();
                options.find('.option').prop('required', false); // Remove required attribute from hidden inputs
                
                trueFalseSelect.hide();
                shortText.show();

                answerKey.prop('readonly', false).show(); // Make answer key visible and editable
            }
        });
    }

    let noAnswerKey = false;
    // Get class code from url, pass it as well
    // Submit quiz
    $('#quiz-form').submit(function (e) {
        e.preventDefault();
        const urlParams = new URLSearchParams(window.location.search);
        const classCode = urlParams.get('class');

        const title = $('#quiz-title').val();
        var questions = [];
        console.log("Quiz Title : " + title);

        $('.question').each(function () {
            const questionText = $(this).find('.question-text').val();
            const type = $(this).find('.question-type').val();
            let questionId = $(this).closest('.question').data("id");
            const points = $(this).find('.points').val(); 
            
            // console.log("QUESTION ID : " + questionId);
            let options = [];
            let ansKey = "";

            console.log("Question : " + questionText);
            console.log("Question Type : " + type);
            console.log("Points : " + points);
            // console.log(questionText);
            if (type === 'multiple-choice') {
                $(this).find('.option').each(function () {
                    console.log("Choice : " + $(this).val());
                    options.push($(this).val());
                });
                console.log("Answer Key: " + $(this).find('.answer_key').val());
                ansKey = ($(this).find('.answer_key').val());
                if(ansKey == ""){
                    console.log("You have no answer key for Question " + questionId);
                    noAnswerKey = true;
                }
            } else if (type === 'true-false') {
                options = ['True', 'False'];
                console.log("Answer Key: " + $(this).find('.boolean_answer_key').val());
                ansKey = ($(this).find('.answer_key').val());
            } else {
                console.log("Answer Key: " + $(this).closest(".question").find(".short-text-select .short_ans_key").val());
                ansKey = $(this).closest(".question").find(".short-text-select .short_ans_key").val();
                if(ansKey == ""){
                    console.log("You have no answer key for Question " + questionId);
                    noAnswerKey = true;
                }
            }

            questions.push({ question: questionText, type, options, ansKey, points});
        });

        if(noAnswerKey != true){
            console.table(questions);
            console.log("inside");
            $.ajax({
                url: "includes/create-quiz.php",
                type: "POST",
                data: {
                    title: title,
                    questions: JSON.stringify(questions)
                },

                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    $(".form-message").html("An error occurred: " + error);
                }
            });
        }else{
                noAnswerKey = false;
                options = [];
                question = [];
                questions = [];
        }
 

        // Send to PHP
        
        // $.post('includes/create-quiz.php', { title, questions: JSON.stringify(questions) }, function (response) {
        //     alert(response.message);
        // }, 'json');
    });
});