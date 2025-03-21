<?php
include 'db_connect.php';

header("Content-Type: application/json");

$sql = "SELECT bus_number, route, departure_time, arrival_time FROM bus_routes1";
$result = $conn->query($sql);

$schedules = [];
while ($row = $result->fetch_assoc()) {
    $schedules[] = $row;
}

echo json_encode($schedules);
$conn->close();
?>
