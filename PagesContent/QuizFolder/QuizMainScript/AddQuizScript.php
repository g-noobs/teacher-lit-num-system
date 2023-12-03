<script>
$(function() {
    $('#add_quiz_modal').on('click', function(e) {
        e.preventDefault();
        var $modal = $('#addQuizModal');
        $modal.modal('show');
        $('.addQuizForm').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            var actionUrl = '../PagesContent/QuizFolder/ActionQuizFolder/ActionAddQuiz.php';

            $.ajax({
                url: actionUrl,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
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

                        }, 8500);
                    } else {
                        // Check if the form submission was successful
                        if (response.hasOwnProperty('success')) {
                            var msg = response.success;
                            $('#successAlert').text(msg);
                            $('#successBanner').show();
                            setTimeout(function() {
                                $("#successBanner").fadeOut("slow");
                                location.reload();
                            }, 4500);
                        } else if (response.hasOwnProperty('error')) {
                            var msg = response.error;
                            $('#errorAlert').text(msg);
                            $('#errorBanner').show();
                            setTimeout(function() {
                                $("#errorBanner").fadeOut("slow");
                                location.reload();
                            }, 4500);
                        }
                    }
                },
                error: function() {
                    $("#addQuizForm")[0].reset();
                    $hideModal.modal('hide');
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


<!-- hide box isntead of remove -->