<?php
require '../../Model/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;

    // Valider les données
    if (empty($username) || empty($password)) {
        die('Veuillez remplir tous les champs.');
    }

    // Hacher le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insérer les données dans la table Users
    $sql = "INSERT INTO Users (username, password) VALUES (:username, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username, 'password' => $hashed_password]);

    echo "Inscription réussie !";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form action="register.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>