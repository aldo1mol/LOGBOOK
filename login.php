<?php
    // Include database connection or define it here
    include "config.php";

    // Fetch username and password from POST data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if username and password match
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Login successful
        $user = $result->fetch_assoc();
        $priority = $user['priority'];
        session_start();
        $_SESSION['username'] = $username;

        // Check user priority
        if ($priority == 'admin') {
            echo 'admin';
        } else if ($priority == 'user') {
            echo 'user';
        } else {
            echo 'Invalid priority';
        }
    } else {
        // Login failed
        echo 'Invalid username or password';
    }

    $conn->close();
?>
