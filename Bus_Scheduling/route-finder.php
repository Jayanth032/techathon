<?php
include 'db_connect.php';

// Fetch all bus stops for dropdown selection
$stops = [];
$sql = "SELECT * FROM bus_stops ORDER BY stop_name ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $stops[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Route Finder</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h2>Find a Bus Between Two Stops</h2>

    <form method="POST" action="route-finder.php">
        <label for="start_stop">Starting Stop:</label>
        <select id="start_stop" name="start_stop" required>
            <option value="">Select Start</option>
            <?php foreach ($stops as $stop) { ?>
                <option value="<?= $stop['stop_name'] ?>"><?= $stop['stop_name'] ?></option>
            <?php } ?>
        </select>

        <label for="end_stop">Destination Stop:</label>
        <select id="end_stop" name="end_stop" required>
            <option value="">Select Destination</option>
            <?php foreach ($stops as $stop) { ?>
                <option value="<?= $stop['stop_name'] ?>"><?= $stop['stop_name'] ?></option>
            <?php } ?>
        </select>

        <button type="submit">Find Route</button>
    </form>

    <br>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $start = $_POST['start_stop'];
        $end = $_POST['end_stop'];

        // Step 1: Find direct buses
        $sql = "SELECT DISTINCT bus_number, route, departure_time, arrival_time 
                FROM bus_routes 
                WHERE route LIKE '%$start%' AND route LIKE '%$end%'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h3>Direct Buses</h3>";
            echo "<table border='1'>";
            echo "<tr><th>Bus Number</th><th>Route</th><th>Departure Time</th><th>Arrival Time</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['bus_number']}</td>
                        <td>{$row['route']}</td>
                        <td>{$row['departure_time']}</td>
                        <td>{$row['arrival_time']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No direct buses found. Searching for alternative routes...</p>";

            // Step 2: Find indirect routes with one transfer
            $sql = "SELECT 
                        b1.bus_number AS bus1, b1.route AS route1, b1.departure_time AS dep1, b1.arrival_time AS arr1,
                        b2.bus_number AS bus2, b2.route AS route2, b2.departure_time AS dep2, b2.arrival_time AS arr2
                    FROM bus_routes b1
                    JOIN bus_routes b2 
                        ON b1.route LIKE CONCAT('%', b2.route, '%')
                        OR b2.route LIKE CONCAT('%', b1.route, '%')
                    WHERE (b1.route LIKE '%$start%' AND b2.route LIKE '%$end%')
                    AND b1.bus_number <> b2.bus_number";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h3>Alternative Routes (With Transfer)</h3>";
                echo "<table border='1'>";
                echo "<tr><th>Bus 1</th><th>Route 1</th><th>Departs</th><th>Arrives</th>
                          <th>Bus 2</th><th>Route 2</th><th>Departs</th><th>Arrives</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['bus1']}</td>
                            <td>{$row['route1']}</td>
                            <td>{$row['dep1']}</td>
                            <td>{$row['arr1']}</td>
                            <td>{$row['bus2']}</td>
                            <td>{$row['route2']}</td>
                            <td>{$row['dep2']}</td>
                            <td>{$row['arr2']}</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No alternative routes found.</p>";
            }
        }
    }

    $conn->close();
    ?>

    <br>
    <a href="index.php">Back to Home</a>

</body>
</html>
