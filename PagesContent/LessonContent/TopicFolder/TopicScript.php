
<script>
    $(document).ready(function() {
        $("#userInputTopic").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("tbody tr").filter(function() {
                var rowText = $(this).text().toLowerCase();
                var pText = $(this).find("p").text().toLowerCase();
                $(this).toggle(rowText.indexOf(value) > -1 || pText.indexOf(value) > -1);
            });
        });
    });
    </script>

<!-- Script for pulling and viewing content-->
<!-- <script>
    $(function(){
        var arrays = []; // Array to store arrays received from the backend
        var currentArrayIndex = 0; // Index of the currently displayed array
        var currentIndex = 0; // Index of the currently displayed item
        var pageSize = 6; // Number of items to show per page

        // Function to load data from the backend using AJAX
        function loadData() {
            $.ajax({
                url: '../PagesContent/LessonContent/ActionLesson/ActionLessonView.php', // Replace with the actual backend URL
                method: 'POST',
                dataType: 'json',
                success: function(data) {
                    // Assume the backend returns data as an array of arrays
                    arrays = data;
                    loadPage(currentIndex);
                },
                error: function() {
                    console.error('Failed to load data.');
                }
            });
        }

        // Function to load a page
        function loadPage(index) {
            var currentArray = arrays[currentArrayIndex];
            if (index >= 0 && index < currentArray.length) {
                var filePath = currentArray[index];
                var fileExtension = filePath.split('.').pop().toLowerCase();
                var content = '';

                if (fileExtension === 'jpg' || fileExtension === 'jpeg' || fileExtension === 'png' || fileExtension === 'gif') {
                    content = '<div class="media"><img src="' + filePath + '" alt="Image"></div>';
                } else if (fileExtension === 'mp4' || fileExtension === 'webm' || fileExtension === 'ogg') {
                    content = '<div class="media"><video controls><source src="' + filePath + '" type="video/' + fileExtension + '">Your browser does not support the video tag.</video></div>';
                } else if (fileExtension === 'mp3' || fileExtension === 'wav' || fileExtension === 'ogg') {
                    content = '<div class="media"><audio controls><source src="' + filePath + '" type="audio/' + fileExtension + '">Your browser does not support the audio tag.</audio></div>';
                } else if (fileExtension === 'pdf') {
                    content = '<div class="media"><iframe src="' + filePath + '" width="100%" height="500px"></iframe></div>';
                } else {
                    // Handle other file types or provide a default message for unknown types
                    content = '<div class="media"><p>Unsupported file type: ' + fileExtension + '</p></div>';
                }

            $('#gallery').html(content);
            }
        }
        // Initial load
        loadData();

        // Handle next and previous clicks
        $('#next').on('click', function() {
            var currentArray = arrays[currentArrayIndex];
            if (currentIndex < currentArray.length - 1) {
                currentIndex++;
                loadPage(currentIndex);
            } else if (currentArrayIndex < arrays.length - 1) {
                // Switch to the next array if available
                currentArrayIndex++;
                currentIndex = 0;
                loadPage(currentIndex);
            }
        });

        $('#prev').on('click', function() {
            if (currentIndex > 0) {
                currentIndex--;
                loadPage(currentIndex);
            } else if (currentArrayIndex > 0) {
                // Switch to the previous array if available
                currentArrayIndex--;
                currentIndex = arrays[currentArrayIndex].length - 1;
                loadPage(currentIndex);
            }
        });

    });
</script> -->