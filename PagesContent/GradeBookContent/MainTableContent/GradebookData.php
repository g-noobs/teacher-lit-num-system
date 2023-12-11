<style>
table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
}

table,
th,
td {
    border: 1px solid #F4F4F4;
}

th,
td {
    padding: 10px;
    text-align: left;
}

#progressTableContainer,
#quizTableContainer {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1;
    background-color: white;
    display: none;
}

#backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: none;
}
</style>

<div class="row" id="gradebook_content">
    <div class="col-xs-12">
        <div class="box box-default">
            <br>
            <div class="box-header with-">

                <h3 class="box-title"></h3>
                <form class="form-inline">
                    <div class="form-group">
                        <!-- Mao ni siya ang dropdown selection for class section-->
                        <label for="classFilter">Filter by Class:</label>
                        <select id="classFilter" onchange="filterTableClass()" class="form-control">
                            <option value="all">All</option>
                            <?php
                                    include_once "../Database/Connection.php";
                                    $conn = new Connection();
                                    $connection = $conn->getConnection();
                                    $teacher_id = $_SESSION['id'];
                                    $table = 'view_teacher_class_info';
                                    $classQuery = "SELECT class_name FROM $table
                                    WHERE user_info_id = '$teacher_id' 
                                    AND class_assign_status = 1 
                                    AND class_status = 1 
                                    AND class_id IN (
                                        SELECT class_id
                                        FROM tbl_teacher_class_assignment
                                        WHERE status = 1
                                        );";
                                    $classResult = mysqli_query($connection, $classQuery);
                                    while ($classRow = mysqli_fetch_assoc($classResult)) { 
                                        $className = $classRow['class_name'];
                                        echo "<option value='$className'>$className</option>";
                                    }
                                ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="genderFilter">Filter by Gender:</label>
                        <select id="genderFilter" class="form-control" onchange="filterTableGender()">
                            <option value="all">All</option>
                            <option value="MALE">Male</option>
                            <option value="FEMALE">Female</option>
                        </select>
                    </div>
                </form>

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
                    <table id="userTable" class="table table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th class="personalID">Personal ID</th>
                                <th class="firstName" onclick="sortTableByFirstName()">First Name</th>
                                <th class="lastName" onclick="sortTableByLastName()">Last Name</th>
                                <th class="gender" onclick="sortTableByGender()">Gender</th>
                                <th class="classSection" onclick="sortTableByClass()">Class Section</th>
                                <th class="topicsTaken" onclick="sortTableByClass()"> Topics Taken</th>
                                <th class="quizTaken" onclick="sortTableByClass()">Quiz Taken</th>
                                <th class="assignmentTaken" onclick="sortTableByClass()">Assignment Taken</th>
                                <th class="learnerProgress">Lesson Progress</th>
                                <th class="quizProgress">Quiz Progress</th>
                                <th class="assignmentProgress">Assignment Progress</th>
                                <th>Admit For Intervention</th>
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


<script>
var sortDirections = {};

function sortTableByColumn(columnIndex) {
    var table = document.getElementById("userTable");
    var rows = Array.from(table.rows).slice(1);

    rows.sort(function(a, b) {
        var cellA = a.cells[columnIndex].innerText.toLowerCase();
        var cellB = b.cells[columnIndex].innerText.toLowerCase();

        if (cellA < cellB) {
            return -1;
        } else if (cellA > cellB) {
            return 1;
        } else {
            return 0;
        }
    });

    if (!sortDirections[columnIndex] || sortDirections[columnIndex] === 1) {
        rows.reverse();
        sortDirections[columnIndex] = -1;
    } else {
        sortDirections[columnIndex] = 1;
    }

    table.innerHTML = table.rows[0].outerHTML;

    rows.forEach(function(row) {
        table.appendChild(row);
    });
}

function sortTableByFirstName() {
    sortTableByColumn(1);
}

function sortTableByLastName() {
    sortTableByColumn(2);
}

function sortTableByGender() {
    sortTableByColumn(3);
}

function sortTableByClass() {
    sortTableByColumn(4);
}

function sortTableByClass() {
    sortTableByColumn(5);
}

function sortTableByClass() {
    sortTableByColumn(6);
}

function showQuizProgress(userId) {
    window.location.href = "get_quiz_progress.php?userId=" + userId;
}

function showProgress(userId) {
    window.location.href = "get_story_progress.php?userId=" + userId;
}

function showAssignmentProgress(userId) {
    window.location.href = "get_assignment_progress.php?userId=" +
        userId;
}

// filter sa gender ni siya na function    
function filterTableGender() {
    var table = document.getElementById("userTable");
    var filter = document.getElementById("genderFilter").value;
    var rows = Array.from(table.rows).slice(1);

    rows.forEach(function(row) {
        var genderCell = row.cells[3].innerText;

        if (filter === 'all' || genderCell === filter) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}


// filter sa Class Section ni siya na function    
function filterTableClass() {
    var table = document.getElementById("userTable");
    var genderFilter = document.getElementById("genderFilter").value;
    var classFilter = document.getElementById("classFilter").value;
    var rows = Array.from(table.rows).slice(1);

    rows.forEach(function(row) {
        var genderCell = row.cells[3].innerText;
        var classCell = row.cells[4].innerText;

        var genderMatch = (genderFilter === 'all' || genderCell === genderFilter);
        var classMatch = (classFilter === 'all' || classCell === classFilter);

        if (genderMatch && classMatch) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>

<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
<script>
$(document).ready(function() {
    $(document).on('click', '#export_btn', function() {
        let table = document.getElementsByTagName("table");
        var fileName = 'gradebook';
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