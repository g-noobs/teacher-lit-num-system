<script>
$(document).ready(function() {
    $("#addLessonForm").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        var actionUrl = '../PagesContent/LessonContent/ActionLesson/ActionAddLesson.php';
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
                        $("#add_user_modal_alert_text").append("<p class='error'>" +
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
                        $('#addLessonModal').modal('hide');
                        $('#successAlert').text(msg);
                        $('#successBanner').show();
                        setTimeout(function() {
                            $("#successBanner").fadeOut("slow");
                            location.reload();
                        }, 1500);
                    } else if (response.hasOwnProperty('error')) {
                        var msg = response.error;
                        $('#addLessonModal').modal('hide');
                        $('#errorAlert').text(msg);
                        $('#errorBanner').show();
                        setTimeout(function() {
                            $("#errorBanner").fadeOut("slow");
                            location.reload();
                        }, 1500);
                    }
                }
            },
            error: function(response) {
                console.log(response);
                var msg = "Possible Ajax issue!"
                $('#errorMessage').text(msg);
                $('#errorModal').modal('show');

                setTimeout(function() {
                    $("#errorModal").fadeOut(
                        "slow"); // Hide the .alert element after 3 seconds
                    location.reload();
                }, 1500);
            }
        });
    });
});
</script>