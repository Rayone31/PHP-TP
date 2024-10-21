<?php
require '../../Model/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Valider les données
    if (empty($username) || empty($password)) {
        $error = 'Veuillez remplir tous les champs.';
    } else {
        // Vérifier si le nom d'utilisateur existe déjà
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM Users WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetchColumn() > 0) {
            $error = 'Nom d\'utilisateur déjà pris.';
        } else {
            // Hacher le mot de passe
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insérer les données dans la table Users
            $sql = "INSERT INTO Users (username, password) VALUES (:username, :password)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute(['username' => $username, 'password' => $hashed_password])) {
                // Redirection vers la page de connexion après une inscription réussie
                header("Location: login.php");
                exit;
            } else {
                $error = "Erreur lors de l'inscription. Veuillez réessayer.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Views/public/assets/css/register.css">
    <title>Inscription</title>
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form action="register.php" method="post">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="S'inscrire">
        </form>
    </div>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> CV Portal. All rights reserved.</p>
    </footer>
</body>
</html>