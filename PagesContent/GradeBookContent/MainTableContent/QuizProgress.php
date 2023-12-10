<div class="row" id="quiz_progress_content">
    <div class="col-xs-12">
        <div class="box box-default container">
            <br>
            <div class="box-header with-">

                <h3 class="box-title">Quiz Progress for: </h3>
                <h4 id="personal_id_quiz"></h4>
                <div class="form-group-row">
                    <div class="col-xs-2">
                        <select id='quizFilterSelect' class="form-control" onchange='applyQuizFilter()'>
                            <option value='all'>All</option>
                            <option value='taken'>Taken</option>
                            <option value='not_taken'>Not Taken</option>
                        </select>
                    </div>
                </div>
                <div class="box-tools pull-right">
                    <div class="search-box" style="margin-right: 35px;">
                        <i class="fa fa-search"></i>
                        <input type="text" id="userInpute" class="form-control" placeholder="Search..">
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
                    <table id="quizProgressTable" class="table table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th>Quiz ID</th>
                                <th>Quiz Question</th>
                                <th>Quiz Score</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
            <p><button onclick="goBack()">Go Back</button></p>
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>

<script>
function applyQuizFilter() {
    var filter = document.getElementById('quizFilterSelect').value;
    var rows = document.getElementsByClassName('quizProgressRow');

    for (var i = 0; i < rows.length; i++) {
        var score = rows[i].getAttribute('data-score');

        if (filter === 'all' || (filter === 'taken' && score !== 'Not Taken') || (filter === 'not_taken' && score ===
                'Not Taken')) {
            rows[i].style.display = 'table-row';
        } else {
            rows[i].style.display = 'none';
        }
    }
}

function goBack() {
    location.reload();
}
</script>