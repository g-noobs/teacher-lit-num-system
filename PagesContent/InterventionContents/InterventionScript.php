<script>
$(function() {
    $(document).on('change', '#status_update', function(e){
        e.preventDefault();
         // Get the selected value
        var selectedValue = $(this).val();

        // Get the intervention_id from the data-id attribute
        var interventionId = $(this).data('id');
        var actionUrl = '';

        console.log("Received value: "+ selectedValue +" Received intervention ID: "+ interventionId);
        // $.ajax({
        //     type: 'POST',
        //     url: actionUrl,
        //     data:{

        //     },
        //     dataType: 'json',
        //     success:function(response){

        //     },
        //     error: function(repsonse){

        //     }
        // });
    });
});
</script>

<!-- add to intervention -->
<script>
$(function() {
    $(document).on('click', '#intervention_admit_btn', function(e) {
        e.preventDefault();
        $modal = $('#add_intervention_modal').show();
        $modal.modal('show');

        $(document).on('submit', '#intervention_form', function(e){
            e.preventDefault();
            var formData = new FormData(this);
            var actionUrl = '../PagesContent/InterventionContents/ActionAddIntervention.php';

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

                        }, 10500);
                    } else {
                        // Check if the form submission was successful
                        if (response.hasOwnProperty('success')) {
                            $modal.modal('hide');
                            $('#successAlert').text(response.success);
                            $('#successBanner').show();
                            setTimeout(function() {
                                $("#successBanner").fadeOut("slow");
                                location.reload();
                            }, 1500);
                        } else if (response.hasOwnProperty('error')) {
                            $modal.modal('hide');
                            $('#errorAlert').text(response.error);
                            $('#errorBanner').show();
                            setTimeout(function() {
                                $("#errorBanner").fadeOut("slow");
                                location.reload();
                            }, 5500);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $modal.modal('hide');
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

        // $(document).on('click', '#confirm_intervention', function() {
        //     $.ajax({
        //         type: 'POST',
        //         url: '../PagesContent/GradeBookContent/ActionGradebook/ActionAddIntervention.php',
        //         data: {
        //             student_id: $student_id
        //         },
        //         success: function(response) {
        //             var responseData = JSON.parse(response);
        //             // Check if the form submission was successful
        //             if (responseData.hasOwnProperty('success')) {
        //                 $modal.modal('hide');
        //                 $('#successAlert').text(responseData.success);
        //                 $('#successBanner').show();
        //                 setTimeout(function() {
        //                     $("#successBanner").fadeOut("slow");
        //                     location.reload();
        //                 }, 5500);


        //                 // You can redirect to a different page or perform other actions here
        //             } else if (responseData.hasOwnProperty('error')) {
        //                 $modal.modal('hide');
        //                 $('#errorAlert').text(responseData.error);
        //                 $('#errorBanner').show();
        //                 setTimeout(function() {
        //                     $("#errorBanner").fadeOut("slow");
        //                     location.reload();
        //                 }, 5500);
        //             }
        //         },
        //         error: function() {
        //             $modal.modal('hide');
        //             //show alert banner id = errorBanner
        //             $('#errorAlert').text(
        //                 'An error occurred during the AJAX request.');
        //             $('#errorBanner').show();
        //             setTimeout(function() {
        //                 $("#errorBanner").fadeOut("slow");
        //                 location.reload();
        //             }, 5500);
        //         }
        //     });
        // });
        // Ajax code
    });
});
</script>