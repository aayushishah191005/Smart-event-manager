<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | Event Portal</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>

  <nav class="navbar">
    <div class="nav-container">
      <div class="logo">Event Portal</div>
      <ul class="nav-links">
        <li><a href="add_event.php">Add Event</a></li>
        <li><a href="view_events.php">View My Events</a></li>
        <li><a href="logout.php" class="logout-btn">Logout</a></li>
      </ul>
    </div>
  </nav>

  <div class="dashboard-content">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>Select an option from the navigation bar above to continue.</p>
  </div>

</body>
</html>
