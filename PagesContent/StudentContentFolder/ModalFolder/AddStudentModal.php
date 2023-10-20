<div class="modal fade" id="add_student_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modal-title">Enter user Information</h4>
            </div>
            <form id="add_student_form">
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="student_personal_id">Enter ID:</label>
                            <input type="text" id="student_personal_id" name="student_personal_id" class="form-control" placeholder="ID"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="student_first_name">Enter First Name:</label>
                            <input type="text" name="student_first_name" class="form-control" placeholder="First Name" required/>
                        </div>
                        <div class="form-group">
                            <label for="student_last_name">Enter Last Name:</label>
                            <input type="text" name="student_last_name" class="form-control" placeholder="Last Name" required>
                        </div>
                        <div class="form-group">
                            <label for="student_gender">Select Gender:</label>
                            <select class="form-control" name="student_gender" placeholder="Gender" required>
                                <option>Male</option>
                                <option>Female</option>
                                <option>None</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="student_email">Enter Email Address:</label>
                            <input type="email" name="student_email" class="form-control" placeholder="Email" required
                                autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label for="student_date">Select Birthday:</label>
                            <input type="date" name="student_date" class="form-control" placeholder="Birthdate" required>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="modal-footer">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success pull-left">Add Student</button>
                        <button type="reset" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal ADD User -->