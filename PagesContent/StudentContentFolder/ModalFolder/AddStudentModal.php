<div class="modal fade" id="add_user_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modal-title">Enter Student Information</h4>
                <div id="formError" style="background-color: red; display:none;"></div>
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
            <form id="addUserForm">
                <div class="modal-body">
                    <div class="box-body box-warning">
                        <div class="form-group row">
                            <div class="col-xs-3">
                                <label for="personal_id">Enter Student:</label>
                                <input type="text" name="personal_id" class="form-control input-xs"
                                    placeholder="Student ID" required>
                            </div>
                            <div class="col-xs-3">
                                <label for="last_name">Enter Last Name:</label>
                                <input type="text" name="last_name" class="form-control input-xs"
                                    placeholder="Last Name" required>
                            </div>
                            <div class="col-xs-3">
                                <label for="first_name">Enter First Name:</label>
                                <input type="text" name="first_name" class="form-control input-xs"
                                    placeholder="First Name" required autocomplete="given-name" />
                            </div>
                            <div class="col-xs-3">
                                <label for="user_middle_initial">Middle Initial (*optional)</label>
                                <input type="text" name="user_middle_initial" class="form-control input-xs">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-4">
                                <label for="gender">Select Gender:</label>
                                <select class="form-control input-xs" name="gender" placeholder="Gender" required>
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>None</option>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label for="phone_num">Phone:</label>
                                <input type="tel" class="form-control input-xs" name="phone_num" required
                                    placeholder="Phone Number">
                            </div>
                            <div class="col-xs-4">
                                <label for="email">Enter Email Address:</label>
                                <input type="email" name="email" class="form-control input-xs" placeholder="Email"
                                    required autocomplete="off" />
                            </div>
                        </div>
                        <div class="container row">
                            <h4><strong>Address:</strong></h4>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-6">
                                <label for="street_address">Street</label>
                                <input type="text" name="street_address" class="form-control input-xs"
                                    placeholder="Street" required autocomplete="street-address" />
                            </div>
                            <div class="col-xs-6">
                                <label for="barangay_address">Baranggay</label>
                                <input type="text" name="barangay_address" class="form-control input-xs"
                                    placeholder="Barangay" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-4">
                                <label for="city">City</label>
                                <input type="text" name="city_address" class="form-control input-xs" placeholder="City"
                                    required />
                            </div>
                            <div class="col-xs-4">
                                <label for="province_address">Province</label>
                                <input type="text" name="province_address" class="form-control input-xs"
                                    placeholder="Province" />
                            </div>
                            <div class="col-xs-4">
                                <label for="zip_code">Zip Code</label>
                                <input type="number" name="zip_code" class="form-control input-xs"
                                    placeholder="Zip Code" required autocomplete="postal-code" />
                            </div>
                        </div>
                        <div class="container row">
                            <h4><strong>Guardian Information:</strong></h4>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-5">
                                <label for="guardian_last_name">Last Name:</label>
                                <input type="text" name="guardian_last_name" class="form-control input-xs"
                                    placeholder="Last Name" required />
                            </div>
                            <div class="col-xs-5">
                                <label for="guardian_first_name">First Name:</label>
                                <input type="text" name="guardian_first_name" class="form-control input-xs"
                                    placeholder="First Name" required />
                            </div>

                            <div class="col-xs-2">
                                <label for="guardian_middle_name">Middle Initial</label>
                                <select name="guardian_middle_name" id="guardian_middle_name"
                                    class="form-control input-xs">
                                    <option value="">-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-6">
                                <label for="guardian_phone_num">Phone Number:</label>
                                <input type="tel" name="guardian_phone_num" class="form-control input-xs"
                                    placeholder="Phone Number" required />
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="modal-footer">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success pull-left">Add Learner</button>
                                <button type="reset" class="btn btn-default pull-right"
                                    data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal ADD User -->