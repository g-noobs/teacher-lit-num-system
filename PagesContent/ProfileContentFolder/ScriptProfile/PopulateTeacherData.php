<script>
$(function() {
    $last_name = $('input[name="last_name"]');
    $first_name = $('input[name="first_name"]');
    $middle_initial = $('input[name="middle_initial"]');
    $gender = $('select[name="gender"]');
    $phone = $('input[name="phone"]');
    $email = $('input[name="email"]');
    $street = $('input[name="street"]');
    $baranggay = $('input[name="baranggay"]');
    $city_municipality = $('input[name="city_municipality"]');
    $province = $('input[name="province"]');
    $zip_code = $('input[name="zip_code"]');

    $username = $('input[name="username"]');
    $password = $('input[name="password"]');
    $confirm_pass = $('input[name="confirm_pass"]');

    $.ajax({
        type: 'get',
        url: "../PagesContent/ProfileContentFolder/ActionProfile/ActionPopulateData.php",
        dataType: 'json',
        success: function(response) {

            $last_name.val(response.last_name);
            $first_name.val(response.first_name);
            $middle_initial.val(response.first_name);
            $gender.val(response.gender);
            $phone.val(response.phone);
            $email.val(response.email);
            $street.val(response.street);
            $baranggay.val(response.baranggay);
            $city_municipality.val(response.city_municipality);
            $province.val(response.province);
            $zip_code.val(response.zip_code);
            $username.val(response.username);
            $password.val(response.password);
            $confirm_pass.val(response.confirm_pass);

            if (response.hasOwnProperty('error')) {
                $('#errorAlert').text(response.error);
                $('#errorBanner').show();
                setTimeout(function() {
                    $("#errorBanner").fadeOut("slow");
                    location.reload();
                }, 10500);
            }
        },
        error: function() {
            console.log('error');
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
</script>