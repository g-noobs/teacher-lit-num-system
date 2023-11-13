<div class="modal fade" id="addLessonModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Enter Lesson Information</h4>
            </div>
            <form id="addLessonForm">
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="lesson_name">Lesson Name</label>
                            <input type="text" name="lesson_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="category_level">Select a level of Category</label>
                            <select class="form-control" name="category_level">
                                <?php include_once("../Database/LessonDisplayClass.php");
                                    $categoryList = new LessonDisplayClass();
                                    $categoryList->displayCategoryList();
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subj_list">Select Subject</label>
                            <select class="form-control" name="subj_list">
                                <?php include_once("../Database/LessonDisplayClass.php");
                                    $subjList = new LessonDisplayClass();
                                    $subjList->displaySubjectlist();
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning pull-left">Add Lesson</button>
                        <button type="reset" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>