<script>
$(document).ready(function() {
    // Cache the select element and its options
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
</script>