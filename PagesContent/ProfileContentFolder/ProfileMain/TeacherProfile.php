<div class="container">
    <div class="box box-primary container">
        <div class="box-header with-border">
            <h3 class="box-title" id="teacher_name_dashboard">
                Edit Teacher Data Here!
            </h3>
            <div class="row" style="margin-left:20px;"><a href='#' id="edit-icon"><span
                        class='glyphicon glyphicon-edit'></span></a></div>
        </div>
        <form action="post" id="teacher_profile">
            <div class="box-body" id="content_body">
                <div class="form-group row">
                    <div class="col-sm-5">
                        <label for="teacher_id" col-form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" placeholder="Last Name" required>
                    </div>
                    <div class="col-sm-5">
                        <label for="teacher_id" col-form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" placeholder="First Name" required>
                    </div>
                    <div class="col-sm-2">
                        <label for="teacher_id" col-form-label">M.I. (**optional)</label>
                        <input type="text" class="form-control" id="middle_initial" placeholder="Middle Initial"
                            maxlength="1" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="gender">Gender</label>
                        <select name="gemder" id="gender" class="form-control">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
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
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="username:">Username: </label>
                        <input type="text" name="username" id="username" required="" class="form-control"
                            placeholder="Username" readonly="" disabled="">
                    </div>

                    <div class="col-sm-4">
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

                    <div class="col-sm-4">
                        <label for="confirm_pass">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" name="confirmPassword" id="confirmPassword" required=""
                                class="form-control" placeholder="Confirm Password" readonly="" disabled="">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="toggleConfirmPassword">
                                    <span class="glyphicon glyphicon-eye-open" id="confirm-password-icon"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <button class="btn btn-primary" id="update-btn" type="submit">Update Profile</button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#toggleConfirmPassword').click(function() {
        var passwordInput = $('#confirmPassword');
        var passwordIcon = $('#confirm-password-icon');

        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            passwordIcon.removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
        } else {
            passwordInput.attr('type', 'password');
            passwordIcon.removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
        }
    });
});
</script>

<script>
$(document).ready(function() {
    $('#togglePassword').click(function() {
        var passwordInput = $('#password');
        var passwordIcon = $('#password-icon');

        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            passwordIcon.removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
        } else {
            passwordInput.attr('type', 'password');
            passwordIcon.removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
        }
    });
});
</script>