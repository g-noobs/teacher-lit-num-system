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
        $('#edit_topic_form').on('submit', function(e){
            e.preventDefault();
            var $form = $(this);
            var $inputs = $form.find("input, select, button, textarea");
            var serializedData = $form.serialize();
            $inputs.prop("disabled", true);
            $.ajax({
                url: "../PagesContent/LessonContent/ActionLesson/EditTopic.php",
                type: "POST",
                data: serializedData,
                success: function(response){
                    if(response == "success"){
                        $modal.modal('hide');
                        $inputs.prop("disabled", false);
                        window.location.reload();
                    }else{
                        $modal.modal('hide');
                        $inputs.prop("disabled", false);
                        alert(response);
                    }
                },
                error: function(xhr, status, error){
                    console.log(xhr.responseText);
                }
            });
        });
    });
});
</script>