<?php
session_start(); // Démarre la session
require '../../Model/db.php'; // Inclut le fichier de connexion à la base de données

// Vérifie si la méthode de la requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère et nettoie les données du formulaire
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Vérifie si tous les champs sont remplis
    if (empty($username) || empty($password) || empty($role)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        // Prépare la requête SQL en fonction du rôle
        if ($role == 'admin') {
            $stmt = $pdo->prepare('SELECT * FROM admins WHERE username = ?');
        } else {
            $stmt = $pdo->prepare('SELECT * FROM Users WHERE username = ?');
        }

        // Exécute la requête avec le nom d'utilisateur
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Vérifie si l'utilisateur existe et si le mot de passe est correct
        if ($user && password_verify($password, $user['password'])) {
            // Stocke les informations de l'utilisateur dans la session
            $_SESSION['username'] = $username;
            $_SESSION['is_admin'] = ($role == 'admin');
            $_SESSION['user_id'] = $user['id'];
            // Redirige vers la page d'accueil
            header("Location: accueil.php");
            exit;
        } else {
            $error = "Nom d'utilisateur ou mot de passe invalide !";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../Views/public/assets/css/login.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error)): // Affiche un message d'erreur si nécessaire ?>
            <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>