<script>
$(function(){
    $(document).on('click', '.edit_topic_btn', function(e){
        e.preventDefault();
        var $modal = $('#edit_topic_modal');
        var topic_id = $(this).data('id');
        $modal.modal('show');

        $topic_name = $('input[name="edit_topic_name"]');
        $topic_description = $('textarea[name="edit_topic_description"]');

        $.ajax({
            type: "get",
            url: "../PagesContent/LessonContent/ActionLesson/PopulateTopicData.php",
            data: {
                id: topic_id
            },
            dataType: "json",
            success: function (response) {
                $topic_name.val(response.topic_name);
                $topic_description.val(response.topic_description);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

    });
});
</script>