<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT * FROM events WHERE user_id='$user_id' ORDER BY date ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Events</title>
  <link rel="stylesheet" href="style.css?v=3">
</head>
<body>

  <nav class="navbar">
    <div class="nav-container">
      <h1 class="logo">Event Portal</h1>
      <ul class="nav-links">
        <li><a href="add_event.php">Add Event</a></li>
        <li><a href="view_events.php" class="active">View My Events</a></li>
        <li><a href="logout.php" class="logout-btn">Logout</a></li>
      </ul>
    </div>
  </nav>

  <div class="dashboard-content">
    <h2>My Events</h2>
    <p>All your scheduled events are listed below:</p>

    <div class="event-grid">
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="event-card">
          <h3><?php echo htmlspecialchars($row['name']); ?></h3>
          <p class="event-date">📅 <?php echo htmlspecialchars($row['date']); ?></p>
          <p class="event-desc"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
        </div>
      <?php } ?>
      <?php if (mysqli_num_rows($result) == 0) { ?>
        <p>No events found. <a href="add_event.php" style="color:#ffde59;">Add one now!</a></p>
      <?php } ?>
    </div>

  </div>

</body>
</html>
