<script>
$(function() {
    $(document).on('click', '.lesson_progress_btn', function(e) {
        e.preventDefault();
        var userId = $(this).data('id');
        // window.location.href = "get_progress.php?userId=" + userId;
        $.ajax({
            url: "../PagesContent/GradeBookContent/ActionGradebook/GetLessonProgress.php",
            method: "GET",
            data: {
                userId: userId
            },
            dataType: "json",
            success: function(response) {
                if(response.hasOwnProperty('succes')){
                    $('#progressTable tbody').append(response.success);
                }else{
                    $('#progressTable tbody').append(response.error);
                }

                //append table row to table body
                // $.each(data, function(index, rowData) {
                //     $('#progressTable tbody').append(rowData);
                // });
                //hide the main table
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
});
</script>


<script>
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
</script>