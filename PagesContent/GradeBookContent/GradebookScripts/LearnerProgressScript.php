<script>
$(function() {
    
    $(document).on('click', '.lesson_progress_btn', function(e) {
        e.preventDefault();

        var userId = $(this).data('id');
        $('#user_name').empty(userId);
        $('#progressTable tbody').empty();

        //fadeout the content of the id gradebook_content, then fade in php file

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


<!-- <script>
$(document).ready(function() {
    // Attach change event handler to the select element
    $(document).on('change', '#filterSelect', function() {
        // Call the applyFilter function when the selection changes
        applyFilter();
    });

    function applyFilter() {
        var filter = document.getElementById('filterSelect').value;
        var rows = Array.from(document.getElementsByClassName('progressRow'));

        for (var i = 0; i < rows.length; i++) {
            var status = rows[i].getAttribute('data-status');

            if (filter === 'all' || (filter === 'completed' && status.includes('Completed')) || (filter ===
                    'not_completed' && status.includes('Not Yet Taken'))) {
                rows[i].style.display = 'table-row';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }

});
</script> -->