<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("db_connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    echo "<script>alert('No event selected'); window.location='view_events.php';</script>";
    exit();
}

$event_id = $_GET['id'];

// Fetch event details
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $event_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Event not found or unauthorized access'); window.location='view_events.php';</script>";
    exit();
}

$event = $result->fetch_assoc();

// Update event if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $description = $_POST['description'];

    $update = $conn->prepare("UPDATE events SET name=?, date=?, description=? WHERE id=? AND user_id=?");
    $update->bind_param("sssii", $name, $date, $description, $event_id, $user_id);
    $update->execute();

    echo "<script>alert('Event updated successfully'); window.location='view_events.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link rel="stylesheet" href="style.css?v=4">
    <style>
        body {
            background-color: #F9F7F7;
            font-family: 'Poppins', sans-serif;
            color: #4A4A68;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .edit-container {
            width: 400px;
            background: #E8EAF6;
            padding: 35px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(150, 150, 150, 0.2);
        }

        h2 {
            color: #3E3B64;
            margin-bottom: 25px;
        }

        label {
            display: block;
            text-align: left;
            margin: 10px 0 5px;
            font-weight: 500;
            color: #5C5470;
        }

        input[type="text"], input[type="date"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #D1D1E9;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
            outline: none;
            background-color: #F5F6FA;
            color: #4A4A68;
            transition: 0.3s;
        }

        input:focus, textarea:focus {
            border-color: #A3CEF1;
            box-shadow: 0 0 5px #A3CEF1;
        }

        button {
            background-color: #A3CEF1;
            color: #3E3B64;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            width: 100%;
        }

        button:hover {
            background-color: #8DC6E9;
        }

        .back-link {
            display: inline-block;
            margin-top: 15px;
            color: #3E3B64;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .back-link:hover {
            color: #6A7BA2;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="edit-container">
    <h2>Edit Event</h2>
    <form method="POST" action="">
        <label for="name">Event Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($event['name']); ?>" required>

        <label for="date">Date:</label>
        <input type="date" name="date" value="<?php echo htmlspecialchars($event['date']); ?>" required>

        <label for="description">Description:</label>
        <textarea name="description" rows="4" required><?php echo htmlspecialchars($event['description']); ?></textarea>

        <button type="submit">Update Event</button>
    </form>

    <a href="view_events.php" class="back-link">← Back to My Events</a>
</div>

</body>
</html>
