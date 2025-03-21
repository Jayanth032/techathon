<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <header>
        <h1>Admin Login</h1>
    </header>

    <section class="login-container">
        <h2>Admin Panel</h2>
        <form action="admin-auth.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <a href="index.php" class="back-link">← Back to Home</a>
    </section>

</body>
</html>
