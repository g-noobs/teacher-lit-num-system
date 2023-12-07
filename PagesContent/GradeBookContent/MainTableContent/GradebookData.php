<style>
table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
}

table,
th,
td {
    border: 1px solid black;
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

<?php
include_once("../Database/Connection.php");
$conn_obj  = new Connection();
$connection = $conn_obj->getConnection();

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Update tbl_learner_story_progress with topic IDs for each student
$topicsQuery = "
    UPDATE tbl_learner_story_progress lsp
    JOIN tbl_user_info ui ON lsp.learner_id = ui.user_info_id
    SET lsp.story_id = ui.class_id
    WHERE ui.user_level_id = 2
";

mysqli_query($connection, $topicsQuery);

// Update tbl_learner_story_progress with 'Not Taken Yet' for Date Completed
$notTakenYetQuery = "
    UPDATE tbl_learner_story_progress
    SET date_completed = 'Not Taken Yet'
    WHERE date_completed IS NULL OR date_completed = '0000-00-00'
";

mysqli_query($connection, $notTakenYetQuery);

// Query to fetch user information including class_id and class_name
$query = "
    SELECT 
        ui.user_info_id,
        ui.personal_id,
        ui.first_name,
        ui.last_name,
        ui.gender,
        ui.class_id,
        cls.class_name
    FROM 
        tbl_user_info ui
    LEFT JOIN
        tbl_class cls ON ui.class_id = cls.class_id
    WHERE 
        ui.user_level_id = 2
";

$result = mysqli_query($connection, $query);
?>

<button onclick="openFilterModal()">Filter</button>

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
                <button onclick="openFilterModal()">Filter</button>
                <!-- Table Data -->
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered table-hover text-center">
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

<script>
var sortDirectionGender = 0;
var sortDirectionClass = 0;
var sortDirectionFirstName = 0;
var sortDirectionLastName = 0;
var topicsTakenIndex = checkboxes.length;
var quizTakenIndex = checkboxes.length + 1;


function sortTableByFirstName() {
    sortTableByColumn(2, sortDirectionFirstName);
}

function sortTableByLastName() {
    sortTableByColumn(3, sortDirectionLastName);
}

function sortTableByColumn(columnIndex, currentDirection) {
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

    if (currentDirection === 0) {
        currentDirection = 1;
    } else {
        currentDirection = -currentDirection;
    }

    if (currentDirection === -1) {
        rows.reverse();
    }

    table.innerHTML = table.rows[0].outerHTML;

    rows.forEach(function(row) {
        table.appendChild(row);
    });

    if (columnIndex === 2) {
        sortDirectionFirstName = currentDirection;
    } else if (columnIndex === 3) {
        sortDirectionLastName = currentDirection;
    } else if (columnIndex === 4) {
        sortDirectionGender = currentDirection;
    } else if (columnIndex === 5) {
        sortDirectionClass = currentDirection;
    }
}

function sortTableByGender() {
    sortTableByColumn(4, sortDirectionGender);
}

function sortTableByClass() {
    sortTableByColumn(5, sortDirectionClass);
}

function showQuizProgress(userId) {
    window.location.href = "get_quiz_progress.php?userId=" + userId;
}

function showProgress(userId) {
    window.location.href = "get_progress.php?userId=" + userId;
}


function openFilterModal() {
    document.getElementById("filterModal").style.display = "block";
    document.getElementById("backdrop").style.display = "block";
}

function applyFilter() {
    var table = document.getElementById("userTable");
    var checkboxes = document.querySelectorAll("#filterModal input[type=checkbox]");

    checkboxes.forEach(function(checkbox, index) {
        var columnIndex = index;
        var headerCell = table.rows[0].cells[columnIndex];
        var className = headerCell.classList[0];
        var cells = document.querySelectorAll("#userTable ." + className);

        if (checkbox.checked) {
            cells.forEach(function(cell) {
                cell.style.display = "";
            });
        } else {
            cells.forEach(function(cell) {
                cell.style.display = "none";
            });
        }
    });

    closeFilterModal();
}

function resetTable() {
    var table = document.getElementById("userTable");

    for (var i = 0; i < table.rows[0].cells.length; i++) {
        table.rows[0].cells[i].style.display = "";
        var className = table.rows[0].cells[i].classList[0];
        var cells = document.querySelectorAll("#userTable ." + className);

        cells.forEach(function(cell) {
            cell.style.display = "";
        });
    }

    closeFilterModal();
}

function closeFilterModal() {
    document.getElementById("filterModal").style.display = "none";
    document.getElementById("backdrop").style.display = "none";
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