$(document).ready(function () {
    let noChanges = true;
    let initDeduction =  0;
    // Remove existing click handlers before attaching a new one
    $(document).off('click', '#setting-button').on('click', '#setting-button', function (event) {
        event.preventDefault();
        console.log("aweqw");
        const urlParams = new URLSearchParams(window.location.search);
        const classCode = urlParams.get('class');
        $.ajax({
            method: "POST",
            url: "includes/get-grade-system.php",
            data: {
                class : classCode
            },
      
            success: function(response) {
                console.table(response);
                
                response.forEach(element => {
                    updateOptions();
                    $("#act_wg").val(element["act_wg"]);
                    $("#quiz_wg").val(element["quiz_wg"]);
                    $("#exam_wg").val(element["exam_wg"]);
                    $("#deduction").val(element["deduction"]);
                    initDeduction = element["deduction"];
                    updateOptions();
                });
 
                $('#editGradeSetting').modal('show');     
            },
            error: function(xhr, status, error) {
              console.log("Status "+ status + " An error occured" + error)
            }
          });

    });

    function updateOptions() {
        const totalLimit = 100;
        const act_wg = parseInt($('#act_wg').val());
        const quiz_wg = parseInt($('#quiz_wg').val());
        const exam_wg = parseInt($('#exam_wg').val());
        const totalSelected = act_wg + quiz_wg + exam_wg;
        const remaining = totalLimit - totalSelected;

        // Show all options initially
        $('#act_wg option, #quiz_wg option, #exam_wg option').show();

        // Hide options based on the remaining total
        $('#act_wg option, #quiz_wg option, #exam_wg option').each(function() {
            const optionValue = parseInt($(this).val());
            if (optionValue > remaining) {
                $(this).hide(); 
            }
        });
    }

    $('#act_wg, #quiz_wg, #exam_wg').change(function() {
        noChanges = false;
        updateOptions();
    });

    // updateOptions();

    $('#deduction').on('input', function(){
        var inputVal = $(this).val();
        console.log(inputVal);
        if(inputVal > 100){
            $(this).val(100);
        }
        if (inputVal === "" || isNaN(inputVal) || !Number.isInteger(parseFloat(inputVal)) || parseInt(inputVal) <= 0) {
            $(this).val(1);
            $('#errorMessage').text("Please enter a valid integer that is less than or equal to 0.");
        } else {
            $('#errorMessage').text(""); // Clear any error message
        }
    });


    $('#editGradeForm').off('submit').on('submit', function (e) {
        console.log("DEDUCTION INITIAL " + initDeduction);

        e.preventDefault();
        
        if(noChanges == true){
        
            return;
        }
        
        const urlParams = new URLSearchParams(window.location.search);
        const classCode = urlParams.get('class');
        let actWg = $("#act_wg").val();
        let quizWg = $("#quiz_wg").val();
        let examWg = $("#exam_wg").val();
        let deduction = $("#deduction").val();


        if(actWg <= 0 || quizWg <= 0 || quizWg <= 0 || deduction <= 0){
            Swal.fire({
                title: 'Invalid Input!',
                text: 'Weighted Grades should be above 0',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        let sum = parseInt(actWg) + parseInt(examWg) + parseInt(quizWg);
        console.log(sum);
        if(sum != 100){
            Swal.fire({
                title: 'Invalid Total!',
                text: 'Weighted Grades should have a sum of 100',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        console.log(actWg);
        console.log(quizWg);
        console.log(examWg);
        console.log(deduction);

        $.ajax({
            method: "POST",
            url: "includes/edit-grade-system.php",
            data: {
                classCode : classCode,
                actWg : actWg,
                quizWg : quizWg,
                examWg : examWg,
                deduction : deduction,
                oldDeduct : initDeduction
            },
      
            success: function(response) {
                console.log(response);
                if(response.includes("Success")){
                    initDeduction = deduction;
                    Swal.fire({
                        title: 'Success!',
                        text: 'Edit Success',
                        icon: 'success'
                    });
                }else{
                    Swal.fire({
                        title: 'Edit Failed!',
                        text: 'Something went wrong',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
              console.log("Status "+ status + " An error occured" + error)
            }
          });

    });
});

