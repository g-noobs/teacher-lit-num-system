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
    var teacher_name = '';
    var teacher_email = '';

    $.ajax({
        url: "../CommonCode/HeaderProcessFolder/ActionHeader.php",
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            teacher_name = response.name || 'Teacher Name is not set.';
            teacher_email = response.email || 'Teacher Email is not set.';
        },
        error: function(response) {
            teacher_name = 'Error fetching data.';
            teacher_email = 'Error fetching data.';
        }
    });
    $('#teacher_name_main').text(teacher_name);
    $('#teacher_name').text(teacher_name);
    $('#teacher_email').text(teacher_email);
});
</script>