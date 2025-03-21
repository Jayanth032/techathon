<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bus_number = $_POST['bus_number'];
    $route = $_POST['route'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];

    // Check if the bus number already exists
    $check_sql = "SELECT * FROM bus_routes WHERE bus_number = '$bus_number'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "Error: Bus number already exists! <a href='add-bus.php'>Go back</a>";
    } else {
        // Insert new bus only if it doesn't exist
        $sql = "INSERT INTO bus_routes (bus_number, route, departure_time, arrival_time) 
                VALUES ('$bus_number', '$route', '$departure_time', '$arrival_time')";

        if ($conn->query($sql) === TRUE) {
            echo "New bus added successfully! <a href='schedule.php'>View Schedule</a>";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    $conn->close();
}
?>
