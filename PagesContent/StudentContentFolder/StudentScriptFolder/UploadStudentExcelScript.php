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
                $("#loadingSpinner").hide();

                if (Array.isArray(response)) {
                    // Update the element with the received errors
                    // Clear previous error messages
                    $("#alert_container").empty();
                    $("#alert_container").show();

                    // Update the element with the received errors
                    $.each(response, function(index, error) {
                        $('#errorAlert').text(error);
                        $('#errorBanner').show();
                        setTimeout(function() {
                            $("#errorBanner").fadeOut("slow");
                            // location.reload();
                        }, 11500);
                    });

                    // Update the element with the received errors
                    $.each(response, function(index, error) {
                        $("#alert_container").append(
                            "<div class='alert alert-danger alert-dismissible fade in errorBanner'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Error!</b><span>" +
                            error + "</span></div>");
                        $('.errorBanner').show();
                        console.log(error);
                    });

                    $.each(response, function(index, item) {
                        if (item.hasOwnProperty('error')) {
                            $("#alert_container").after(
                                "<div class='alert alert-danger alert-dismissible fade in errorBanner'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Error!</b><span>" +
                                item.error + "</span></div>");
                            $('.errorBanner').fadeIn();
                            console.log(item.error);
                        } else if (item.hasOwnProperty('success')) {
                            $("#alert_container").after(
                                "<div class='alert alert-success alert-dismissible fade in successBanner'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Error!</b><span>" +
                                item.success + "</span></div>");
                            $('.successBanner').fadeIn();

                        }
                    });
                    setTimeout(function() {
                        $("#alert_container").fadeOut("slow");
                        $('.errorBanner, .successBanner').fadeOut();
                    }, 6500);
                } else {
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
                }


                $("#loadingSpinner").hide();
            },
            error: function(xhr, status, error) {
                // console.log('AJAX error:', status, error);

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