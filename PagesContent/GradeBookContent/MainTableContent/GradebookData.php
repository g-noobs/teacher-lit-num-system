<div class="row">
    <div class="col-xs-12">
        <div class="box box-default container">
            <br>
            <div class="box-header with-">

                <h3 class="box-title"></h3>

                <button class="btn btn-success" id='export_btn'>EXPORT DATA</button>
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
                    <table id="dataTable" class="table table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Number of Quiz Taken</th>
                                <th>Total Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php include_once "../Database/DisplayGradebook.php";
                                $displayGrade = new DisplayGradebook();
                                $displayGrade->gradebookData();
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

<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
<script>
$(document).ready(function() {
    $("#export_btn").click(function() {
        let table = document.getElementsByTagName("table");
        var fileName = $(this).data("gradebook");
        console.log(table);
        debugger;
        TableToExcel.convert(table[0], {
            name: fileName + `.xlsx`,
            sheet: {
                name: fileName
            }
        });
    });
});
</script>