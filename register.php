<?php
session_start();
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Username already exists!'); window.location='register.php';</script>";
    } else {
        mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$password')");
        echo "<script>alert('Registration successful! You can now log in.'); window.location='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Register - Event Manager</title>
</head>
<body>
    <h2>Register</h2>
    <form method="POST" action="">
        <label>Username:</label>
        <input type="text" name="username" required><br><br>
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
</body>
</html>
