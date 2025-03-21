<?php
include 'db_connect.php';

$username = "admin";  // Your actual admin username
$newPassword = "admin123"; // Choose a new password

// Securely hash the new password
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// Update the password in the database
$stmt = $conn->prepare("UPDATE admin_users SET password=? WHERE username=?");
$stmt->bind_param("ss", $hashedPassword, $username);

if ($stmt->execute()) {
    echo "✅ Password updated successfully! Try logging in again.";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
