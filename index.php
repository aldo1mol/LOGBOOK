
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knust-UITS-logbook</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="loginbox">
        <img src="img/knust.png" class="logo">
        <h1>KNUST-UITS</h1>
        <form id="loginForm" action="login.php" method="post">
            <p>Username</p>
            <input type="text" id="username" name="username">
            <p>Password</p>
            <div class="password-field">
                <input type="password" name="password" id="password" placeholder="Enter Password">
                <i class='bx bx-show password-toggle'></i>
            </div>
            <input type="submit" value="Login">
        </form>

        <div id="message"></div>

    </div>
    <script src="js/jquery-3.6.4.js"></script>
    <script src="js/login.js"></script>
    <script>
        $(document).ready(function(){
        $('#loginForm').submit(function(e){
            e.preventDefault(); // Prevent the default form submission behavior
            var username = $('#username').val();
            var password = $('#password').val();
            $.ajax({
                type: 'POST',
                url: 'login.php',
                data: {username: username, password: password},
                success: function(response){
                    if(response.trim() === 'admin'){
                        window.location.href = 'admin.php';
                    } else if (response.trim() === 'user') {
                        window.location.href = 'welcome.php';
                    } else {
                        $('#message').html(response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });


</script>

</body>
</html>