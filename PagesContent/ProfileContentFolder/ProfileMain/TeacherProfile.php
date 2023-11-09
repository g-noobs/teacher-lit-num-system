<div class="container">
    <div class="box box-primary container">
        <div class="box-header with-border">
            <h3 class="box-title" id="teacher_name_dashboard">
                Edit Teacher Data Here!
            </h3>
            <div class="row" style="margin-left:20px;"><a href='#' id="edit-icon"><span
                        class='glyphicon glyphicon-edit'></span></a></div>
        </div>
        <div class="box-body" id="content_body">
            <div class="row">
                <form action="post" id="teacher_profile">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="teacher_last_name">Last Name</label>
                            <input type="text" name="teacher_first_name" class="form-control" placeholder="Fist Name"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="teacher_first_name">First Name</label>
                            <input type="text" name="teacher_first_name" class="form-control" placeholder="Fist Name"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="teacher_middle_initial">Middle Initial
                                <span><small>*optional</small></span></label>
                            <select name="teacher_middle_initial" id="teacher_middle_initial" class="form-control">
                                <option value="">-</option>
                            </select>
                        </div>
                        <div class="form-group">

                        </div>
                    </div>

                    <div class="col-md-6"></div>
                </form>
            </div>
            <div class="row">
                <button class="btn btn-primary" id="update-btn" type="submit">Update Profile</button>
            </div>
        </div>
    </div>

</div>