<!-- For Logout button for Search -->
<script>
$(function() {
    $('#logoutBtn').on('click', function(e) {
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