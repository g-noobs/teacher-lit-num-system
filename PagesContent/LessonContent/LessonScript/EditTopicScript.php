<script>
$(function(){
    $(document).on('click', '.edit_topic_btn', function(e){
        e.preventDefault();
        $modal = $('#edit_topic_modal');
        var topic_id = $(this).data('id');
        $modal.modal('show');
    });
});
</script>