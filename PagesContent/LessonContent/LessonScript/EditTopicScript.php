<script>
$(function(){
    $(document).on('click', '.edit_topic_btn', function(e){
        e.preventDefault();
        var $modal = $('#edit_topic_modal');
        var btn_id = $(this).data('id');
        
        $topic_name = $('input[name="edit_topic_name"]');
        $topic_description = $('textarea[name="edit_topic_description"]');

        $.ajax({
            type: "POST",
            url: "../PagesContent/LessonContent/ActionLesson/PopulateTopicData.php",
            data: {
                id: btn_id
            },
            dataType: "json",
            success: function(response) {
                $topic_name.val(response.topic_name);
                $topic_description.val(response.topic_description);
                $modal.modal('show');

            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });

    });
});
</script>