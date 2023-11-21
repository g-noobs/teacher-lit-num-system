<script>
$(function() {
    var teacher_name = $('#teacher_name_main').text();
    $('#teacher_name_dashboard').text('Good Day! Teacher ' + teacher_name);
});
</script>


<script>
$(function() {
    $.ajax({
        url: '../PagesContent/MainContentFolder/ActionMain/ActionPopulateAssignedClass.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $.each(response, function(index, value) {
                $('#assigned_class_list').append('<li>' + value +
                    '</li>');
            });

        },
        error: function(xhr, status, error) {
            console.log(xhr);
            $('#assigned_class_list').html(
                '<li>Error loading content for assigned class</li>');
        }
    });
});
</script>

<script>
$(function() {
    $.ajax({
        url: '../PagesContent/MainContentFolder/ActionMain/ActionPopulateAssignedModule.php,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $.each(response, function(index, value) {
                $('#assigned_module_list').append('<li>' + value +
                    '</li>');
            });

        },
        error: function(xhr, status, error) {
            console.log(xhr);
            $('#assigned_class_list').html(
                '<li>Error loading content for assigned class</li>');
        }
    });
});
</script>