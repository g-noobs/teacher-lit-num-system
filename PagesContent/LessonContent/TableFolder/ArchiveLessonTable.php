<div class="row">
    <div class="box container">
        <div class="box-header">
            <h2>Lesson <b>List</b></h2>
            <br>
            <div class="row">
                <div class="col-xs-6">
                    <button type="button" class="btn btn-warning btn-sm" data-toggle='modal'
                        data-target="#addLessonModal">
                        <i class="fa fa-plus"></i> <span> Add Lesson</span>
                    </button>
                </div>
                <div class="col-xs-6">
                    <div class="search-box">
                        <i class="fa fa-search"></i>
                        <input type="text" id="userInput" class="form-control" placeholder="Search..">
                    </div>
                </div>
            </div>

        </div>
        <!-- /.box-header -->
        <div class="box-body" style="overflow-y: scroll; max-height: 400px;">
            <div class="table-responsive">
                <table id="example2" class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th><input type='checkbox' id="select-all" class='checkbox'></th>
                            <th>Lesson ID</th>
                            <th>Lesson</th>
                            <th>Category Name</th>
                            <th>Module Name</th>
                            <th colspan="3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        include_once("../Database/LessonDisplayClass.php");
                        $userT = new LessonDisplayClass();
                        $userT->lessonTable();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->


</div>