
$.ajax({
    url: actionUrl,
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {
        var responseData=JSON.parse(response);
        // Check if the form submission was successful
        if (responseData.hasOwnProperty('success')) {
            $hideModal.modal('hide');
            $('#successAlert').text(responseData.success);
            $('#successBanner').show();
            setTimeout(function() {
                    $("#successBanner").fadeOut("slow");
                    location.reload();
                },1500);
            
        }
        else if (responseData.hasOwnProperty('error')) {
            $hideModal.modal('hide');
            $('#errorAlert').text(responseData.error);
            $('#errorBanner').show();

            setTimeout(function() {
                    $("#errorBanner").fadeOut("slow");
                    location.reload();
                }, 1500);
        }
    },
    error: function() {
        $hideModal.modal('hide');
        //show alert banner id = errorBanner
        $('#errorAlert').text('An error occurred during the AJAX request.');
        $('#errorBanner').show();

        setTimeout(function() {
                $("#errorBanner").fadeOut("slow");
                location.reload();
            }, 1500);
    }
});
