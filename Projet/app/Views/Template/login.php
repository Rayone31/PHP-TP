<?php
session_start();
require '../../Model/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if (empty($username) || empty($password) || empty($role)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        if ($role == 'admin') {
            
            $stmt = $pdo->prepare('SELECT * FROM admins WHERE username = ?');
        } else {
            
            $stmt = $pdo->prepare('SELECT * FROM Users WHERE username = ?');
        }

        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['is_admin'] = ($role == 'admin');
            $_SESSION['user_id'] = $user['id'];
            // redirection vers la page d'accueil
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
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>