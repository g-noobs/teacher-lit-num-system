<script>
$(function() {
    $(document).on('click', '.remove_inter_btn', function(e) {
        e.preventDefault();
        var $id = $(this).data('id');
        var $student_name = $(this).closest('tr').find('td:eq(0)').text();
        $('#studername_intervention').empty();
        $('#studername_intervention').text($student_name);
        var $modal = $('#intervention_modal');
        $modal.modal('show');

        $(document).on('click', '#confirm_finish_intervention', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'GET',
                url: '../PagesContent/InterventionContents/ActionIntervention.php',
                data: {
                    id: $id
                },
                dataType: 'json',
                success: function(response) {
                    // Check if the form submission was successful
                    if (response.hasOwnProperty('success')) {
                        $modal.modal('hide');
                        $('#successAlert').text(response.success);
                        $('#successBanner').show();
                        setTimeout(function() {
                            $("#successBanner").fadeOut("slow");
                            location.reload();
                        }, 5500);
                    } else if (response.hasOwnProperty('error')) {
                        $modal.modal('hide');
                        $('#errorAlert').text(response.error);
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

});
</script>