$(document).ready(function () {
    let questionCount = $('#questions-container').children().length;
    let inputCount = 1;
    // Add a new question
    console.log("Len" + $('#questions-container').children().length);
    $('#add-question').click(function () {
        questionCount++;
        $('#questions-container').append(`
            <div class="question id" data-id="${questionCount}">
                 <div class="notSaved" hidden>not save</div>

                <div class="input-group row mb-3">
                    <div class="d-flex col-6">
                        <span style="font-size: large;" class="question_count form-label col-3">Question ${questionCount}:</span>
                        <div class="form-floating col-8">
                            <textarea class="form-control rounded-2 question-text" placeholder="Enter question" required></textarea>
                            <label for="floatingTextarea2" class="black3">Enter question</label>
                        </div>
                    </div>
                    
                    <div class="col-4">
                        <span style="font-size: large;" class="ms-2 form-label">Question Type:</span>
                        <select class="rounded-2 question-type">
                            <option value="multiple-choice">Multiple Choice</option>
                            <option value="short-text">Short Text</option>
                            <option value="true-false">True/False</option>
                        </select>
                    </div>

                    <div class="d-flex col-2">
                        <span style="font-size: large;" class="ms-2 form-label">Point:</span>
                        <div class="form-floating ms-2" style="flex: 1;">
                            <input type="number" class="points rounded-2 ps-2" value="1" min="1" max="100" placeholder="Enter number" required>
                        </div>
                    </div>
                </div>

                <div class="options">
                    <label>CHOICES:</label>
                    <div class="option-container">
                        <div class="option mt-1 col-7 d-flex align-items-center">
                            <div class="form-floating col-8">
                                <input type="text" class="optionText form-control rounded-2 remove_text" placeholder="Enter Choice" name="multiChoice[]" id="floatingText1">
                                <label for="floatingText" class="black3">Enter Choice</label>
                            </div>
                            <a href="#" class="remove-choice"><button class="btn btn-danger shadow-none mt-2 fw-medium fs-5 ms-2">X</button></a>
                            <a href="#" class="select_ans_key"><button class="btn btn-success shadow-none mt-2 fw-medium fs-5 ms-2">Answer Key</button></a>
                        </div>

                        <div class="option mt-1 col-7 d-flex align-items-center">
                            <div class="form-floating col-8">
                                <input type="text" class="optionText form-control rounded-2 remove_text" placeholder="Enter Choice" name="multiChoice[]" id="floatingText1">
                                <label for="floatingText" class="black3">Enter Choice</label>
                            </div>
                            <a href="#" class="remove-choice"><button class="btn btn-danger shadow-none mt-2 fw-medium fs-5 ms-2">X</button></a>
                            <a href="#" class="select_ans_key"><button class="btn btn-success shadow-none mt-2 fw-medium fs-5 ms-2">Answer Key</button></a>
                        </div>

                        <div class="ans-key-cont form-floating col-6 d-flex align-items-center">
                            <input type="text" class="answer_key form-control rounded-2 remove_text" placeholder="Answer Key" name="multiChoice[]" id="floatingText1" readonly>
                            <label for="floatingText" class="black3">Answer Key</label>
                        </div>
                        <button type="button" class="btn btn-secondary add-choice">Add Choice</button>
                         <button type="button" class="btn btn-danger remove-question ms-auto">Remove Question</button>
                    </div>
                </div>

                <div class="true-false-select col-4" style="display: none;">

                    <span style="font-size: large;" class="ms-2 form-label">Select Answer Key:</span>
                    <select class="booleanSelect rounded-2">
                        <option value="True">True</option>
                        <option value="False">False</option>
                    </select>

                    <div class="mt-1 col-8 d-flex align-items-center">
                        <div class="form-floating col-8">
                            <input type="text" class="boolean_answer_key form-control rounded-2 remove_text" placeholder=">Answer Key" id="floatingText1a" readonly>
                            <label for="floatingText1a" class="black3">Answer Key</label>
                        </div>
                    </div>

                    <button type="button" class="btn btn-danger remove-question ms-auto">Remove Question</button
                </div>
            
                <br>
            </div>
                <div class="short-text-select" style="display: none;">
                    <div class="mt-1 col-7 d-flex align-items-center">
                        <div class="form-floating col-8">
                            <input type="text" class="short_ans_key form-control rounded-2 remove_text" placeholder=">Enter Answer Key" id="floatingText1a">
                            <label for="floatingText1a" class="black3">Enter Answer Key</label>
                        </div>
                     </div><br>
                    <button type="button" class="btn btn-danger remove-question ms-auto">Remove Question</button>
              </div>
            <hr>
        `);

        updateQuestionDisplay();
    });

    function countInputFields(container) {
        var count = $(container).find('.option').length; // Count all input fields with class 'option' in the specified container
        console.log("Total input fields in this container: " + count);
        return count;
    }


    // Event Handler for Adding New Choice
    // Add a new choice
    $(document).on('click', '.add-choice', function () {
        const container = $(this).closest('.option-container'); // Get the closest option-container

        // Find the last .option that is a direct child of .option-container (excluding .ans-key-cont)
        container.children('.option').last().after(`
            <div class="option mt-1 col-7 d-flex align-items-center">
                <div class="form-floating col-8">
                    <input type="text" class="optionText form-control rounded-2 remove_text" placeholder="Enter Choice" name="multiChoice[]" id="floatingText${Date.now()}">
                    <label for="floatingText${Date.now()}" class="black3">Enter Choice</label>
                </div>
                <a href="#" class="remove-choice">
                    <button class="btn btn-danger shadow-none mt-2 fw-medium fs-5 ms-2">X</button>
                </a>
                <a href="#" class="select_ans_key">
                    <button class="btn btn-success shadow-none mt-2 fw-medium fs-5 ms-2">Answer Key</button>
                </a>
            </div>
        `);
    });

    const navLinks = document.querySelectorAll('.nav-link');

    // Loop through each link and add click event listener
    navLinks.forEach(link => {
        link.addEventListener('click', function () {
            // Remove 'active' class from all nav links
            navLinks.forEach(link => link.classList.remove('active'));
            // Add 'active' class to the clicked link
            this.classList.add('active');
        });
    });

    // to adjust textarea size vertically
    document.addEventListener("input", (e) => {
        if (e.target.tagName.toLowerCase() === "textarea") {
            e.target.style.height = "auto";
            e.target.style.height = e.target.scrollHeight + "px";
        }
    });

    function refreshQuestionElements(questionDiv) {
        // Get the selected question type
        var questionType = $(questionDiv).find('.question-type').val();

        // Hide all specific type sections
        $(questionDiv).find('.true-false-select').hide();
        $(questionDiv).find('.short-text-select').hide();
        $(questionDiv).find('.options').show(); // Show options by default

        // Reset all input fields
        $(questionDiv).find('.optionText').val('');
        $(questionDiv).find('.boolean_answer_key').val('');
        $(questionDiv).find('.answer_key').val('');
        $(questionDiv).find('.short_ans_key').val('');

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
        console.log("Testt "  + $(this).closest(".question").find(".notSaved").text());
        // questionCount--;
        if($(this).closest(".question").find(".notSaved").text() != "not save"){
            
        }
        
        console.log("ID: " + $(this).closest('.question').data("id"));

        $(this).closest('.question').remove();
        $('.question').each(function () {
            let currentId = $(this).closest('.question').data("id");

            if (currentId >= questionId) {
                console.log($(this).closest('.question').data("id"));
                if ($(this).closest('.question').data("id") != "1") {
                    $(this).closest('.question').data("id", $(this).closest('.question').data("id") - 1);
                    $(this).closest(".question").find('.question_count').text("Question " + $(this).closest('.question').data("id") + ":");
                }
            }

        });
    });

    // Add an option (for multiple-choice only)
    // $(document).on('click', '.add-option', function () {
    //     // Append a new input field and remove link after the last .remove-choice sibling
    //     $(this).prev('div').last().after('<div><input type="text" class="option" placeholder="Enter Question Choice" name="multipleChoice[]"><a href="#" class="remove-choice"> X || </a><a href="#" class="select_ans_key"> Answer Key</a></div>');
    // });

    // Event handler for removing input fields
    $(document).on('click', 'a.remove-option', function (event) {
        event.preventDefault(); // Prevent the default anchor behavior
        $(this).prev('.option').remove(); // Remove the input field before the anchor
        $(this).remove(); // Remove the anchor itself
    });

    $(document).on('click', 'a.remove-choice', function (e) {
        e.preventDefault();
        console.log($(this).closest('.option-container').find(".option").length);
        console.log("Option : " + $(this).closest('.option').find(".optionText").val());
        let option = $(this).closest('.option').find(".optionText").val();
        let answerKey = $(this).closest('.option-container').find(".answer_key").val();

        console.log("Answer key " + $(this).closest('.option-container').find(".answer_key").val());

        if ($(this).closest('.option-container').find(".option").length != 1) {
            if (answerKey == option) {
                $(this).closest('.option-container').find(".answer_key").val("");
            }
            $(this).closest('.option').remove();
        }

        // var container = $(this).closest('.option-container');
        // console.log(countInputFields(container));
        // if(countInputFields(container) != 1){
        //     $(this).prev('.option').remove(); 
        //     $(this).prev('.option').remove(); 
        //     $(this).next('.select_ans_key').remove();
        //     $(this).prev('br').remove();
        //     $(this).remove();
        // }

        // $(this).siblings('.option').last().after('<input type="text" class="option" placeholder="New Option">');
    });
    // console.log("test");

    $(document).on('click', 'a.select_ans_key', function (event) {
        event.preventDefault(); // Prevent the default anchor behavior
        console.log("answer key");
        var answerKey = $(this).closest('.option').find(".optionText").val(); // or $(this).prev('.option').val();

        console.log(answerKey);
        $(this).closest('.option-container').find('.answer_key').val(answerKey);
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
        // console.log("Len" + $('#questions-container').length);
        console.log("Len" + $('#questions-container').children().length);

        $('.question').each(function () {
            const type = $(this).find('.question-type').val();
            const options = $(this).find('.options');
            const trueFalseSelect = $(this).find('.true-false-select');
            const shortText = $(this).find('.short-text-select');
            const answerKey = $(this).find('.answer_key');
            console.log(answerKey.val());
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

        if($('#questions-container').children().length == 0){
            alert("Cannot save quiz without a question");
            return;
        }

        const urlParams = new URLSearchParams(window.location.search);
        const classCode = urlParams.get('class');
        const postId = urlParams.get('post');

        const title = $('#quiz-title').val();
        var questions = [];
        console.log("Quiz Title : " + title);
        let listOfNoAns = "No answer key on question number : ";

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
                $(this).find('.option').find(".optionText").each(function () {
                    console.log("Choice : " + $(this).val());
                    options.push($(this).val());
                });
                console.log("Answer Key: " + $(this).find('.answer_key').val());
                ansKey = ($(this).find('.answer_key').val());
                if (ansKey == "") {
                    console.log("You have no answer key for Question " + questionId);
                    listOfNoAns += questionId + ", ";
                    // alert("You have no answer key for Question " + questionId);
                    noAnswerKey = true;
                }
            } else if (type === 'true-false') {
                options = ['True', 'False'];
                console.log("Answer Key: " + $(this).find('.boolean_answer_key').val());
                ansKey = $(this).find('.boolean_answer_key').val();
            } else {
                console.log("Answer Key: " + $(this).closest(".question").find(".short-text-select .short_ans_key").val());
                ansKey = $(this).closest(".question").find(".short-text-select .short_ans_key").val();
                if (ansKey == "") {
                    console.log("You have no answer key for Question " + questionId);
                    listOfNoAns += questionId + ", ";
                    // alert("You have no answer key for Question " + questionId);
                    noAnswerKey = true;
                }
            }

            questions.push({ question: questionText, type, options, ansKey, points });
        });

        console.table(questions);

        if (noAnswerKey != true) {
            console.table(questions);
            console.log("inside");
            $.ajax({
                url: "includes/create-quiz.php",
                type: "POST",
                data: {
                    title: title,
                    classCode: classCode,
                    postId : postId,
                    questions: JSON.stringify(questions)
                },

                success: function (response) {
                    alert("QUIZ CREATED SUCCESSFULLY");
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    $(".form-message").html("An error occurred: " + error);
                }
            });
        } else {
            alert(listOfNoAns.substring(0, listOfNoAns.length - 2));
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