<script>
$(function() {
    $(document).on('click', '.lesson_progress_btn', function(e) {
        e.preventDefault();

        var userId = $(this).data('id');
        $('#user_name_pd').empty(userId);
        $('#progressTable tbody').empty();

        $.ajax({
            url: "../PagesContent/GradeBookContent/ActionGradebook/GetStudentName.php",
            method: "GET",
            data: {
                id: userId
            },
            dataType: "json",
            success: function(data) {
                $.each(data, function(index, rowData) {
                    $('#user_name_pd').append(
                        '<span>' + rowData.first_name + ' ' + rowData.last_name + '</span>'
                    );
                    $('#personal_id_lp').append(
                        '<span>' + rowData.personal_id + '</span>'
                    );

                });
            },
            error: function(data) {
                console.log(data);
            }
        });

        $.ajax({
            url: "../PagesContent/GradeBookContent/ActionGradebook/GetLessonProgress.php",
            method: "GET",
            data: {
                id: userId
            },
            dataType: "json",
            success: function(data) {
                // Clear existing rows in the table body
                $('#progressTable tbody').empty();

                // Append new rows based on the data
                $.each(data, function(index, rowData) {
                    $('#progressTable tbody').append(
                        '<tr class="progressRow" data-status="' + rowData
                        .progress_status + '">' +
                        '<td>' + rowData.topic_id + '</td>' +
                        '<td>' + rowData.topic_name + '</td>' +
                        '<td>' + rowData.progress_status + '</td>' +
                        '</tr>'
                    );
                });
                
                //empty the main_gb div and fade in the lesson_progress_content div
                $('#gradebook_content').fadeOut('slow', function() {
                    $('#lesson_progress_content').show('slow');
                });
            },
            error: function(data) {
                console.log(data);
            }
        });


    });

});
</script>
