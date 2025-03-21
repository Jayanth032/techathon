<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stop_name = $_POST['stop_name'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Prevent duplicate stops
    $check_sql = "SELECT * FROM bus_stops WHERE stop_name = '$stop_name'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "Error: Stop name already exists! <a href='manage-stops.php'>Go back</a>";
    } else {
        $sql = "INSERT INTO bus_stops (stop_name, latitude, longitude) 
                VALUES ('$stop_name', '$latitude', '$longitude')";

        if ($conn->query($sql) === TRUE) {
            echo "New bus stop added successfully! <a href='manage-stops.php'>View Stops</a>";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    $conn->close();
}
?>
