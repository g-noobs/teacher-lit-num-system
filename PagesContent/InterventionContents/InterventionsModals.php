<!-- Intervention Modal -->
<div class="modal fade" id="intervention_modal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Are you sure to finish this student's Intervention?</h4>
                <h5>Student Name: <span id="studername_intervention"></span></h5>

            </div>
            <div class="modal-body">
                <p>Click Button to Confirm!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" id="confirm_finish_intervention">Update</button>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="add_intervention_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Input Student Data for Intervention</h4>

            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-danger alert-dismissible" id="add_user_modal_alert" role="alert"
                        style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <span id="add_user_modal_alert_text"></span>
                    </div>
                </div>
            </div>
            <form id="intervention_form">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="student_id">Student Name:</label>
                        <select name="student_id" id="student_id" class="form-control">
                            <?php
                                $userQuery = "SELECT u.first_name, u.last_name, u.personal_id
                                FROM tbl_user_info u
                                LEFT JOIN tbl_intervention i ON u.personal_id = i.student_id AND i.status = 1
                                WHERE u.user_level_id = 2 AND (i.status = 1 OR i.status IS NULL);";
                                $userResult = mysqli_query($connection, $userQuery);

                                while ($userRow = mysqli_fetch_assoc($userResult)) {
                                    $fullName = $userRow['first_name'] . ' ' . $userRow['last_name'];
                                    $personalId = $userRow['personal_id'];
                                    echo "<option value='$personalId'>$fullName</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="startDate">Start Date:</label>
                        <input type="date" name="startDate" id="startDate" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="endDate">End Date:</label>
                        <input type="date" name="endDate" id="endDate" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="comments">Comments:</label>
                        <textarea name="comments" id="comments" rows="4" class="form-control"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger pull-left"
                            id="confirm_finish_intervention">Add</button>
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>