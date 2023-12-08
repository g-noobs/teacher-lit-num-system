<script>
$(function() {
    $(document).on('click', '.lesson_progress_btn', function(e) {
        e.preventDefault();
        var userId = $(this).data('id');
        // window.location.href = "get_progress.php?userId=" + userId;
        $.ajax({
            url: "../PagesContent/GradeBookContent/ActionGradebook/GetLessonProgress.php",
            method: "GET",
            data: {
                userId: userId
            },
            dataType: "json",
            success: function(data) {
                //append table row to table body
                $.each(data, function(index, rowData) {
                    $('#progressTable tbody').append(rowData);
                });
                //hide the main table
            },error: function(data) {
                console.log(data);
            }
        });
    });
});
</script>