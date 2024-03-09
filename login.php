<?php 

include "config.php";

// Fetch username and password from POST data
$username = $_POST['username'];
$password = $_POST['password'];

// Check if username and password match
$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Login successful
    session_start();
    $_SESSION['username'] = $username;

    // Check if the user is admin
    $user = $result->fetch_assoc();
    if ($user['username'] == 'admin') {
        echo 'admin';
    } else {
        echo 'success';
    }
} else {
    // Login failed
    echo 'Invalid username or password';
}

$conn->close();
?>