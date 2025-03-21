<?php
session_start();
if (!isset($_SESSION['admin_id'])) {  // Fixed session check
    header("Location: admin-login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Bus</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h2>Add a New Bus</h2>

    <form action="save-bus.php" method="POST">
        <label for="bus_number">Bus Number:</label>
        <input type="text" id="bus_number" name="bus_number" required>

        <label for="route">Route:</label>
        <input type="text" id="route" name="route" required>

        <label for="departure_time">Departure Time:</label>
        <input type="time" id="departure_time" name="departure_time" required>

        <label for="arrival_time">Arrival Time:</label>
        <input type="time" id="arrival_time" name="arrival_time" required>

        <button type="submit">Add Bus</button>
    </form>

    <br>
    <a href="admin-dashboard.php">Back to Dashboard</a>

</body>
</html>
