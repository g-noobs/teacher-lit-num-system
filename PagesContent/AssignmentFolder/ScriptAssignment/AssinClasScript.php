<script>
$(function() {
    $('.assign_class_btn').on('click', function() {
        var $modal = $('#assign_class_modal');
        $modal.modal('show');
        var id = $(this).data('id');
        $('#user_teacher_id').text(id);
    })
});
</script>