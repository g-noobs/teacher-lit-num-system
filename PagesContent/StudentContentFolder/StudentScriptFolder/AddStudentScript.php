<script>
$(function(){
    $('#add_student_form').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this);
        
        var $hideModal = $('#add_student_modal');
        var actionUrl = '../PagesContent/StudentContentFolder/ActionStudent/ActionAddStudent.php';

        <?php include_once "../CommonScript/AjaxFormScript.php"?>
    });
});
</script>

<!-- Clear the modal once hidden or closed  -->
<script>
$(document).ready(function() {
    // Add an event listener to the modal
    $('#add_student_modal').on('hidden.bs.modal', function () {
        // Get the form inside the modal and reset it
        $('#add_student_form')[0].reset();
    });
});
</script>