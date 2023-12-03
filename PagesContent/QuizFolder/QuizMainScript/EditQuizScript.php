<script>
$(function() {
    $(".edit_quiz_btn").on('click', function(e) {
        e.preventDefault();
        $modal = $('#add_quiz_modal');
        var btn_id = $(this).data('id');
        $modal.modal('show');

        $topic_id = $('select[name="topic_id"]');
        $quiz_type = $('select[name="quiz_type_option"]');
        $question = $('textarea[name="quiz_question"]');
        $quiz_answer = $('select[name="quiz_answer"]');

        $.ajax({
            type: "POST",
            url: "../PagesContent/QuizFolder/ActionQuizFolder/PopulateQuizData.php",
            data: {
                id: btn_id
            },
            dataType: 'json',
            success: function(response) {
                $topic_id.find('option').each(function() {
                    if ($(this).val() === response.topic_id) {
                        $(this).prop('selected', true);
                        return false;
                    }
                });
                $quiz_type.find('option').each(function() {
                    if ($(this).val() === response.quiz_type) {
                        $(this).prop('selected', true);
                        return false;
                    }
                });
                $question.val(response.quiz_question);


                $quiz_answer.find('option').each(function() {
                    if ($(this).val() === response.quiz_answer) {
                        $(this).prop('selected', true);
                        return false;
                    }
                });
                $modal.modal('show');
            },
            error: function() {
                console.log('error');
            }
        });
    });
});
</script>