<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT * FROM events WHERE user_id='$user_id'");

$xml = new SimpleXMLElement('<events/>');
while ($row = mysqli_fetch_assoc($result)) {
    $event = $xml->addChild('event');
    $event->addChild('name', $row['event_name']);
    $event->addChild('date', $row['event_date']);
    $event->addChild('description', $row['event_description']);
}

Header('Content-type: text/xml');
echo $xml->asXML();
?>
