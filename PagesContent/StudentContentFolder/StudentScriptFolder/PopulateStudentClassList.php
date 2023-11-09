<script>
$(function() {
    $.ajax({
        url: 'your_api_endpoint_here', // Replace with your actual API endpoint
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // Assuming the data is an array of class names
            // You can modify this based on your API response structure
            data.forEach(function(className) {
                // Append a new li element with the class name
                $('#classListDropdown').append('<li><a href="class_page.php?class=' +
                    className + '">' + className + '</a></li>');
            });
        },
        error: function(error) {
            console.error('Error fetching class list:', error);
        }
    });
});
</script>