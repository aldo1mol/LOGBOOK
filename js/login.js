
$(document).ready(function() {
    $('.password-toggle').click(function() {
        var passwordField = $('#password');
        var fieldType = passwordField.attr('type');

        if (fieldType === 'password') {
            passwordField.attr('type', 'text');
            $(this).removeClass('bx-show').addClass('bx-hide');
        } else {
            passwordField.attr('type', 'password');
            $(this).removeClass('bx-hide').addClass('bx-show');
        }
    });
});