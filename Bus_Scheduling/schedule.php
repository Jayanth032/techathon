<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Schedule</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h2>Bus Schedule</h2>

    <!-- Search Form -->
    <form method="GET" action="schedule.php">
        <label for="search">Search Bus:</label>
        <input type="text" id="search" name="search" placeholder="Enter bus number or route">
        <button type="submit">Search</button>
    </form>
    <br>

    <table border="1">
        <tr>
            <th>Bus Number</th>
            <th>Route</th>
            <th>Departure Time</th>
            <th>Arrival Time</th>
            <th>Actions</th>
        </tr>

        <?php
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        if (!empty($search)) {
            $sql = "SELECT * FROM bus_routes 
                    WHERE bus_number LIKE '%$search%' 
                    OR route LIKE '%$search%'
                    OR departure_time LIKE '%$search%'";
        } else {
            $sql = "SELECT * FROM bus_routes";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['bus_number']}</td>
                        <td>{$row['route']}</td>
                        <td>{$row['departure_time']}</td>
                        <td>{$row['arrival_time']}</td>
                        <td>
                            <a href='edit-bus.php?id={$row['id']}'>Edit</a> | 
                            <a href='delete-bus.php?id={$row['id']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No matching results</td></tr>";
        }

        $conn->close();
        ?>
    </table>

    <br>
    <a href="admin-dashboard.php">Back to Dashboard</a>

</body>
</html>
