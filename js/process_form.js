$(document).ready(function(){
    $('#logbookForm').submit(function(e){
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'welcome.php', // Submitting to the same page
            data: formData,
            dataType: 'html', // Expecting HTML response
            success: function(response){
                // Display the response from the server
                $('#logbookForm').html(response);
            }
        });
    });
});