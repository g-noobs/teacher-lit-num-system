<div class="container">
    <div class="box box-primary container">
        <div class="box-header with-border">
            <h3 class="box-title">
                Edit Teacher Data Here!
            </h3>
            <br>
            <div class="row" style="margin-left:20px;"><a href='#' id="edit-icon"><span
                        class='glyphicon glyphicon-edit'></span></a></div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-danger alert-dismissible" id="edit_user_validate_alert" role="alert"
                    style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                    <span id="edit_user_validate_alert_text">test alerttext</span>
                </div>
            </div>
        </div>
        <form id="teacher_profile">
            <div class="box-body" id="content_body">
                <div class="form-group row">
                    <div class="col-sm-5">
                        <label for="last_name" col-form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name"
                            required>
                    </div>
                    <div class="col-sm-5">
                        <label for="first_name" col-form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" id="first_name"
                            placeholder="First Name" required>
                    </div>
                    <div class="col-sm-2">
                        <label for="middle_initial" col-form-label">M.I. (**optional)</label>
                        <input type="text" class="form-control" name="middle_initial" id="middle_initial"
                            placeholder="Middle Initial" maxlength="1" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-control">
                            
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="phone">Phone</label>
                        <input type="tel" name="phone" placeholder="Contact Number" class="form-control" required>
                    </div>
                    <div class="col-sm-4">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" placeholder="Email Address" class="form-control" required>
                    </div>
                </div>
                <div class="container row">
                    <h4><strong>Address:</strong></h4>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="street">Street</label>
                        <input type="text" name="street" placeholder="Street" class="form-control" required>
                    </div>
                    <div class="col-sm-6">
                        <label for="baranggay">Baranggay</label>
                        <input type="text" name="baranggay" placeholder="Baranggay" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="city_municipality">City /Municipal</label>
                        <input type="text" name="city_municipality" placeholder="City /Municipal" class="form-control"
                            required>
                    </div>
                    <div class="col-sm-4">
                        <label for="province">Province</label>
                        <input type="text" name="province" placeholder="Province" class="form-control" required>
                    </div>
                    <div class="col-sm-4">
                        <label for="zip_code">Zip Code</label>
                        <input type="number" name="zip_code" placeholder="Zip Code" class="form-control" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 form-group">
                        <label for="username:">Username: </label>
                        <input type="text" name="username" id="username" required="" class="form-control"
                            placeholder="Username" readonly="" disabled="">
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" required="" class="form-control"
                                placeholder="Password" readonly="" disabled="">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="togglePassword">
                                    <span class="glyphicon glyphicon-eye-open" id="password-icon"></span>
                                </button>
                            </span>
                        </div>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="confirm_pass">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" name="confirm_pass" id="confirm_pass" required=""
                                class="form-control" placeholder="Confirm Password" readonly="" disabled="">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="toggleConfirmPassword">
                                    <span class="glyphicon glyphicon-eye-open" id="confirm-password-icon"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <button class="btn btn-primary" id="update-btn" type="submit">Update Profile</button>
                </div>
            </div>
        </form>
    </div>
</div>