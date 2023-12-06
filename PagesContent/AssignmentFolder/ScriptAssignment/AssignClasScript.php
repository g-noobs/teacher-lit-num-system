<script>
$(function() {
    $('.assign_class_btn').on('click', function() {
        var $modal = $('#assign_class_modal');
        $modal.modal('show');
        var assignment_id = $(this).data('id');
        $('#user_teacher_id').text(assignment_id);

        $('#assign_class_form').on('submit', function(e){
            e.preventDefault();
            
            var formData = new FormData(this);
            formData.append('assignment_id', assignment_id);
            $.ajax({
                url: '../Database/AssignClass.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                // Check if the form submission was successful
                if (response.hasOwnProperty('success')) {
                    $('#assign_class_form')[0].reset();
                    $modal.modal('hide');

                    $('#successAlert').text(response.success);
                    $('#successBanner').show();
                    setTimeout(function() {
                        $("#successBanner").fadeOut("slow");
                        location.reload();
                    }, 1500);
                } else if (response.hasOwnProperty('error')) {
                    $modal.modal('hide');
                    $('#assign_class_form')[0].reset();
                    $('#errorAlert').text(response.error);
                    $('#errorBanner').show();
                    // setTimeout(function() {
                    //     $("#errorBanner").fadeOut("slow");
                    //     location.reload();
                    // }, 1500);
                }
            },
            error: function() {
                $modal.modal('hide');
                $('#assign_class_form')[0].reset();
                //show alert banner id = errorBanner
                $('#errorAlert').text('An error occurred during the AJAX request.');
                $('#errorBanner').show();
                // setTimeout(function() {
                //     $("#errorBanner").fadeOut("slow");
                //     location.reload();
                // }, 1500);
            }
            });

        });
    })
});
</script>