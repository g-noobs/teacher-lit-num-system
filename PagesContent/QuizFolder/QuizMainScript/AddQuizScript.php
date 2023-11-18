<script>
$(function() {
    $('#addQuizForm').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var actionUrl = '../PagesContent/QuizFolder/ActionQuizFolder/ActionAddQuiz.php';

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
                    $('#successAlert').text(msg);
                    $('#successBanner').show();
                    setTimeout(function() {
                        $("#successBanner").fadeOut("slow");
                        location.reload();
                    }, 1500);
                } else if (responseData.hasOwnProperty('error')) {
                    var msg = responseData.error;
                    $('#errorAlert').text(msg);
                    $('#errorBanner').show();
                    setTimeout(function() {
                        $("#errorBanner").fadeOut("slow");
                        location.reload();
                    }, 1500);
                }
            }
        });

    });
});
</script>


<!-- hide box isntead of remove -->