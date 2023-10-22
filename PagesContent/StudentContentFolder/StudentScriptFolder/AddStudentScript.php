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