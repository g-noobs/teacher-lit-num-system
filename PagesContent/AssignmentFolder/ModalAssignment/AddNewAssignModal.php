<div class="modal fade" id="add_assign_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Edit Quiz</h4>
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
        <form id="addAssignForm" action="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="topic_id">Topic Source</label>
                                <select name="topic_id" id="topic_id_option" class="form-control">
                                    <?php include_once "../Database/QuizDisplayClass.php";
                                        $teacher_id = $_SESSION['id'];
                                        $optionTopic = new QuizDisplayClass();
                                        $optionTopic->displayTopicOption($teacher_id);
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="assignment_name" class="control-label">Assignment Name or Data:</label>
                                <input name="assignment_name" id="assignment_name"
                                    class="form-control" required></input>
                            </div>
                            <div class="form-group">
                                <label for="assign_question" class="control-label">Question:</label>
                                <textarea name="assign_question" id="assign_question" cols="60" rows="5"
                                    class="form-control" style="resize: vertical;" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="max_score" class="control-label">Max Score:</label>
                                <input num="max_score" id="max_score"
                                    class="form-control" required></input>
                            </div>
                        </div>
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