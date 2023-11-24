<script>
$(document).ready(function() {
    var editMode = false; // Flag to track the edit mode status

    // Hide the update button initially
    $('#update-btn').hide();
    $('input, select').prop('readonly', true).prop('disabled', true);

    // Function to toggle the edit mode
    function toggleEditMode() {
        if (editMode) {
            // If edit mode is active, hide the update button and disable the inputs
            $('#update-btn').hide();
            $('input, select').prop('readonly', true).prop('disabled', true);
        } else {
            // If edit mode is inactive, show the update button and enable the inputs
            $('#update-btn').show();
            $('input, select').prop('readonly', false).prop('disabled', false);
        }
        editMode = !editMode; // Toggle the edit mode flag
    }

    // Enable input and show the update button when edit icon is clicked
    $('#edit-icon').click(function() {
        toggleEditMode();
    });

    // Hide the update button when the update button is clicked
    $('#teacher_profile').on('submit', function(e) {
        $(this).hide();
        e.preventDefault();

        var formData = new FormData(this);
        var action_url =
            "../PagesContent/ProfileContentFolder/ActionProfile/ActionEditTeacherProfile.php";

        $.ajax({
            url: action_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                // Check if the response contains an array of errors
                if (Array.isArray(response)) {
                    // Clear previous error messages
                    $("#edit_user_validate_alert_text").empty();
                    $("#edit_user_validate_alert").show();

                    // Update the element with the received errors
                    $.each(response, function(index, error) {
                        $("#edit_user_validate_alert_text").append(
                            "<p class='error'>" + error +
                            "</p><br>");
                        console.log(error);
                    });

                    setTimeout(function() {
                        $("#edit_user_validate_alert").fadeOut("slow");
                        location.reload();
                    }, 5500);
                }
                // Check if the form submission was successful
                if (response.hasOwnProperty('success')) {
                    $('#successAlert').text(response.success);
                    $('#successBanner').show();
                    setTimeout(function() {
                        $("#successBanner").fadeOut("slow");
                        location.reload();
                    }, 5500);
                } else if (response.hasOwnProperty('error')) {
                    $('#errorAlert').text(response.error);
                    $('#errorBanner').show();
                    setTimeout(function() {
                        $("#errorBanner").fadeOut("slow");
                        location.reload();
                    }, 5500);
                }
            },
            error: function() {
                //show alert banner id = errorBanner
                $('#errorAlert').text('An error occurred during the AJAX request.');
                $('#errorBanner').show();
                setTimeout(function() {
                    $("#errorBanner").fadeOut("slow");
                    location.reload();
                }, 5500);
            }
        });
    });
});
</script>