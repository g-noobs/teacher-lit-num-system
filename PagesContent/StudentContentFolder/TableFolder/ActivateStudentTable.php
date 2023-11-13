<div class="box box-default">
    <div class="box-header with-border">
        <br>
        <div class="row">
            <div class="col-xs-6">
                <button type="button" class="btn btn-warning">
                    <i class="fa fa-plus"></i> <span>Add Student</span>
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
    <div class="box-body container-fluid" style="overflow-y: scroll; max-height: 400px;">
        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th><input type='checkbox' id="select-all" class='checkbox'></th>
                    <th colspan='2'></th>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Acount Status</th>
                </tr>
            </thead>
            <tbody>
                <?php include_once("../Database/DisplayStudentClass.php");
                    $displayActiveStudent = new DisplayStudentClass();
                    $displayActiveStudent->ActiveStudentList();
                ?>
            </tbody>
        </table>
    </div>
</div>