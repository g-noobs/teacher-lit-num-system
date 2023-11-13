<script>
$(document).ready(function() {
    $('.add_stdnt_btn').on('click', function() {

        console.log('add student button clicked');
        $('#add_student_modal').modal('show');
        var class_id = $(this).data('class-id');
        
        $('#add_student_modal').find('.modal-title').text('Add Student for Class ID: ' + class_id);

        $('#addUserForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            var $hideModal = $('#add_student_modal');
            var actionUrl =
                '../PagesContent/StudentContentFolder/ActionStudent/ActionAddStudent.php';

            $.ajax({
                url: actionUrl,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    var responseData = JSON.parse(response);
                    // Check if the form submission was successful
                    if (responseData.hasOwnProperty('success')) {
                        $hideModal.modal('hide');
                        $('#successAlert').text(responseData.success);
                        $('#successBanner').show();
                        setTimeout(function() {
                            $("#successBanner").fadeOut("slow");

                        }, 1500);


                        // You can redirect to a different page or perform other actions here
                    } else if (responseData.hasOwnProperty('error')) {
                        $hideModal.modal('hide');
                        $('#errorAlert').text(responseData.error);
                        $('#errorBanner').show();
                        setTimeout(function() {
                            $("#errorBanner").fadeOut("slow");

                        }, 1500);
                    }
                },
                error: function(xhr, status, error) {
                    $hideModal.modal('hide');
                    //show alert banner id = errorBanner
                    $('#errorAlert').text(
                        'An error occurred during the AJAX request.');
                    $('#errorBanner').show();
                    setTimeout(function() {
                        $("#errorBanner").fadeOut("slow");

                    }, 1500);

                }

            });
        });
    });
});
</script>