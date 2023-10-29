<script>
$(function() {
    // jQuery to populate the select element with uppercase letters of the alphabet
    var selectElement = $("#teacher_middle_initial");

    // Loop to add uppercase letters A to Z
    for (var i = 65; i <= 90; i++) {
        var letter = String.fromCharCode(i);
        selectElement.append($("<option>", {
            value: letter,
            text: letter
        }));
    }
});
</script>

<script>
$(document).ready(function() {
    var editMode = false; // Flag to track the edit mode status

    // Hide the update button initially
    $('#update-btn').hide();
    $('input, select').prop('readonly', true).prop('disabled', true);

    // Function to toggle the edit mode
    function toggleEditMode() {
        if (editMode) {
            // If edit mode is active, hide the update button and disable the inputs
            $('#update-btn').hide();
            $('input, select').prop('readonly', true).prop('disabled', true);
        } else {
            // If edit mode is inactive, show the update button and enable the inputs
            $('#update-btn').show();
            $('input, select').prop('readonly', false).prop('disabled', false);
        }
        editMode = !editMode; // Toggle the edit mode flag
    }

    // Enable input and show the update button when edit icon is clicked
    $('#edit-icon').click(function() {
        toggleEditMode();
    });

    // Hide the update button when the update button is clicked
    $('#update-btn').click(function() {
        $(this).hide();
    });
});
</script>