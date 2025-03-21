<?php
session_start();
if (!isset($_SESSION['admin_id'])) {  
    header("Location: admin-login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <header>
        <h1>Admin Dashboard</h1>
    </header>

    <section class="dashboard-container">
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <p>Manage bus schedules and routes efficiently.</p>

        <div class="admin-options">
            <a href="add-bus.php" class="button">➕ Add Bus</a>
            <a href="schedule.php" class="button">📋 View Schedule</a>
            <a href="manage-stops.php" class="button">🛑 Manage Bus Stops</a>
            <a href="admin-logout.php" class="button logout">🚪 Logout</a>
        </div>
    </section>

</body>
</html>
