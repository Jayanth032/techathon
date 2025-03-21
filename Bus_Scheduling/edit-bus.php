<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin_id'])) {  // Fixed session check
    header("Location: admin-login.php");
    exit();
}

$bus = null;

// Fetch bus details
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure it's an integer
    $stmt = $conn->prepare("SELECT * FROM bus_routes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $bus = $result->fetch_assoc();
    } else {
        echo "❌ Bus not found!";
        exit();
    }
    $stmt->close();
}

// Update bus details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $bus_number = $_POST['bus_number'];
    $route = $_POST['route'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];

    $stmt = $conn->prepare("UPDATE bus_routes SET 
                bus_number=?, 
                route=?, 
                departure_time=?, 
                arrival_time=? 
            WHERE id=?");
    $stmt->bind_param("ssssi", $bus_number, $route, $departure_time, $arrival_time, $id);

    if ($stmt->execute()) {
        echo "✅ Bus updated successfully! <a href='schedule.php'>View Schedule</a>";
    } else {
        echo "❌ Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Bus</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h2>Edit Bus</h2>

    <?php if ($bus): ?>
    <form action="edit-bus.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($bus['id']) ?>">

        <label for="bus_number">Bus Number:</label>
        <input type="text" id="bus_number" name="bus_number" value="<?= htmlspecialchars($bus['bus_number']) ?>" required>

        <label for="route">Route:</label>
        <input type="text" id="route" name="route" value="<?= htmlspecialchars($bus['route']) ?>" required>

        <label for="departure_time">Departure Time:</label>
        <input type="time" id="departure_time" name="departure_time" value="<?= htmlspecialchars($bus['departure_time']) ?>" required>

        <label for="arrival_time">Arrival Time:</label>
        <input type="time" id="arrival_time" name="arrival_time" value="<?= htmlspecialchars($bus['arrival_time']) ?>" required>

        <button type="submit">Update Bus</button>
    </form>
    <?php else: ?>
        <p>❌ Bus not found!</p>
    <?php endif; ?>

    <br>
    <a href="schedule.php">Back to Schedule</a>

</body>
</html>
