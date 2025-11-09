<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css">
<title>Register</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Event Registration</h2>
<form method="post">
  <input type="hidden" name="event_id" value="<?php echo $_GET['id']; ?>">
  <input type="text" name="name" placeholder="Your Name" required><br>
  <input type="email" name="email" placeholder="Your Email" required><br>
  <button type="submit" name="register">Register</button>
</form>
<div class="home-btn-container">
  <a href="index.php" class="home-btn">🏠 Back to Home</a>
</div>

<?php
if (isset($_POST['register'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $event_id = $_POST['event_id'];
  $sql = "INSERT INTO registrations (name, email, event_id) VALUES ('$name', '$email', '$event_id')";
  if (mysqli_query($conn, $sql)) {
    echo "<p>🎉 Registered Successfully!</p>";
  }
}
?>
</body>
</html>
