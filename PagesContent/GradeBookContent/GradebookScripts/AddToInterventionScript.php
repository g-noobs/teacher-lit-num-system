<script>
$(function() {
    $(document).on('click', '.intervention_btn', function(e) {
        e.preventDefault();
        var $id = $(this).data('id');
        // get the data from the second column of the table
        var $first_name = $(this).closest('tr').find('td:eq(1)').text();
        var $last_name = $(this).closest('tr').find('td:eq(2)').text();
        var $student_name = $first_name + " " + $last_name;
        $('#studername_intervention').empty();
        $('#studername_intervention').text($student_name);
        var $modal = $('#intervention_modal');

        $.ajax({
            type: 'POST',
            url: '../PagesContent/GradeBookContent/ActionGradebook/ActionAddIntervention.php',
            data: {
                id: $id
            },
            success: function(response) {
                var responseData = JSON.parse(response);
                // Check if the form submission was successful
                if (responseData.hasOwnProperty('success')) {
                    $modal.modal('hide');
                    $('#successAlert').text(responseData.success);
                    $('#successBanner').show();
                    setTimeout(function() {
                        $("#successBanner").fadeOut("slow");
                        location.reload();
                    }, 5500);


                    // You can redirect to a different page or perform other actions here
                } else if (responseData.hasOwnProperty('error')) {
                    $modal.modal('hide');
                    $('#errorAlert').text(responseData.error);
                    $('#errorBanner').show();
                    setTimeout(function() {
                        $("#errorBanner").fadeOut("slow");
                        location.reload();
                    }, 5500);
                }
            },
            error: function() {
                $modal.modal('hide');
                //show alert banner id = errorBanner
                $('#errorAlert').text(
                    'An error occurred during the AJAX request.');
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