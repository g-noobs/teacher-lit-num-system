<!-- For Logout button for Search -->
<script>
$(function() {
    $('#logoutTeachBtn').on('click', function(e) {
        $.ajax({
            url: '../ActLogoutBtn.php',
            type: 'get',

            success: function(response) {
                console.log(response);
                window.location.href = "../../index.php";
            },
            error: arguments => {
                console.log(arguments);
            }
        });
    });
});
</script>

<script>
$(function() {

    $.ajax({
        url: "../CommonCode/HeaderProcessFolder/ActionHeader.php",
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var responseData = JSON.parse(response);
            if (responseData.hasOwnProperty('name') && responseData.hasOwnProperty('email')) {
                teacher_name = responseData.name;
                teacher_email = responseData.email;
            } else if (responseData.hasOwnProperty('error')) {
                teacher_name = responseData.error;
                teacher_email = 'Error fetching data.';
            } else {
                teacher_name = 'Error fetching data.';
                teacher_email = 'Error fetching data.';
            }
            $('#teacher_name_main').text(teacher_name);
            $('#teacher_name').text(teacher_name);
            $('#teacher_email').text(teacher_email);

        },
        error: function(response) {
            teacher_name = 'Error fetching data.';
            teacher_email = 'Error fetching data.';

            $('#teacher_name_main').text(teacher_name);
            $('#teacher_name').text(teacher_name);
            $('#teacher_email').text(teacher_email);
        }
    });

});
</script>