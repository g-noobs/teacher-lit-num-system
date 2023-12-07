<script>
$(function() {
    $(document).on('click', '#assigned_assgn_btn', function(e) {
        e.preventDefault();
        //empty and id
        $('#assign_content').empty();
        //add new content that on php file
        $('#assign_content').load('../PagesContent/AssignmentFolder/MainAssignment/AssignedPanel.php');
    });
});
</script>