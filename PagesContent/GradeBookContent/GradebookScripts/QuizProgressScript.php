<script>
$(function() {
    $(document).on('click', '.quiz_progress_btn', function(e) {
        e.preventDefault();
        var userId = $(this).data('id');
        $('#personal_id_quiz').empty(userId);
        $.ajax({
            url: "../PagesContent/GradeBookContent/ActionGradebook/GetQuizProgress.php",
            method: "GET",
            data: {
                id: userId
            },
            dataType: "json",
            success: function(data) {
                $('#quizProgressTable tbody').empty();

                // Append new rows based on the data
                $.each(data, function(index, rowData) {
                    $('#quizProgressTable tbody').append(
                        '<tr class="quizProgressRow" data-score="' + rowData
                        .quiz_score + '">' +
                        '<td>' + rowData.quiz_id + '</td>' +
                        '<td>' + rowData.quiz_question + '</td>' +
                        '<td>' + rowData.quiz_score + '</td>' +
                        '</tr>'
                    );
                });
                //empty the main_gb div and fade in the lesson_progress_content div
                $('#gradebook_content').fadeOut('slow', function() {
                    $('#quiz_progress_content').show('slow');
                });
            },
            error: function(data) {
                console.log(data);
            }

        });
    });
});
</script>