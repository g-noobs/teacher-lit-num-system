<script>
$(function() {
    $(".edit_quiz_btn").on('click', function(e) {
        e.preventDefault();
        $modal = $('#edit_quiz_modal');
        var btn_id = $(this).data('id');
        $modal.modal('show');
    });
});
</script>