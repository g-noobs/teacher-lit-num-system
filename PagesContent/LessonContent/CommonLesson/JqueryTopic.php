<!-- script that will manage the form submit-->
<!-- will be using jquery and ajax-->


<!-- script for getting id and name from the lesson table and transfer to script-->
<script>
//? Event for addbtn to topic panels
$(function() {
    var btnId;
    $(".addBtn").on("click", function() {
        $("#add-topic-panel").show();
        var lessonName = $(this).closest('tr').find('td:eq(2)').text();
        btnId = $(this).data("id");
        console.log(btnId);

        $("#lesson-table").hide();
        $('#lesson_status_dropdown').hide();
        $("#topic-name").html("Add a new topic for lesson: <strong>" + lessonName + "</strong>");

        $.ajax({
            url: "../PagesContent/LessonContent/TopicFolder/PopulateTableData.php",
            type: "POST",
            data: {
                id: btnId
            },
            success: function(response) {
                $("#table-topic tbody").append(response);
            }
        });
    });

    //Event handler for the form submit -- addTopic
    $("#addTopic").on("submit", function(e) {
        $("errorBanner").hide();
        e.preventDefault();
        //Create a FormData object
        var formData = new FormData(this);
        // Append the btnId to the formData
        formData.append("btnId", btnId);
        $.ajax({
            url: "../PagesContent/LessonContent/ActionLesson/AddTopic.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(response) {
                if (Array.isArray(response)) {
                    // Clear previous error messages
                    $("#add_user_modal_alert_text").empty();
                    $("#add_user_modal_alert").show();

                    // Update the element with the received errors
                    $.each(response, function(index, error) {
                        $("#add_user_modal_alert_text").append("<p class='error'>" +
                            error +
                            "</p><br>");
                        console.log(error);
                    });

                    setTimeout(function() {
                        $("#add_user_modal_alert").fadeOut("slow");

                    }, 8500);
                } else {
                    if (response.hasOwnProperty('success')) {
                        $('#successAlert').text(response.success);
                        $('#successBanner').show();
                        setTimeout(function() {
                            $("#successBanner").fadeOut("slow");
                            // location.reload();
                        }, 1500);


                        // You can redirect to a different page or perform other actions here
                    } else if (response.hasOwnProperty('error')) {
                        $('#errorAlert').text(response.error);
                        $('#errorBanner').show();
                        setTimeout(function() {
                            $("#errorBanner").fadeOut("slow");
                            // location.reload();
                        }, 1500);
                    }
                }
            }
        });
    });


});
</script>

<script>
//HIDE topic pane BY default
$("#add-topic-panel").hide();
$("#back-table").click(function() {
    $("#add-topic-panel").hide();
    $("#lesson-table").show();

    window.location.href = "lesson.php";
});

$("#reset-cancel").on("click", function() {
    $("#add-topic-panel").hide();
    $("#lesson-table").show();
    //will go back to lesson.php
    window.location.href = "lesson.php";
});
</script>

<script>
$(document).ready(function() {
    // Function to add another input group when #addMedia is clicked
    var $addFileContainer = $("#addFileContainer");
    var $firstFormGroup = $($addFileContainer).find(".form-group:first");
    $("#addMedia").click(function() {

        // if formGroupCount is 5, disable the addMedia button
        var formGroupCount = $(".col-sm-6 .row .form-group").length;
        if (formGroupCount == 5) {
            $(this).prop('disabled', true);
        } else {
            // Append the new input group to the container
            $($addFileContainer).append($firstFormGroup.clone());
        }


    });

    // Function to remove an input group when its "href" link is clicked
    $(document).on("click", ".cancelFile", function() {
        // Count the number of form-groups in addFileContainer
        var formGroupCount = $(".col-sm-6 .row .form-group").length;

        // Check if there's only one input group -> do not allow to remove form group
        if (formGroupCount === 1) {
            // If there's only one input group, hide or disable the cancelFile class as per your requirement
            $(this).closest('.form-group').find('.cancelFile').addClass('disable')

        } else {
            // If there are more than one input groups, remove the current input group
            $(this).closest('.form-group').remove();
        }

    });
});
</script>