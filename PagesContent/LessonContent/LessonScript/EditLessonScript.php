<script>
$(function() {
    $('.edit').on('click', function(e) {
        e.preventDefault();
        $('#submit_btn').text('Update Module');
        $modal = $('#addLessonModal');
        $modal.modal('show');
        var btn_id = $(this).data('id');
        $lesson_name = $('input[name="lesson_name"]');
        $lesson_description = $('textarea[name="lesson_description"]');
        $category_level = $('select[name="category_level"]');
        //known as module
        $subj_list = $('select[name="subj_list"]');

        $.ajax({
            type: "POST",
            url: "../PagesContent/LessonContent/ActionLesson/PopulateLessonData.php",
            data: {
                id: btn_id
            },
            dataType: 'json',
            success: function(response) {
                $lesson_name.val(response.lesson_name);
                $lesson_description.val(response.lesson_description);

                $category_level.find('option').each(function() {
                    if ($(this).val() === response.category_id) {
                        $(this).prop('selected', true);
                        return false;
                    }
                });
                $subj_list.find('option').each(function() {
                    if ($(this).val() === response.module_id) {
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