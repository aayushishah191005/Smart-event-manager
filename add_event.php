<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db_connect.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Event</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Add New Event</h2>

<form method="post" action="">
  <input type="text" name="name" placeholder="Event Name" required><br>
  <input type="date" name="date" required><br>
  <input type="text" name="location" placeholder="Location" required><br>
  <textarea name="description" placeholder="Description"></textarea><br>
  <button type="submit" name="add">Add Event</button>
</form>

<div class="home-btn-container">
  <a href="index.php" class="home-btn">🏠 Back to Home</a>
</div>

<?php
if (isset($_POST['add'])) {
    // Get form inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $user_id = $_SESSION['user_id']; // store user-specific event

    // Query
    $query = "INSERT INTO events (name, date, location, description, user_id)
              VALUES ('$name', '$date', '$location', '$desc', '$user_id')";

    // Execute
    if (mysqli_query($conn, $query)) {
        echo "<p>✅ Event added successfully!</p>";
    } else {
        echo "<p>❌ Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

</body>
</html>
