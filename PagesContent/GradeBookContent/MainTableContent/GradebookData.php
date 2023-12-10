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

#filterModal {
    display: none;
    position: fixed;
    z-index: 2;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    padding: 20px;
    background-color: white;
    border: 1px solid #ddd;
}

#filterModal label {
    display: block;
    margin-bottom: 8px;
}
</style>

<div class="row" id="gradebook_content">
    <div class="col-xs-12">
        <div class="box box-default container">
            <br>
            <div class="box-header with-">

                <h3 class="box-title"></h3>

                <button class="btn btn-success" id='export_btn'>EXPORT DATA</button>
                <button type="button" class="btn btn-primary" onclick="openFilterModal()">Filter</button>

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
                                <th class="userInfoID">User Info ID</th>
                                <th class="personalID">Personal ID</th>
                                <th class="firstName" onclick="sortTableByFirstName()">First Name</th>
                                <th class="lastName" onclick="sortTableByLastName()">Last Name</th>
                                <th class="gender" onclick="sortTableByGender()">Gender</th>
                                <th class="classSection" onclick="sortTableByClass()">Class Section</th>
                                <th class="topicsTaken">Topics Taken</th>
                                <th class="quizTaken">Quiz Taken</th>
                                <th class="learnerProgress">Learner Story Progress</th>
                                <th class="quizProgress">Quiz Progress</th>
                                <th class="assignmentProgress">Assignment Progress</th>

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

<!-- //modal for filtering -->
<div id="filterModal">
    <label><input type="checkbox" class="chkUserInfoID"> User Info ID</label>
    <label><input type="checkbox" class="chkPersonalID"> Personal ID</label>
    <label><input type="checkbox" class="chkFirstName"> First Name</label>
    <label><input type="checkbox" class="chkLastName"> Last Name</label>
    <label><input type="checkbox" class="chkGender"> Gender</label>
    <label><input type="checkbox" class="chkClassSection"> Class Section</label>
    <label><input type="checkbox" class="chkTopicsTaken"> Topics Taken</label>
    <label><input type="checkbox" class="chkQuizTaken"> Quiz Taken</label>
    <label><input type="checkbox" class="chkLearnerProgress"> Learner Story Progress</label>
    <label><input type="checkbox" class="chkQuizProgress"> Quiz Progress</label>

    <button onclick="applyFilter()">Apply</button>
    <button onclick="resetTable()">Reset</button>
    <button onclick="closeFilterModal()">Close</button>
</div>

<!-- <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
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
</script> -->

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
    sortTableByColumn(0);
}

function sortTableByLastName() {
    sortTableByColumn(1);
}

function sortTableByGender() {
    sortTableByColumn(2);
}

function sortTableByClass() {
    sortTableByColumn(3);
}

function sortTableByClass() {
    sortTableByColumn(4);
}

function sortTableByClass() {
    sortTableByColumn(5);
}

function showQuizProgress(userId) {
    window.location.href = "get_quiz_progress.php?userId=" + userId;
}

function showProgress(userId) {
    window.location.href = "get_story_progress.php?userId=" + userId;
}

function showAssignmentProgress(userId) {
    window.location.href = "get_assignment_progress.php?userId=" + userId;
}

// filter sa gender ni siya na function    
function filterTable() {
    var table = document.getElementById("userTable");
    var filter = document.getElementById("genderFilter").value;
    var rows = Array.from(table.rows).slice(1);

    rows.forEach(function(row) {
        var genderCell = row.cells[2].innerText;

        if (filter === 'all' || genderCell === filter) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}


// filter sa Class Section ni siya na function    
function filterTable() {
    var table = document.getElementById("userTable");
    var genderFilter = document.getElementById("genderFilter").value;
    var classFilter = document.getElementById("classFilter").value;
    var rows = Array.from(table.rows).slice(1);

    rows.forEach(function(row) {
        var genderCell = row.cells[2].innerText;
        var classCell = row.cells[3].innerText;

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