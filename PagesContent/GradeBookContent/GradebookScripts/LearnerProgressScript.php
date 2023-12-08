<script>
$(function() {
    $(document).on('click', '.lesson_progress_btn', function(e) {
        e.preventDefault();
        var userId = $(this).data('id');
        window.location.href = "get_progress.php?userId=" + userId;
    });
});
</script>