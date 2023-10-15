<script>
$(function() {
    var teacher_name;
    var teacher_email;

    $.ajax({
        url: "../CommonCode/HeaderProcessFolder/ActionHeader.php",
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            teacher_name = response.name || 'Teacher Name is not set.';
            teacher_email = response.email || 'Teacher Email is not set.';
        },
        error: function() {
            teacher_name = 'Error fetching data.';
            teacher_email = 'Error fetching data.';
        }
    });
    $('#teacher_name_main').text(teacher_name);
    $('#teacher_name').text(teacher_name);
    $('#teacher_email').text(teacher_email);
});
</script>