$(document).ready(function () {
    let questionCount = $('#questions-container').children().length;
    let inputCount = 1;
    // Add a new question
    console.log("Len" + $('#questions-container').children().length);
    $('#add-question').click(function () {
        isAddQuestionClicked = true;
        questionCount++;
        $('#questions-container').append(`
            <div class="question id" data-id="${questionCount}">
                 <div class="notSaved" hidden>not save</div>

                <div class="row mb-3 d-flex align-items-center">
                    <div class="d-flex col-lg-6 align-items-center px-0 m-0">
                        <div class="row container-fluid m-0">
                            <div class="col-lg-3 d-flex align-items-center m-0 p-0">
                                <span class="question_count form-label fs-6 black3">Question ${questionCount}:</span>
                            </div>
                            <div class="col-lg-9 d-flex align-items-center container-fluid m-0 p-0">
                                <textarea class="form-control question-text container-fluid black3 w-100" placeholder="Enter question" required></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 d-flex align-items-center m-0 p-0">
                        <div class="row container-fluid m-0">\
                            <div class="col-lg-3 d-flex align-items-center m-0 p-0">
                                <span class="form-label black3 fs-6 ">Question Type:</span>
                            </div>
                            <div class="col-lg-9 d-flex align-items-center container-fluid m-0 p-0">
                                <select class="rounded-2 question-type fs-6 form-select shadow-elevation-light-3 black3">
                                    <option value="multiple-choice">Multiple Choice</option>
                                    <option value="short-text">Short Text</option>
                                    <option value="true-false">True/False</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex col-lg-2 align-items-center m-0 p-0">
                        <div class="row d-flex align-items-center m-0 container-fluid">
                            <div class="col-lg-4 container-fluid d-flex align-items-center px-0 m-0">
                            <span class="form-label black3 fs-6" >Point:</span>
                            </div>
                       
                            <div class="col-lg-8 shadow-elevation-light-3 black3 rounded-2 container-fluid d-flex align-items-center px-0 m-0">
                            <input type="number" class="points rounded-4 container-fluid border-0 py-2 black3" value="1" min="1" max="100" placeholder="Enter number" required>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="options">
                    <label>CHOICES:</label>
                    <div class="option-container">
                        <div class="option mt-1  col-lg-7 col-12 d-flex align-items-center">
                            <div class="form-floating col-8">
                                <input type="text" class="optionText form-control rounded-2 remove_text" placeholder="Enter Choice" name="multiChoice[]" id="floatingText2" required>
                                <label for="floatingText" class="black3">Enter Choice</label>
                            </div>
                            <a href="#" class="remove-choice"><button class="delete btn btn-secondary shadow-none fw-medium fs-6 ms-2">X</button></a>
                            <a href="#" class="select_ans_key"><button class="answ_key btn btn-success shadow-none fw-medium fs-6 ms-2">Answer Key</button></a>
                        </div>

                        <div class="option mt-1  col-lg-7 col-12 d-flex align-items-center">
                            <div class="form-floating col-8">
                                <input type="text" class="optionText form-control rounded-2 remove_text" placeholder="Enter Choice" name="multiChoice[]" id="floatingText1" required>
                                <label for="floatingText" class="black3">Enter Choice</label>
                            </div>
                            <a href="#" class="remove-choice"><button class="delete btn btn-secondary shadow-none fw-medium fs-6 ms-2">X</button></a>
                            <a href="#" class="select_ans_key"><button class="answ_key btn btn-success shadow-none fw-medium fs-6 ms-2">Answer Key</button></a>
                        </div>

                        <div class="ans-key-cont form-floating col-lg-7 col-12 d-flex align-items-center mt-2">
                            <input type="text" class="answer_key form-control rounded-2 remove_text" placeholder="Answer Key" name="multiChoice[]" id="floatingText2" readonly>
                            <label for="floatingText" class="black3">Answer Key</label>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                        <button type="button" class="btn btn-secondary add-choice green shadow-none mt-2 fw-medium fs-6">Add Choice</button>
                         <button type="button" class="btn btn-danger remove-question redbtn shadow-none mt-2 fw-medium fs-6">Remove Question</button>
                        </div>
                    </div>
                </div>

                <div class="true-false-select col-4" style="display: none;">
                    <span class="form-label black3 fs-6">Select Answer Key:</span>
                    <select class="booleanSelect rounded-2 fs-6 form-select shadow-elevation-light-3 black3">
                        <option value="True">True</option>
                        <option value="False">False</option>
                    </select>

                    <div class="mt-1 col-8 d-flex align-items-center" style="display: none !important;">
                        <div class="form-floating col-8" style="display: none;">
                            <input type="text" class="boolean_answer_key form-control rounded-2 remove_text" placeholder=">Answer Key" id="floatingText1a" hidden>
                            <label for="floatingText1a" class="black3">Answer Key</label>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger remove-question ms-auto redbtn shadow-none mt-2 fw-medium fs-6">Remove Question</button>
                </div>
            
                <br>
                    <div class="short-text-select" style="display: none;">
                    <div class="mt-1  col-lg-7 col-12 d-flex align-items-center">
                        <div class="form-floating col-lg-7 col-12">
                            <input type="text" class="short_ans_key form-control rounded-2 remove_text" placeholder=">Enter Answer Key" id="floatingText1a">
                            <label for="floatingText1a" class="black3">Enter Answer Key</label>
                        </div>
                     </div><br>
                    <button type="button" class="btn btn-danger remove-question ms-auto redbtn shadow-none mt-2 fw-medium fs-6">Remove Question</button>
              </div>
            </div>
            <hr>
        `);

        updateQuestionDisplay();
    });

    // Checks for changes in the input
    $(document).on('input', 'input, textarea', function() {
        // console.log("Input changed in:", this); // Logs the specific element
        // console.log("New value:", $(this).val()); // Logs the new value of the input
        isQuizSaved = false;
        // Perform your desired actions here
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
        isQuizSaved = false;
        // Find the last .option that is a direct child of .option-container (excluding .ans-key-cont)
        container.children('.option').last().after(`
            <div class="option mt-1  col-lg-7 col-12 d-flex align-items-center">
                <div class="form-floating col-8">
                    <input type="text" class="optionText form-control rounded-2 remove_text" placeholder="Enter Choice" name="multiChoice[]" id="floatingText${Date.now()}" required>
                    <label for="floatingText${Date.now()}" class="black3">Enter Choice</label>
                </div>
                <a href="#" class="remove-choice">
                    <button class="btn btn-secondary shadow-none fw-medium fs-6 ms-2">X</button>
                </a>
                <a href="#" class="select_ans_key">
                    <button class="answ_key btn btn-success shadow-none fw-medium fs-6 ms-2">Answer Key</button>
                </a>
            </div>
        `);
    });

    // const navLinks = document.querySelectorAll('.nav-link');

    // // Loop through each link and add click event listener
    // navLinks.forEach(link => {
    //     link.addEventListener('click', function () {
    //         // Remove 'active' class from all nav links
    //         navLinks.forEach(link => link.classList.remove('active'));
    //         // Add 'active' class to the clicked link
    //         this.classList.add('active');
    //     });
    // });

    // // to adjust textarea size vertically
    // document.addEventListener("input", (e) => {
    //     if (e.target.tagName.toLowerCase() === "textarea") {
    //         e.target.style.height = "auto";
    //         e.target.style.height = e.target.scrollHeight + "px";
    //     }
    // });

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

    let removedElements = [];

    $(document).on('click', '.remove-question', function () {
        isQuizSaved = false;
        let questionIdTemp = $(this).closest('.question').data("id");
        console.log("Testt "  + $(this).closest(".question").find(".notSaved").text());
        questionCount--;
        let removeQuestion = 1;
        if($(this).closest(".question").find(".notSaved").text() != "not save"){
            const questionText = $(this).closest('.question').find('.question-text').val();
            const type = $(this).closest('.question').find('.question-type').val();
            let questionId = $(this).closest('.question').data("id");
            const points = $(this).closest('.question').find('.points').val();
            const qId = $(this).closest('.question').find('.question-num').text();

            // console.log("QUESTION ID : " + questionId);
            let options = [];
            let ansKey = "";
            let existingId = $(this).closest(".question").find(".question-num").text();
            console.log("Existing ID : " + existingId);
            console.log("Question : " + questionText);
            console.log("Question Type : " + type);
            console.log("Points : " + points);
            // console.log(questionText);
            if (type === 'multiple-choice') {
                console.log("QUESTION ID : " + qId);
                $(this).closest('.question').find('.option').find(".optionText").each(function () {
                    console.log("Choice : " + $(this).val());
                    options.push($(this).val());
                });
                console.log("Answer Key: " + $(this).find('.answer_key').val());
                ansKey = ($(this).closest('.question').find('.answer_key').val());
                if (ansKey == "") {
                    console.log("You have no answer key for Question " + questionId);
                    // listOfNoAns += questionId + ", ";
                    // alert("You have no answer key for Question " + questionId);
                    noAnswerKey = true;
                }
            } else if (type === 'true-false') {
                console.log("QUESTION ID : " + qId);

                options = ['True', 'False'];
                console.log("Answer Key: " + $(this).find('.booleanSelect').val());
                ansKey = $(this).closest('.question').find('.booleanSelect').val();
            } else {
                console.log("QUESTION ID : " + qId);

                console.log("Answer Key: " + $(this).closest(".question").find(".short-text-select .short_ans_key").val());
                ansKey = $(this).closest(".question").find(".short-text-select .short_ans_key").val();
                if (ansKey == "") {
                    console.log("You have no answer key for Question " + questionId);
                    // listOfNoAns += questionId + ", ";
                    // alert("You have no answer key for Question " + questionId);
                    noAnswerKey = true;
                }
            }

            removedElements.push({ question: questionText, type, options, ansKey, points, existingId, removeQuestion});
        }

        console.log("ID: " + $(this).closest('.question').data("id"));

        $(this).closest('.question').remove();
        $('.question').each(function () {
            let currentId = $(this).closest('.question').data("id");

            if (currentId >= questionIdTemp) {
                console.log($(this).closest('.question').data("id"));
                if ($(this).closest('.question').data("id") != "1") {
                    $(this).closest('.question').data("id", $(this).closest('.question').data("id") - 1);
                    $(this).closest(".question").find('.question_count').text("Question " + $(this).closest('.question').data("id") + ":");
                    // $questionCount--;
                }
            }

        });
    });

    $(document).on('click', 'a.remove-option', function (event) {
        event.preventDefault(); // Prevent the default anchor behavior
        $(this).prev('.option').remove(); // Remove the input field before the anchor
        $(this).remove(); // Remove the anchor itself
    });

    let removeChoices = [];
    $(document).on('click', 'a.remove-choice', function (e) {
        e.preventDefault();
        isQuizSaved = false;
        if($(this).closest(".question").find(".notSaved").text() != "not save"){
            // console.log("Question ID " + $(this).closest(".question").find(".question-num").text()); // Encrypted
            // console.log("Removing choice in database " + $(this).closest('.option').find(".optionText").val());
            // console.log("Answer Key " + $(this).closest('.option-container').find(".answer_key").val());
            
            // let questionId = $(this).closest(".question").find(".question-num").text();
            let choice = $(this).closest('.option').find(".optionText").val();
            let answerKey = $(this).closest('.option-container').find(".answer_key").val();

            const questionText = $(this).closest('.question').find('.question-text').val();
            const type = $(this).closest('.question').find('.question-type').val();
            let questionId = $(this).closest('.question').data("id");
            const points = $(this).closest('.question').find('.points').val();
            const qId = $(this).closest('.question').find('.question-num').text();

            // console.log("QUESTION ID : " + questionId);
            let ansKey = "";
            let existingId = $(this).closest(".question").find(".question-num").text();
            // console.log("Existing ID : " + existingId);
            // console.log("Question : " + questionText);
            // console.log("Question Type : " + type);
            // console.log("Points : " + points);

            removeChoices.push({existingId, choice, answerKey});
            // console.log(questionText);
            // if (type === 'multiple-choice') {
            //     console.log("QUESTION ID : " + qId);
            //     $(this).closest('.question').find('.option').find(".optionText").each(function () {
            //         console.log("Choice : " + $(this).val());
            //         options.push($(this).val());
            //     });
            //     console.log("Answer Key: " + answerKey);
            //     // ansKey = ($(this).closest('.question').find('.answer_key').val());
            //     if (ansKey == "") {
            //         // console.log("You have no answer key for Question " + questionId);
            //         // listOfNoAns += questionId + ", ";
            //         // alert("You have no answer key for Question " + questionId);
            //         noAnswerKey = true;
            //     }
            // } 

            // removedElements.push({ question: questionText, type, options, ansKey, points, existingId});
            // $.ajax({
            //     url: "includes/remove-choice.php",
            //     type: "POST",
            //     data: {
            //         questionId: questionId,
            //         choice: choice,
            //         answer : answerKey
            //     },

            //     success: function (response) {
            //         // alert("QUIZ CREATED SUCCESSFULLY");
            //         // isQuizSaved = true;
            //         console.log(response);
            //     },
            //     error: function (xhr, status, error) {
            //         $(".form-message").html("An error occurred: " + error);
            //     }
            // });

        }else{
            console.log("Removing choice not yet in database");
        }

        // console.log($(this).closest('.option-container').find(".option").length);
        // console.log("Option : " + $(this).closest('.option').find(".optionText").val());
        let option = $(this).closest('.option').find(".optionText").val();
        let answerKey = $(this).closest('.option-container').find(".answer_key").val();

        // console.log("Answer key " + $(this).closest('.option-container').find(".answer_key").val());

        if ($(this).closest('.option-container').find(".option").length != 1) {
            if (answerKey == option) {
                $(this).closest('.option-container').find(".answer_key").val("");
            }
            $(this).closest('.option').remove();
        }

    });
    // console.log("test");

    $(document).on('click', 'a.select_ans_key', function (event) {
        event.preventDefault(); // Prevent the default anchor behavior
        console.log("answer key");
        var answerKey = $(this).closest('.option').find(".optionText").val(); // or $(this).prev('.option').val();
        isQuizSaved = false;
        console.log(answerKey);
        $(this).closest('.option-container').find('.answer_key').val(answerKey);
    });

    $(document).on('change', '.booleanSelect', function () {
        isQuizSaved = false;
        console.log($(".booleanSelect").val());
        var answerKey = $(this).closest('.true-false-select').find('.boolean_answer_key');
        answerKey.val($(this).val());
    });

    // updates the question if changing question type
    $(document).on('change', '.question-type', function () {
        isQuizSaved = false;
         console.log("changing");
        var questionDiv = $(this).closest('.question'); // Get the closest question div
        refreshQuestionElements(questionDiv);
        updateQuestionDisplay();
        let removeQuestion = 0;
        if($(this).closest(".question").find(".notSaved").text() != "not save"){
            const questionText = $(this).closest('.question').find('.question-text').val();
            const type = $(this).closest('.question').find('.question-type').val();
            let questionId = $(this).closest('.question').data("id");
            const points = $(this).closest('.question').find('.points').val();
            const qId = $(this).closest('.question').find('.question-num').text();

            // console.log("QUESTION ID : " + questionId);
            let options = [];
            let ansKey = "";
            let existingId = $(this).closest(".question").find(".question-num").text();
            console.log("Existing ID : " + existingId);
            console.log("Question : " + questionText);
            console.log("Question Type : " + type);
            console.log("Points : " + points);
            // console.log(questionText);
            if (type === 'multiple-choice') {
                console.log("QUESTION ID : " + qId);
                $(this).closest('.question').find('.option').find(".optionText").each(function () {
                    console.log("Choice : " + $(this).val());
                    options.push($(this).val());
                });
                console.log("Answer Key: " + $(this).find('.answer_key').val());
                ansKey = ($(this).closest('.question').find('.answer_key').val());
                if (ansKey == "") {
                    console.log("You have no answer key for Question " + questionId);
                    // listOfNoAns += questionId + ", ";
                    // alert("You have no answer key for Question " + questionId);
                    noAnswerKey = true;
                }
            } else if (type === 'true-false') {
                console.log("QUESTION ID : " + qId);

                options = ['True', 'False'];
                console.log("Answer Key: " + $(this).find('.booleanSelect').val());
                ansKey = $(this).closest('.question').find('.booleanSelect').val();
            } else {
                console.log("QUESTION ID : " + qId);

                console.log("Answer Key: " + $(this).closest(".question").find(".short-text-select .short_ans_key").val());
                ansKey = $(this).closest(".question").find(".short-text-select .short_ans_key").val();
                if (ansKey == "") {
                    console.log("You have no answer key for Question " + questionId);
                    // listOfNoAns += questionId + ", ";
                    // alert("You have no answer key for Question " + questionId);
                    noAnswerKey = true;
                }
            }
            const isExistingIdInRemovedElements = removedElements.some(
                (element) => element.existingId === existingId
            );
            
            if (isExistingIdInRemovedElements) {
                console.log(`existingId "${existingId}" is already in removedElements.`);
            } else {
               removedElements.push({ question: questionText, type, options, ansKey, points, existingId, removeQuestion});
            }
        }else{
            console.log("not found");
        }
    });

    // Update display based on question type
    function updateQuestionDisplay() {
        // console.log("Len" + $('#questions-container').length);
        console.log("Len" + $('#questions-container').children().length);
        isQuizSaved = false;
        $('.question').each(function () {
            const type = $(this).find('.question-type').val();
            const options = $(this).find('.options');
            console.log("This is the option of " + $(this).find('.optionText'));
            const trueFalseSelect = $(this).find('.true-false-select');
            const shortText = $(this).find('.short-text-select');
            const answerKey = $(this).find('.answer_key');
            console.log("Type" + type);
            // console.log(answerKey.val());
            if (type === 'multiple-choice') {
                options.show();
                options.find('.option-container').show();
                shortText.hide();
                trueFalseSelect.hide();
                $(this).find('.optionText').prop('required', true);
                options.find('.option').prop('required', true); // Make multiple-choice options required
                answerKey.prop('readonly', true).show(); // Make answer key visible and readonly
                console.log("Update multi choice");
            } else if (type === 'true-false') {

                options.hide();
                options.find('.option-container').hide();
                options.find('.option').prop('required', false); // Remove required attribute from hidden inputs
                $(this).find('.optionText').prop('required', false);
                trueFalseSelect.show();
                shortText.hide();
                answerKey.prop('readonly', true).show(); // Make answer key visible and readonly
                console.log("Update true false");

                const selectedValue = trueFalseSelect.find('.booleanSelect').val();
                $(this).find(".boolean_answer_key").val(selectedValue);
                answerKey.val(selectedValue);

            } else if (type === 'short-text') {
                console.log("Update short text");

                options.hide();
                options.find('.option-container').hide();
                options.find('.option').prop('required', false); // Remove required attribute from hidden inputs
                $(this).find('.optionText').prop('required', false);
                trueFalseSelect.hide();
                shortText.show();

                answerKey.prop('readonly', false).show(); // Make answer key visible and editable
            }
        });
    }

    let noAnswerKey = false;

    let isQuizSaved = true; // Set to true when the quiz is successfully saved

    let isAddQuestionClicked = false;
    // Function to warn the user before leaving the page
    // document.querySelector('#quizInput').addEventListener('input', function () {
    //     isQuizSaved = false; // Mark as unsaved when user types
    // });

    // Function to warn the user before leaving the page
    window.addEventListener('beforeunload', function (e) {
        if (!isQuizSaved) {
            e.preventDefault();
            e.returnValue = ''; // Required for modern browsers
        }
    });

    if(isAddQuestionClicked == false){
    // Handle navigation or button clicks with SweetAlert2
        document.querySelectorAll('a, button').forEach((element) => {
            element.addEventListener('click', function (event) {
                console.log("inside checker");
                // Exempt specific buttons from the alert
                if (isAddQuestionClicked) {
                    console.log("add question clicked");
                    isAddQuestionClicked = false; // Reset the flag
                    return;
                }
                const target = event.target.closest('a, button');
                // Check if the clicked element has any of the exempt classes
                if (
                    target.dataset.exempt === 'true' || // Custom exempt logic
                    target.id === "saveBtn" || 
                    target.classList.contains("accordion-button") || 
                    target.classList.contains("accordion-button") || 
                    target.classList.contains("nav-link") || 
                    target.id === "profile" ||
                    target.id === "saveQuiz" ||
                    target.classList.contains("remove-question") ||
                    target.classList.contains("delete") ||
                    target.classList.contains("answ_key") ||
                    target.classList.contains("booleanSelect") ||
                    target.classList.contains("select_ans_key") ||
                    target.classList.contains("remove-choice") ||
                    target.classList.contains("btn-success") ||
                    target.classList.contains("dropdown-menu") ||
                    target.classList.contains("dropdown-menu show") ||
                    target.classList.contains("nav-link dropdown-menu show") ||
                    target.classList.contains("nav-link dropdown-menu") ||
                    target.classList.contains("dropdown") ||
                    target.id === "edit_quiz" ||
                    target.id === "close_code" ||
                    target.id === "menu-btn" ||
                    target.classList.contains("dropdown-item") ||
                    target.classList.contains("dropdown-menu dropdown-menu-end show") ||
                    target.classList.contains("dropdown-menu dropdown-menu-end")
                ) {
                    // If any of the conditions are met, do not show the alert
                    return;
                }
                
                if (element.classList.contains('btn-secondary')) {
                    return; // Allow normal navigation for the back button
                }
        
                // Prevent navigation for unsaved quizzes
                if (!isQuizSaved) {
                    event.preventDefault(); // Prevent default action
        
                    // Show SweetAlert2 confirmation
                    Swal.fire({
                        title: 'Unsaved Changes!',
                        text: 'You have unsaved changes. Do you want to leave this page without saving?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Leave',
                        cancelButtonText: 'Stay'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            isQuizSaved = true; // Allow navigation after confirmation
        
                            // Handle redirection for links
                            if (element.tagName === 'A' && element.href) {
                                window.location.href = element.href;
                            }
        
                            // // Handle data-href for other elements
                            // else if (element.dataset.href) {
                            //     window.location.href = element.dataset.href;
                            // }
                        }
                    });
                }
            });
        });
    }

    // document.querySelector('#quizInput').addEventListener('input', function () {
    //     isQuizSaved = false; // Mark as unsaved when user types
    // });

    console.log("Number of question : " + $('#questions-container').children().length);
    // Get class code from url, pass it as well
    // Submit quiz

    $('#quiz-form').submit(function (e) {
        e.preventDefault();
        
        if(isQuizSaved == true){
            alert("No Changes");
            return;
        }

        if($('#questions-container').children().length == 0){
    
            alert("Cannot save quiz without a question");
            return;
        }

        const urlParams = new URLSearchParams(window.location.search);
        const classCode = urlParams.get('class');
        const postId = urlParams.get('post');

        const title = $('#quiz-title').val();
        var questions = [];
        noAnswerKey = false;
        // console.log("Quiz Title : " + title);
        let listOfNoAns = "No answer key on question number : ";

        $('.question').each(function () {
            const questionText = $(this).find('.question-text').val();
            const type = $(this).find('.question-type').val();
            let questionId = $(this).closest('.question').data("id");
            const points = $(this).find('.points').val();
            const qId = $(this).find('.question-num').text();

            // console.log("QUESTION ID : " + questionId);
            let options = [];
            let ansKey = "";
            let existingId = $(this).closest(".question").find(".question-num").text();
            // console.log("Existing ID : " + existingId);
            console.log("Question : " + questionText);
            console.log("Question Type : " + type);
            console.log("Points : " + points);
            // console.log(questionText);
            if (type === 'multiple-choice') {
                // console.log("QUESTION ID : " + qId);
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
                // console.log("QUESTION ID : " + qId);

                options = ['True', 'False'];
                console.log("Answer Key: " + $(this).closest(".true-false-select").find('.booleanSelect').val());
                ansKey = $(this).find('.booleanSelect').val();
            } else {
                // console.log("QUESTION ID : " + qId);

                console.log("Answer Key: " + $(this).closest(".short-text-select").find(".short-text-select .short_ans_key").val());
                ansKey = $(this).find(".short-text-select .short_ans_key").val();
                if (ansKey == "") {
                    console.log("You have no answer key for Question " + questionId);
                    listOfNoAns += questionId + ", ";
                    // alert("You have no answer key for Question " + questionId);
                    noAnswerKey = true;
                }
            }

            questions.push({ question: questionText, type, options, ansKey, points, existingId});
        });

        console.log("Questions");
        console.table(questions);
        // console.log("\n\n");
        console.log("Removed ELements");

        console.table(removedElements);
        console.log("Removed Choices");

        console.table(removeChoices);
        if (noAnswerKey != true) {
            // console.table(questions);
            // console.log("inside");
            $.ajax({
                url: "includes/create-quiz.php",
                type: "POST",
                data: {
                    classCode: classCode,
                    postId : postId,
                    questions: JSON.stringify(questions),
                    removedElements : JSON.stringify(removedElements),
                    removeChoices : JSON.stringify(removeChoices)
                },

                success: function (response) {
                    if($("#content-type").text() == "Exam"){
                        Swal.fire({
                            title: 'Exam Saved!',
                            text: 'Your Exam has been Saved.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }else{
                        Swal.fire({
                            title: 'Quiz Saved!',
                            text: 'Your Quiz has been Saved.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }

                    isQuizSaved = true;
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

    });
});