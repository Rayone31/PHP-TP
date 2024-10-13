<?php
session_start();
require '../../Model/db.php'; // Include the database connection

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']); // Change this according to your login session management

// Optionally, you can fetch some general site information here
// $stmt = $pdo->prepare('SELECT * FROM site_info WHERE id = 1');
// $stmt->execute();
// $siteInfo = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the CV Portal</title>
    <link rel="stylesheet" href="Views/public/assets/css/index.css">
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <header>
            <h1>Welcome to the CV Portal</h1>
            <p>Your one-stop solution for creating and managing CVs.</p>
        </header>

        <!-- Main Content Section -->
        <main>
            <?php if ($isLoggedIn): ?>
                <p>You are logged in. You can manage your CV from here.</p>
                <a href="Views/Template/logout.php">Logout</a>
            <?php else: ?>
                <p>Please log in to access your CV or create a new one.</p>
                <a href="Views/Template/login.php">Admin Login</a>
                <a href="Views/Template/register.php">Create an Account</a>
            <?php endif; ?>
        </main>

        <!-- Footer Section -->
        <footer>
            <p>&copy; <?php echo date("Y"); ?> CV Portal. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
