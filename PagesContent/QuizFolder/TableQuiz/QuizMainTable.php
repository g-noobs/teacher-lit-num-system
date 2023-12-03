<div class="row">
    <div class="col-xs-12">
        <div class="box box-default container">
            <br>
            <div class="box-header with-border">
                <button id="add_qzui_btn" type="button" class="btn btn-primary" data-toggle="tooltip" title="Add New Quiz">
                    <i class="glyphicon glyphicon-plus"></i><span>Add new QUIZ</span></button>
                </button>
                <button id="archive_btn" type="button" class="btn btn-danger" data-toggle="tooltip"
                    title="Archive Quiz">
                    <i class="glyphicon glyphicon-trash"></i><span></span>
                </button>
                <div class="box-tools pull-right">
                    <div class="search-box" style="margin-right: 35px;">
                        <i class="fa fa-search"></i>
                        <input type="text" id="userInput" class="form-control" placeholder="Search..">
                    </div>
                </div>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <br>
            <!-- /.box-header -->
            <div class="box-body" style="overflow-y: scroll; max-height: 400px;">
                <div class="table-responsive">
                    <table id="example2" class="table table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th colspan=2><input type='checkbox' id="select-all" class='checkbox'></th>
                                <th>Quiz ID</th>
                                <th>Question</th>
                                <th>Date Created</th>
                                <th>Topic ID</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                        include_once("../Database/QuizDisplayClass.php");
                        $teacher_id = $_SESSION['id'];
                        $quiztable = new QuizDisplayClass();
                        $quiztable->displayQuestions($teacher_id);
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>