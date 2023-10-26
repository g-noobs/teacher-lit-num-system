
<div class="row">
    <div class="box container">
        <div class="box-header">
            <h2>Lesson <b>List</b></h2>
            <br>
            <div class="row">
                <div class="col-xs-6">
                    <button type="button" class="btn btn-warning btn-sm" data-toggle='modal' data-target="#addLessonModal">
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
            <table id="example2" class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <?php include_once "LessonTableHeader.php";?>
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
        <!-- /.box-body -->
    </div>
    <!-- /.box -->


</div>