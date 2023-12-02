<script>
$('.edit').on('click', function(e) {
    e.preventDefault();
    $('#submit_btn').text('Update Module');
    $modal = $('#addLessonModal');

    var btn_id = $(this).data('id');
    $lesson_name = $('input[name="lesson_name"]');
    $lesson_description = $('textarea[name="lesson_description"]');
    

});
</script>