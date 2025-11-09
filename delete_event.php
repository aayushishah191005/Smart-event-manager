<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $event_id = intval($_GET['id']);
    $query = "DELETE FROM events WHERE id='$event_id' AND user_id='$user_id'";
    mysqli_query($conn, $query);
}

header("Location: view_events.php");
exit();
?>
