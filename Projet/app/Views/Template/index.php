<?php

session_start();

require '../../Model/db.php';

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user_id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the CV Portal</title>
    <link rel="stylesheet" href="/Views/public/assets/css/index.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome to the CV Portal</h1>
            <p>Your one-stop solution for creating and managing CVs.</p>
        </header>

        <main>
            <p>Please log in to access your CV or create a new one.</p>
            <a href="/Views/Template/login.php">Login</a> 
            <a href="/Views/Template/register.php">Create an Account</a> 
        </main>

       
        <footer>
            <p>&copy; <?php echo date("Y"); ?> CV Portal. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>