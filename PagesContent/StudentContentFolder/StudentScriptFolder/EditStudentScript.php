<script>
$(function() {
    $('.edit').on('click', function(e) {
        e.preventDefault();
        $('#submit_btn').text('Update');
        var btn_id = $(this).data('id');

        $personal_id = $('input[name="personal_id"]');
        $last_name = $('input[name="last_name"]');
        $first_name = $('input[name="first_name"]');
        $user_middle_initial = $('input[name="user_middle_initial"]');
        $gender = $('select[name="gender"]');
        $phone_num = $('input[name="phone_num"]');
        $email = $('input[name="email"]');
        $street_address = $('input[name="street_address"]');
        $barangay_address = $('input[name="barangay_address"]');
        $city_address = $('input[name="city_address"]');
        $province_address = $('input[name="province_address"]');
        $zip_code = $('input[name="zip_code"]');
        $guardian_last_name = $('input[name="guardian_last_name"]');
        $guardian_first_name = $('input[name="guardian_first_name"]');
        $guardian_middle_name = $('input[name="guardian_middle_name"]');
        $guardian_phone_num = $('input[name="guardian_phone_num"]');

        //this will populate the date to the modal
        $.ajax({
            type: "POST",
            url: "../PagesContent/UserContent/ActionsUsers/ActionPopulateStudentData.php",
            data: {
                id: btn_id
            },
            dataType: 'json',
            success: function(response) {
                $('#add_user_modal').modal('show');

                $personal_id.val(response.personal_id);
                $last_name.val(response.last_name);
                $first_name.val(response.first_name);
                $user_middle_initial.val(response.middle_initial);
                $gender.find('option').each(function() {
                    if ($(this).val() === response.gender) {
                        $(this).prop('selected', true);
                        return false;
                    }
                });
                $phone_num.val(response.phone_num);
                $email.val(response.email);
                $street_address.val(response.street);
                $barangay_address.val(response.barangay);
                $city_address.val(response.municipal_city);
                $province_address.val(response.province);
                $zip_code.val(response.postal_code);
                $guardian_last_name.val(response.guardian_last_name);
                $guardian_first_name.val(response.guardian_first_name);
                $guardian_middle_name.val(response.guardian_middle_name);
                $guardian_phone_num.val(response.guardian_phone_num);

            },
            error: function() {
                console.log('error');
            }
        });
        $('.addUserForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            // Merge additional data with formData
            formData.append('id', btn_id);
            var $hideModal = $('#add_user_modal');
            var actionUrl = '../PagesContent/UserContent/ActionsUsers/ActionEditStudentData.php';

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
                            $hideModal.modal('hide');
                            $('#successAlert').text(response.success);
                            $('#successBanner').show();
                            setTimeout(function() {
                                $("#successBanner").fadeOut("slow");
                                location.reload();
                            }, 8500);



                        } else if (response.hasOwnProperty('error')) {
                            $hideModal.modal('hide');
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
                    $hideModal.modal('hide');
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