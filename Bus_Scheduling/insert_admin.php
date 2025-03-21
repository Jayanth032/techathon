<?php
include 'db_connect.php';

$username = "admin";  // Change this if needed
$password = "admin123"; // Change this password in production

// Hash the password securely
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert the admin user
$stmt = $conn->prepare("INSERT INTO admin_users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashedPassword);

if ($stmt->execute()) {
    echo "✅ Admin user created successfully! You can now log in.";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
