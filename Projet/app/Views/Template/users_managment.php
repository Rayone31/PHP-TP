<?php
session_start();
require '../../Model/db.php';

// Vérifier si l'utilisateur est connecté et est un administrateur
if (!isset($_SESSION['username']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit;
}

// Récupérer tous les utilisateurs
$stmt = $pdo->prepare('SELECT * FROM Users');
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Supprimer un utilisateur et ses enregistrements associés
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_user_id'])) {
        $delete_user_id = intval($_POST['delete_user_id']);

        // Supprimer les enregistrements associés dans les tables dépendantes
        $stmt = $pdo->prepare('DELETE FROM personal_info WHERE Users_id = ?');
        $stmt->execute([$delete_user_id]);

        $stmt = $pdo->prepare('DELETE FROM CV WHERE Users_id = ?');
        $stmt->execute([$delete_user_id]);

        $stmt = $pdo->prepare('DELETE FROM project WHERE User_id = ?');
        $stmt->execute([$delete_user_id]);

        // Supprimer l'utilisateur
        $stmt = $pdo->prepare('DELETE FROM Users WHERE id = ?');
        $stmt->execute([$delete_user_id]);

        header("Location: users_managment.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>
    <link rel="stylesheet" href="/Views/public/assets/css/users_managment.css">
</head>
<body>
    <div class="container">
        <h1>Gestion des utilisateurs</h1>
        <table>
            <thead>
                <tr>
                    <th>Nom d'utilisateur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td>
                            <button onclick="window.location.href='profile.php?id=<?php echo $user['id']; ?>'">Profil</button>
                            <button onclick="window.location.href='CV.php?id=<?php echo $user['id']; ?>'">CV</button>
                            <button onclick="window.location.href='Project.php?id=<?php echo $user['id']; ?>'">Projets</button>
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="delete_user_id" value="<?php echo $user['id']; ?>">
                                <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur et toutes ses données associées ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>