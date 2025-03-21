<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin_id'])) {  // Fixed session check
    header("Location: admin-login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure it's an integer

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM bus_stops WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "✅ Bus stop deleted successfully! <a href='manage-stops.php'>View Stops</a>";
    } else {
        echo "❌ Error deleting record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
