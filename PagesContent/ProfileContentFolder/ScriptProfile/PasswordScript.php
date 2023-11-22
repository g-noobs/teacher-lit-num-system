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