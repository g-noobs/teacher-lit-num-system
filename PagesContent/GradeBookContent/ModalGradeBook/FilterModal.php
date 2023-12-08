<div class="modal fade" id="filterModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modal-title">Filter Table View</h4>
            </div>
            <div class="modal-body">
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
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal ADD User -->