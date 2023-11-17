<!-- dropdown config -->
<script>
$(function() {
    $('.custom-dropdown-menu a').click(function(e) {
        e.preventDefault();
        var lessonType = $(this).data('quiz-type');
        var contentPath = '';

        if (lessonType === 'active-quiz') {
            location.reload();
        } else if (lessonType === 'archive-quiz') {
            contentPath = '../PagesContent/QuizFolder/TableQuiz/ArchivedQuizTable.php';
        }
        $('.custom-dropdown-toggle').html($(this).text() + '<span class="caret"></span>');
        if (contentPath !== '') {
            $("#quizContent").fadeOut(400, function() {
                $(this).load(contentPath, function() {
                    $(this).fadeIn(400);
                });
            });
        }
    });
});
</script>