<?php
session_start(); // Démarre la session
require '../../Model/db.php'; // Inclut le fichier de connexion à la base de données

// Vérifie si l'utilisateur est connecté, sinon redirige vers la page de connexion
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Récupère les informations de l'utilisateur depuis la session
$username = $_SESSION['username'];
$is_admin = $_SESSION['is_admin']; 
$user_id = $_SESSION['user_id']; 

// Prépare et exécute une requête pour récupérer les CV publics
$stmt = $pdo->prepare('SELECT c.id, c.name, c.title, c.profil FROM CV c JOIN CV_public cp ON c.id = cp.CV_id');
$stmt->execute();
$public_cvs = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupère tous les résultats de la requête
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Views/public/assets/css/accueil.css">
    <title>Accueil</title>
</head>
<body>
    <div class="navbar">
        <h1>CV en ligne</h1>
    </div>
    <div class="username-box">
        Utilisateur connecté : <?php echo htmlspecialchars($username); // Affiche le nom d'utilisateur ?>
    </div>
    <div class="main-content">
        <div class="card-container">
            <?php foreach ($public_cvs as $cv): // Boucle à travers les CV publics ?>
                <a href="CV.php?id=<?php echo $cv['id']; ?>" class="card-link">
                    <div class="card">
                        <h2><?php echo htmlspecialchars($cv['name']); // Affiche le nom du CV ?></h2>
                        <p><?php echo htmlspecialchars($cv['title']); // Affiche le titre du CV ?></p>
                        <p><?php echo nl2br(htmlspecialchars($cv['profil'])); // Affiche le profil du CV ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="sidebar">
        <h2>Options</h2>
        <ul>
            <?php if ($is_admin): // Si l'utilisateur est un administrateur ?>
                <li><a href="users_managment.php">Gérer les utilisateurs</a></li>
            <?php else: // Si l'utilisateur n'est pas un administrateur ?>
                <li><a href="profile.php?id=<?php echo $user_id; ?>">Mon profil</a></li>
                <li><a href="CV.php?id=<?php echo $user_id; ?>">Mon CV</a></li>
                <li><a href="Project.php?id=<?php echo $user_id; ?>">Mes Projets</a></li>
            <?php endif; ?>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </div>
    <footer>
        <p>&copy; <?php echo date("Y"); // Affiche l'année actuelle ?> CV Portal. All rights reserved.</p>
    </footer>
</body>
</html>