<!-- dropdown config -->
<script>
$(function() {
    $('.custom-dropdown-menu a').click(function(e) {
        e.preventDefault();
        var lessonType = $(this).data('lesson-type');
        var contentPath = '';

        if (lessonType === 'active-lesson') {
            location.reload();
        } else if (lessonType === 'archive-lesson') {
            contentPath = '../PagesContent/LessonContent/TableFolder/ArchiveLessonTable.php';
        }
        $('.custom-dropdown-toggle').html($(this).text() + '<span class="caret"></span>');
        if (contentPath !== '') {
            $("#lesson-table").fadeOut(400, function() {
                $(this).load(contentPath, function() {
                    $(this).fadeIn(400);
                });
            });
        }
    });
});
</script>
<!--Script below will be used for search -->
<script>
$(document).ready(function() {
    $("#userInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("tbody tr").filter(function() {
            var rowText = $(this).text().toLowerCase();
            var pText = $(this).find("p").text().toLowerCase();
            $(this).toggle(rowText.indexOf(value) > -1 || pText.indexOf(value) > -1);
        });
    });
});
</script>

<script>
$(function() {
    $(".viewBtn").click(function() {
        var buttonId = $(this).data("id");
        var lessonName = $(this).closest('tr').find('td:eq(2)').text();
        var url = "../PagesContent/LessonContent/ViewLessonFolder/LessonView.php?id=" + buttonId +
            "&name=" + lessonName;
        //open lessonview.php in a new window with size
        window.open(url, "_blank", "width=1000,height=700");

        //get the lesson name from the url
        var lessonid = buttonId;
        var lessonNameL = window.location.href.split("=")[2];
        //replace the %20 with one space
        var lessonNameL = lessonNameL.replace(/%20/g, " ");

        $("#test").text(lessonid);
        $("#lesson_name").text(lessonNameL);

        var responseData = {}; // To store the response from the backend
        var topics = []; // To store the topic keys
        var currentTopicIndex = 0; // Index of the currently displayed topic

        // Function to load data from the backend using AJAX
        function loadData() {
            $.ajax({
                url: '../ActionLesson/ActionLessonView.php', // Replace with the actual backend PHP script
                method: 'POST', // Change to POST if needed
                data: {
                    id: lessonid
                }, // Pass any required data to your PHP script
                dataType: 'json',
                success: function(response) {
                    responseData = response;
                    topics = Object.keys(response);
                    loadTopic(currentTopicIndex);
                    loadSidebar(topics);
                },
                error: function() {
                    console.error('Failed to load data.');
                }
            });
        }

        // Function to load a topic
        function loadTopic(index) {
            var currentTopic = topics[index];
            var mediaPaths = responseData[currentTopic];

            if (mediaPaths) {
                var content = '';

                mediaPaths.forEach(function(mediaPath) {
                    // Check if the mediaPath is a Google Drive link
                    if (mediaPath.includes("docs.googleusercontent.com")) {
                        // Handle Google Drive link
                        content += '<iframe src="' + mediaPath + '"></iframe>';
                    } else {
                        // Extract the file extension from the mediaPath
                        var fileType = mediaPath.split('.').pop().toLowerCase();

                        if (fileType === 'jpg' || fileType === 'jpeg' || fileType === 'png' ||
                            fileType ===
                            'gif') {
                            content += '<div class="media"><img src="' + mediaPath +
                                '" alt="Image"></div>';
                        } else if (fileType === 'mp3' || fileType === 'ogg' || fileType ===
                            'wav') {
                            content += '<audio controls><source src="' + mediaPath +
                                '" type="audio/' +
                                fileType +
                                '">Your browser does not support the audio element.</audio>';
                        } else if (fileType === 'mp4' || fileType === 'webm' || fileType ===
                            'ogg') {
                            content += '<video controls><source src="' + mediaPath +
                                '" type="video/' +
                                fileType +
                                '">Your browser does not support the video element.</video>';
                        } else if (fileType === 'pdf') {
                            content += '<embed src="' + mediaPath +
                                '" type="application/pdf" width="100%" height="500px" />';
                        } else if (fileType === 'doc' || fileType === 'docx') {
                            // Handle Word document
                            content += '<iframe src="https://docs.google.com/gview?url=' +
                                encodeURIComponent(mediaPath) +
                                '&embedded=true" width="100%" height="800px"></iframe>';
                        } else {
                            // Handle other file types or provide a default
                            content += '<iframe src="' + mediaPath +
                                '" width="100%" height="800px"></iframe>';
                        }
                    }
                });

                $('#gallery').html(content);
            }
        }



        // Function to load sidebar menu with topic links
        function loadSidebar(topics) {
            var sidebarContent = '';

            topics.forEach(function(topic, index) {
                // Add the label for the topic within the <a> element
                sidebarContent += '<li><a href="#" class="topic-link" data-index="' + index +
                    '"><i class="fa fa-book"></i><span>' + topic + '</span></a></li>';
            });

            $('#side-menu').html(sidebarContent);

            // Attach click event to topic links
            $('.topic-link').on('click', function() {
                var index = $(this).data('index');
                loadTopic(index);
            });
        }

        // Initial load
        loadData();

        // Handle next and previous topic clicks
        $('#next').on('click', function() {
            if (currentTopicIndex < topics.length - 1) {
                currentTopicIndex++;
                loadTopic(currentTopicIndex);
            }
        });

        $('#prev').on('click', function() {
            if (currentTopicIndex > 0) {
                currentTopicIndex--;
                loadTopic(currentTopicIndex);
            }
        });
    });
});
</script>