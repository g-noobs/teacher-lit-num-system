<script>
$(function() {
    $('.edit').on('click', function(e) {
        e.preventDefault();
        $('#submit_btn').text('Update Module');
        $modal = $('#addLessonModal');
        $modal.modal('show');
        var btn_id = $(this).data('id');
        $lesson_name = $('input[name="lesson_name"]');
        $lesson_description = $('textarea[name="lesson_description"]');
        $category_level = $('select[name="category_level"]');
        //known as module
        $subj_list = $('select[name="subj_list"]');

        $.ajax({
            type: "POST",
            url: "../PagesContent/LessonContent/ActionLesson/PopulateLessonData.php",
            data: {
                id: btn_id
            },
            dataType: 'json',
            success: function(response) {
                $lesson_name.val(response.lesson_name);
                $lesson_description.val(response.lesson_description);

                $category_level.find('option').each(function() {
                    if ($(this).val() === response.category_id) {
                        $(this).prop('selected', true);
                        return false;
                    }
                });
                $subj_list.find('option').each(function() {
                    if ($(this).val() === response.module_id) {
                        $(this).prop('selected', true);
                        return false;
                    }
                });
                $modal.modal('show');
            },
            error: function() {
                console.log('error');
            }
        });
        $('.addLessonForm').on('submit', function(e){
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('id', btn_id);
            var actionUrl = '../PagesContent/LessonContent/ActionLesson/ActionEditLesson.php';
            
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

                        }, 8500);
                    } else {
                        // Check if the form submission was successful
                        if (response.hasOwnProperty('success')) {
                            $modal.modal('hide');
                            $('#successAlert').text(response.success);
                            $('#successBanner').show();
                            setTimeout(function() {
                                $("#successBanner").fadeOut("slow");
                                location.reload();
                            }, 8500);



                        } else if (response.hasOwnProperty('error')) {
                            $modal.modal('hide');
                            $('#errorAlert').text(response.error);
                            $('#errorBanner').show();
                            setTimeout(function() {
                                $("#errorBanner").fadeOut("slow");
                                location.reload();
                            }, 8500);
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
                    }, 8500);
                }
            });
        });
    });
});
</script>