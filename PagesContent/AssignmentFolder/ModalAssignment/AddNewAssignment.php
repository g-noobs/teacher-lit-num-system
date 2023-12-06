<div class="modal fade" id="add_assignment_modal">
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
            <form id="addQuizForm" action="post">
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
                                <label for="quiz_type_option">Type of Quiz</label>
                                <select name="quiz_type_option" id="quiz_type_option" class="form-control" requried>
                                    <option value="0">Multiple Choice</option>
                                    <option value="1">True or False</option>
                                    <option value="2">Essay</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="quiz_question" class="control-label">Question:</label>
                                <textarea name="quiz_question" id="quiz_question" cols="60" rows="5"
                                    class="form-control" style="resize: vertical;" required></textarea>
                            </div>
                        </div>
                        <div class="col-xs-6" id="answer_col_right">
                            <div class="form-group">
                                <label for="quiz_answer">Set the Correct Answer</label>
                                <select name="quiz_answer" id="quiz_answer">
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                                <small>*Choose the correct answer based on the option provided</small>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="option1">Option 1</label>
                                        <input type="text" name="option1" class='form-control' required>
                                    </div>
                                    <div class="form-group">
                                        <label for="option2">Option 2</label>
                                        <input type="text" name="option2" class='form-control' required>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="option3">Option 3</label>
                                        <input type="text" name="option3" class='form-control' required>
                                    </div>

                                    <div class="form-group">
                                        <label for="option4">Option 4</label>
                                        <input type="text" name="option4" class='form-control' required>
                                    </div>
                                </div>
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