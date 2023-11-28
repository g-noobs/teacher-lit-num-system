<div class="row">
    <div class="col-xs-12">
        <div class="box box-default container">
            <div class="box-header with-">
                <h3 class="box-title"></h3>
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
                <button class="btn btn-success" id='export_btn'>EXPORT DATA</button>
                <br>
                <br>
                <!-- Table Data -->
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Quiz ID</th>
                                <th>Quiz Name</th>
                                <th>Score</th>
                                <th>Date Taken</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                        
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
