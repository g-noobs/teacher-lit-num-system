<script>
$(function() {
    $('#quiz_type_option').on('change', function() {
        var selectedoption = $(this).val();

        var multipleChoice = "<div class='form-group'>" +
            "<label for='quiz_answer'>Set the Correct Answer</label>" +
            "<select name='quiz_answer' id='quiz_answer'>" +
            "<option></option>" +
            "<option></option>" +
            "<option></option>" +
            "<option></option>" +
            "</select>" +
            "<small>*Choose the correct answer based on the option provided</small>" +
            "</div>" +
            "<div class='row'>" +
            "<div class='col-xs-6'>" +
            "<div class='form-group'>" +
            "<label for='option1'>Option 1</label>" +
            "<input type='text' name='option1' class='form-control' required>" +
            "</div>" +
            "<div class='form-group'>" +
            "<label for='option2'>Option 2</label>" +
            "<input type='text' name='option2' class='form-control' required>" +
            "</div>" +
            "</div>" +
            "<div class='col-xs-6'>" +
            "<div class='form-group'>" +
            "<label for='option3'>Option 3</label>" +
            "<input type='text' name='option3' class='form-control' required>" +
            "</div>" +
            "<div class='form-group'>" +
            "<label for='option4'>Option 4</label>" +
            "<input type='text' name='option4' class='form-control' required>" +
            "</div>" +
            "</div>" +
            "</div>";

        var trueFalse = "<div class='form-group'>" +
            "<label for='quiz_answer'>Set the Correct Answer</label>" +
            "<select name='quiz_answer' id='quiz_answer' class='form-control'>" +
            "<option value='true'>True</option>" +
            "<option value='false'>False</option>" +
            "</select>" +
            "</div>";
        var essayAnswer = "<div class='form-group'>" +
            "<label for='quiz_answer'>Provide the Essay Key Answers</label>" +
            "<textarea name='quiz_answer' id='quiz_answer' class='form-control' cols='60' rows='5' style='resize: vertical;' required></textarea>" +
            "</div>";

        if (selectedoption === '0') {
            $("#answer_col_right").empty();
            $('#answer_col_right').append(multipleChoice);
        } else if (selectedoption === '1') {
            $("#answer_col_right").empty();
            $('#answer_col_right').append(trueFalse);
        } else if (selectedoption === '2') {
            $("#answer_col_right").empty();
            $('#answer_col_right').append(essayAnswer);
        }


        var $quizAnswer = $("#quiz_answer");
        var $quizOptions = $quizAnswer.find("option");

        // Cache the input fields
        var $option1 = $("input[name='option1']");
        var $option2 = $("input[name='option2']");
        var $option3 = $("input[name='option3']");
        var $option4 = $("input[name='option4']");

        // Function to update the options based on input values
        function updateQuizAnswerOptions() {
            var optionValues = [];

            // Push the values of input fields to the array
            optionValues.push($option1.val());
            optionValues.push($option2.val());
            optionValues.push($option3.val());
            optionValues.push($option4.val());

            // Update the select options with the new values
            $quizOptions.each(function(index) {
                $(this).text(optionValues[index]);
                $(this).val(optionValues[index]);
            });
        }

        // Call the function when any of the input fields change
        $option1.on("input", updateQuizAnswerOptions);
        $option2.on("input", updateQuizAnswerOptions);
        $option3.on("input", updateQuizAnswerOptions);
        $option4.on("input", updateQuizAnswerOptions);
    });
});
</script>