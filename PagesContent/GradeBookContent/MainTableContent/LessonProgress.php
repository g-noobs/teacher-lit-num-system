<div class="row" id="lesson_progress_content" display="none">
    <div class="col-xs-12">
        <div class="box box-default container">
            <br>
            <div class="box-header with-">

                <h3 class="box-title"> Learner Story Progress for: <span id="user_name"></span></h3>
                <h4 id="personal_id_lesson"></h4>

                <div class="form-group-row">
                    <div class="col-xs-2">
                        <select id='filterSelect' class="form-control">
                            <option value='all'>All</option>
                            <option value='completed'>Completed</option>
                            <option value='not_completed'>Not Completed</option>
                        </select>
                    </div>
                </div>
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
            <!-- /.box-header -->
            <div class="box-body" style="overflow-y: scroll; max-height: 400px;">
                <!-- export button -->
                <!-- Table Data -->
                <div class="table-responsive">
                    <table id="progressTable" class="table table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th>Topic ID</th>
                                <th>Topic Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <p><button type="button" class="btn btn-default" onclick="goBack()">Back</button></p>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>

