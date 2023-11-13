<style>
a {
    color: none;
    /* This makes links inherit their color from their parent elements */
    text-decoration: none;
    /* This removes the underline */
}
</style>

<form id="addTopic" enctype="multipart/form-data">
    <div class="box box-warning container">
        <!--! This is the box header -->
        <div class="box-header with-border">
            <a href="#" type="button" id="back-table"><i class="glyphicon glyphicon-chevron-left"></i></a>
            <h4 class="box-title" id="topic-name" style="margin-left: 15px;"> Add a new topic for lesson:</h4>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>

        <!-- !This is the box body  -->
        <div class="box-body">
            
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="topic_name" class="control-label">Topic:</label>
                        <input type="text" name="topic_name" id="topic_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="topic_desc" class="control-label">Description:</label>
                        <textarea name="topic_desc" id="topic_desc" cols="60" rows="5" class="form-control"
                            style="resize: vertical;" required></textarea>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="file">Add Materials:</label>
                    <div class="row" id="addFileContainer">
                        <div class="form-group">
                            <div class="input-group-container">
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <label for="sel1" class="input-group-addon">Select Media:</label>
                                        <select class="form-control" id="select_file_type">
                                            <option>Image</option>
                                            <option>Video</option>
                                            <option>Audio</option>
                                            <option>Document</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="file" name="file[]" multiple>
                                        <span class="input-group-btn">
                                            <a href="#" class="btn text-danger cancelFile" data-toggle="tooltip"
                                                title="Cancel"><i class="fa fa-remove"></i></a></a>
                                        </span>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="#" id="addMedia" type="button" data-toggle="tooltip" title="Add More Media"
                        class="text-success"><i class="fa fa-plus"></i></a>
            </div>
        </div>
        <div class="box-footer">
            <button id="submit" class="btn btn-warning">Submit</button>
            <button id="reset-cancel" type="reset" class="btn btn-default">Cancel</button>
        </div>
    </div>
</form>

<div id="topic-table">
    <?php include_once "../PagesContent/LessonContent/TopicFolder/TopicTable.php"?>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('#file').change(function() {
        // Get the selected option value
        var selectedOption = $('#select_file_type').val();
        
        // Clear any previous error messages
        $('.error-message').remove();
        
        // If the selected option is "Video" and the file type is not video
        if (selectedOption === 'Video' && !isFileTypeValid('video', $('#file')[0].files)) {
            $('#addFileContainer').after('<div class="error-message text-danger">Invalid file type for Video</div>');
            $('#file').val(''); // Clear the file input
        } else if (selectedOption === 'Audio' && !isFileTypeValid('audio', $('#file')[0].files)) {
            $('#addFileContainer').after('<div class="error-message text-danger">Invalid file type for Audio</div>');
            $('#file').val(''); // Clear the file input
        } else if (selectedOption === 'Image' && !isFileTypeValid('image', $('#file')[0].files)) {
            $('#addFileContainer').after('<div class="error-message text-danger">Invalid file type for Image</div>');
            $('#file').val(''); // Clear the file input
        } else if (selectedOption === 'Document' && !isFileTypeValid('document', $('#file')[0].files)) {
            $('#addFileContainer').after('<div class="error-message text-danger">Invalid file type for Pdf</div>');
            $('#file').val(''); // Clear the file input
        }
    });
    
    // Function to check if the selected files have the correct extension for the given media type
    function isFileTypeValid(mediaType, files) {
        var allowedExtensions = [];
        
        // Define the allowed file extensions for each media type
        if (mediaType === 'video') {
            allowedExtensions = ['mp4', 'mov', 'avi'];
        } else if (mediaType === 'audio') {
            allowedExtensions = ['mp3', 'wav', 'ogg'];
        } else if (mediaType === 'image') {
            allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        } else if (mediaType === 'document') {
            allowedExtensions = ['pdf', 'doc', 'docx'];
        }
        
        for (var i = 0; i < files.length; i++) {
            var fileExtension = files[i].name.split('.').pop().toLowerCase();
            if (allowedExtensions.indexOf(fileExtension) === -1) {
                return false;
            }
        }
        
        return true;
    }
});
</script>
