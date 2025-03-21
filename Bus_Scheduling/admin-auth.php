<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, username, password FROM admin_users WHERE username = ?");
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // ✅ Store session for logged-in admin
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // ✅ Redirect to Admin Dashboard
        header("Location: admin-dashboard.php");
        exit();
    } else {
        echo "<script>alert('❌ Invalid username or password!'); window.location.href='admin-login.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
