<script>
$(function() {
    $(document).on('click', '#assigned_assgn_btn', function(e) {
        e.preventDefault();
        //empty and id
        $('#assign_content').empty().fadeOut(400), function() {
            $(this).load("../PagesContent/AssignmentFolder/MainAssignment/AssignedPanel.php", function() {
                $(this).fadeIn(400);
            });
        }
    });
});
</script>