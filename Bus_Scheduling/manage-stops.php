<?php
session_start();
if (!isset($_SESSION['admin_id'])) {  // Ensure only logged-in admins can access
    header("Location: admin-login.php");
    exit();
}

include 'db_connect.php'; // Ensure database connection is included
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bus Stops</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <header>
        <h1>Manage Bus Stops</h1>
    </header>

    <section class="container">
        <h2>List of Bus Stops</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Stop Name</th>
                <th>Actions</th>
            </tr>
            <?php
            $sql = "SELECT * FROM bus_stops ORDER BY id ASC";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['stop_name']}</td>
                        <td>
                            <a href='edit-stop.php?id={$row['id']}'>Edit</a> | 
                            <a href='delete-stop.php?id={$row['id']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                        </td>
                      </tr>";
            }
            ?>
        </table>
    </section>

    <br>
    <a href="admin-dashboard.php" class="button">🏠 Back to Dashboard</a>

    <footer>
        <p>&copy; 2024 Bus Scheduling System | Admin Panel</p>
    </footer>

</body>
</html>
