<script>
$(document).ready(function() {

    var $modalControl = $('#archive_modal');
    // Check or uncheck all checkboxes when the "Select All" checkbox is clicked
    $("#select-all").on('click', function() {
        $(".checkbox").prop("checked", $(this).prop("checked"));
    });

    // Handle the update button click event
    $("#archive_btn").click(function() {

        var selectedIds = [];
        // Iterate through all checked checkboxes and collect their values
        $(".checkbox:checked").each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            // Show a modal if no checkboxes are selected
            $('#no_data_selected_modal').modal('show');
        } else {
            $modalControl.modal('show');
            $('#confirm_archive').on('click', function() {
                //Ajax code
                var action_url =
                    "../PagesContent/ClassContent/ActionFolder/ActivateArchiveClassAction.php";

                $.ajax({
                    type: "POST",
                    url: action_url,
                    data: {
                        selectedIds: selectedIds,
                        status: 0
                    },
                    success: function(response) {
                        var responseData = JSON.parse(response);
                        // Check if the form submission was successful
                        if (responseData.hasOwnProperty('success')) {
                            $modalControl.modal('hide');
                            $('#successAlert').text(responseData.success);
                            $('#successBanner').show();
                            setTimeout(function() {
                                $("#successBanner").fadeOut("slow");
                                location.reload();
                            }, 1500);


                            // You can redirect to a different page or perform other actions here
                        } else if (responseData.hasOwnProperty('error')) {
                            $modalControl.modal('hide');
                            $('#errorAlert').text(responseData.error);
                            $('#errorBanner').show();
                            setTimeout(function() {
                                $("#errorBanner").fadeOut("slow");
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: function() {
                        $modalControl.modal('hide');
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
        }
    });
});
</script>