<script>
$(document).ready(function() {
    $('#uploadCSVForm').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        // Display a loading spinner
        $("#loadingSpinner").show();
        $('#response').hide();

        $.ajax({
            type: 'POST',
            url: '../PagesContent/StudentContentFolder/ActionStudent/BatchUploadStudent.php',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                // Check if the response contains an array of errors
                if (Array.isArray(response)) {
                    // Update the element with the received errors
                    $.each(response, function(index, error) {
                        $('#errorAlert').text(error);
                        $('#errorBanner').show();
                        setTimeout(function() {
                            $("#errorBanner").fadeOut("slow");
                            // location.reload();
                        }, 11500);
                    });
                }

                if (response.hasOwnProperty('success')) {
                    $('#successAlert').text(response.success);
                    $('#successBanner').show();
                    setTimeout(function() {
                        $("#successBanner").fadeOut("slow");
                        // location.reload();
                    }, 11500);
                } else if (response.hasOwnProperty('error')) {
                    $('#errorAlert').text(response.error);
                    $('#errorBanner').show();
                    setTimeout(function() {
                        $("#errorBanner").fadeOut("slow");
                        // location.reload();
                    }, 11500);
                }
                $("#loadingSpinner").hide();
            },
            error: function(xhr, status, error) {
                console.log('AJAX error:', status, error);

                // Hide the loading spinner
                $("#loadingSpinner").hide();

                $('#errorAlert').text(xhr.responseText);
                $('#errorBanner').show();
                setTimeout(function() {
                    $("#errorBanner").fadeOut("slow");
                    // location.reload();
                }, 1500);
            }
        });
    });
    $('#uploadCSVForm').on('reset', function(e) {
        // Hide the loading spinner
        $("#loadingSpinner").hide();
    });
});
</script>