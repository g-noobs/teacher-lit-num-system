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
            success: function(response) {
                var responseData = JSON.parse(response);
                // Check if the form submission was successful
                if (responseData.hasOwnProperty('success')) {
                    var msg = responseData.success;
                    $('#addLessonModal').modal('hide');
                    $('#successAlert').text(msg);
                    $('#successBanner').show();
                    setTimeout(function() {
                        $("#successBanner").fadeOut("slow");
                        location.reload();
                    }, 1500);
                }else if (responseData.hasOwnProperty('error')) {
                    var msg = responseData.error;
                    $('#addLessonModal').modal('hide');
                    $('#errorAlert').text(msg);
                    $('#errorBanner').show();
                    setTimeout(function() {
                        $("#errorBanner").fadeOut("slow");
                        location.reload();
                    }, 1500);
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