<?php
include 'config.php';
header('Content-Type: application/json');

session_start();
$user_id = $_SESSION['user_id'];

$query = "SELECT name, date FROM events WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}
echo json_encode($events);
?>
