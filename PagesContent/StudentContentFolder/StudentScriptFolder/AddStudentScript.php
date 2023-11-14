<script>
$(document).ready(function() {
    $(document).on('click', '.add_stdnt_btn', function() {
        var $controlModal = $('#add_user_modal');


        $$controlModal.modal('show');

        var class_id = $(this).data('class-id');

        $('#add_student_modal').find('.modal-title').text('Add Student for Class ID: ' + class_id);

        $("#addUserForm").on("submit", function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            console.log(this);

            formData.append('class_id', class_id);
            
            var actionUrl = '../PagesContent/StudentContentFolder/ActionStudent/ActionAddStudent.php';

            $.ajax({
                url: actionUrl,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    // Check if the response contains an array of errors
                    if (Array.isArray(response)) {
                        // Clear previous error messages
                        $("#add_user_modal_alert_text").empty();
                        $("#add_user_modal_alert").show();

                        // Update the element with the received errors
                        $.each(response, function(index, error) {
                            $("#add_user_modal_alert_text").append(
                                "<p class='error'>" +
                                error +
                                "</p><br>");
                            console.log(error);
                        });

                        setTimeout(function() {
                            $("#add_user_modal_alert").fadeOut("slow");

                        }, 3500);
                    } else {
                        // Check if the form submission was successful
                        if (response.hasOwnProperty('success')) {
                            $controlModal.modal('hide');
                            $('#successAlert').text(response.success);
                            $('#successBanner').show();
                            setTimeout(function() {
                                $("#successBanner").fadeOut("slow");
                                location.reload();
                            }, 1500);



                        } else if (response.hasOwnProperty('error')) {
                            $controlModal.modal('hide');
                            $('#errorAlert').text(response.error);
                            $('#errorBanner').show();
                            setTimeout(function() {
                                $("#errorBanner").fadeOut("slow");
                                location.reload();
                            }, 1500);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $controlModal.modal('hide');
                    //show alert banner id = errorBanner
                    $('#errorAlert').text(
                        'An error occurred during the AJAX request.');
                    $('#errorBanner').show();
                    setTimeout(function() {
                        $("#errorBanner").fadeOut("slow");
                        location.reload();
                    }, 1500);
                }
            });
        });
    });
});
</script>