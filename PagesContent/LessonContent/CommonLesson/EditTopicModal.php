<div class="modal fade" id="edit_topic_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Edit Topic</h4>
            </div>
            <!-- alert that will show if error occurs -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-danger alert-dismissible" id="add_user_modal_alert" role="alert"
                        style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <span id="add_user_modal_alert_text"></span>
                    </div>
                </div>
            </div>
            <!-- alert that would show when error occurs -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-danger alert-dismissible" id="add_user_modal_alert" role="alert"
                        style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <span id="add_user_modal_alert_text"></span>
                    </div>
                </div>
            </div>
            <form id="edit_topic_modal" action="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_topic_name" class="control-label">Topic Name:</label>
                        <input type="text" name="edit_topic_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_topic_description"class="control-label">Topic Description:</label>
                        <textarea name="edit_topic_description" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class='form-group'>
                        <button id="submit" type="submit" class="btn btn-primary pull-left">Submit</button>
                        <button id="reset-cancel" type="reset" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal ADD User -->