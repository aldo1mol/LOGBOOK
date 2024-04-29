$(document).ready(function(){
    $('#contact').on('input', function() {
        // Remove any non-numeric characters
        $(this).val($(this).val().replace(/\D/g,''));
    });
});