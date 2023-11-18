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
    });
});
</script>

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