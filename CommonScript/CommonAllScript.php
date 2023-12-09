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

<!-- Jquery for Table Search -->
<script>
$(document).ready(function() {
    $(document).on("keyup","#userInput", function() {
        var value = $(this).val().toLowerCase();
        $("tbody tr").filter(function() {
            var rowText = $(this).text().toLowerCase();
            var pText = $(this).find("p").text().toLowerCase();
            $(this).toggle(rowText.indexOf(value) > -1 || pText.indexOf(value) > -1);
        });
    });
});
</script>