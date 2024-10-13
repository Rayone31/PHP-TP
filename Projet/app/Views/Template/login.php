<?php
session_start();
require '../../Model/db.php'; // Inclure la connexion à la base de données

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if (empty($username) || empty($password) || empty($role)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        if ($role == 'admin') {
            // Préparer la requête SQL pour récupérer l'admin par nom d'utilisateur
            $stmt = $pdo->prepare('SELECT * FROM admins WHERE username = ?');
        } else {
            // Préparer la requête SQL pour récupérer l'utilisateur par nom d'utilisateur
            $stmt = $pdo->prepare('SELECT * FROM Users WHERE username = ?');
        }

        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Si l'utilisateur est trouvé, vérifier le mot de passe
        if ($user && password_verify($password, $user['password'])) {
            // Définir la session pour l'utilisateur
            $_SESSION['is_admin'] = ($role == 'admin');
            // Rediriger vers la page appropriée
            if ($role == 'admin') {
                header("Location: admin_index.php");
            } else {
                header("Location: user_index.php");
            }
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
    <link rel="stylesheet" href="Views/public/assets/css/index.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
            
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>