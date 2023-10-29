<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title" id="teacher_name_dashboard">
            Edit Teacher Data Here!
        </h3>
        <div class="row" style="margin-left:20px;"><a href='#' id="edit-icon"><span
                    class='glyphicon glyphicon-edit'></span></a></div>
    </div>
    <div class="box-body" id="content_body">
        <div class="row">
            <form action="post" id="teacher_profile">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="teacher_last_name">Last Name</label>
                        <input type="text" name="teacher_first_name" class="form-control" placeholder="Fist Name"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="teacher_first_name">First Name</label>
                        <input type="text" name="teacher_first_name" class="form-control" placeholder="Fist Name"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="teacher_middle_initial">Middle Initial <span><small>*optional</small></span></label>
                        <select name="teacher_middle_initial" id="teacher_middle_initial" class="form-control">
                            <option value="">-</option>
                        </select>
                    </div>
                    <div class="form-group">

                    </div>
                </div>

                <div class="col-md-6"></div>
            </form>
        </div>
        <div class="row">
            <button class="btn btn-primary" id="update-btn" type="submit">Update Profile</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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