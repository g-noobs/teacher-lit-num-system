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
                    <div class="form-group row">
                        <div class="col-sm-5">
                            <label for="teacher_id" col-form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" placeholder="Last Name" required>
                        </div>
                        <div class="col-sm-5">
                            <label for="teacher_id" col-form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" placeholder="Last Name" required>
                        </div>
                        <div class="col-sm-2">
                            <label for="teacher_id" col-form-label">M.I. (**optional)</label>
                            <input type="text" class="form-control" id="middle_initial" placeholder="Last Name"
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="gender">Gender</label>
                            <select name="gemder" id="gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="phone">Phone</label>
                            <input type="tel" name="phone" placeholder="Contact Number" required>
                        </div>
                        <div class="col-sm-4">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" placeholder="Email Address" required>
                        </div>
                    </div>
                    <div class="container row">
                        <h4><strong>Address:</strong></h4>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="street">Street</label>
                            <input type="text" name="street" placeholder="Street" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="baranggay">Baranggay</label>
                            <input type="text" name="baranggay" placeholder="Baranggay" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="city_municipality">City /Municipal</label>
                            <input type="text" name="city_municipality" placeholder="City /Municipal" required>
                        </div>
                        <div class="col-sm-4">
                            <label for="province">Province</label>
                            <input type="text" name="province" placeholder="Province" required>
                        </div>
                        <div class="col-sm-4">
                            <label for="zip_code">Zip Code</label>
                            <input type="number" name="zip_code" placeholder="Zip Code" required>
                        </div>
                    </div>
                    
                    <!-- <div class="col-md-6">
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
                    </div> -->

                    <!-- <div class="col-md-6"></div> -->
                </form>
            </div>
            <div class="row">
                <button class="btn btn-primary" id="update-btn" type="submit">Update Profile</button>
            </div>
        </div>
    </div>

</div>