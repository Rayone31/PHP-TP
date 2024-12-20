<?php
session_start();
require '../../Model/db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID de l'utilisateur non spécifié.";
    exit;
}

$user_id = intval($_GET['id']);
$current_user_id = $_SESSION['user_id']; 
$is_admin = $_SESSION['is_admin']; 

// Prépare et exécute une requête pour récupérer les projets de l'utilisateur
$stmt = $pdo->prepare('SELECT * FROM project WHERE User_id = ?');
$stmt->execute([$user_id]);
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si la méthode de la requête est POST, ajoute ou met à jour un projet
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        $project_id = intval($_POST['project_id']);
        $stmt = $pdo->prepare('DELETE FROM project WHERE id = ? AND User_id = ?');
        $stmt->execute([$project_id, $user_id]);
    } else {
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $project_id = intval($_POST['project_id']);
        // Si l'ID du projet est spécifié, met à jour le projet, sinon ajoute un nouveau projet
        if ($project_id) {
            $stmt = $pdo->prepare('UPDATE project SET title = ?, description = ? WHERE id = ? AND User_id = ?');
            $stmt->execute([$title, $description, $project_id, $user_id]);
        } else {
            $stmt = $pdo->prepare('INSERT INTO project (User_id, title, description) VALUES (?, ?, ?)');
            $stmt->execute([$user_id, $title, $description]);
        }
    }

    header("Location: Project.php?id=$user_id");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Views/public/assets/css/project.css">
    <title>Projets de <?php echo htmlspecialchars($_SESSION['username']); ?></title>
</head>
<body>
    <div class="navbar">
        <h1>Projets de <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    </div>
    <div class="project-content">
        <!--Affiche les projets de l'utilisateur-->
        <?php foreach ($projects as $project): ?>
            <div class="project">
                <h2><?php echo htmlspecialchars($project['title']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
                <?php if ($user_id === $current_user_id || $is_admin): ?>
                    <button type="button" onclick="editProject(<?php echo $project['id']; ?>)">Modifier</button>
                    <form method="POST" action="" style="display:inline;">
                        <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
                        <input type="hidden" name="delete" value="1">
                        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">Supprimer</button>
                    </form>
                <?php endif; ?>
            </div>
            <!--Affiche le formulaire de modification du projet-->
        <?php endforeach; ?>
        <?php if ($user_id === $current_user_id || $is_admin): ?>
            <button type="button" onclick="addNewProject()">Ajouter un nouveau projet</button>
        <?php endif; ?>
    </div>
    <!--Formulaire de création de projet-->
    <?php if ($user_id === $current_user_id || $is_admin): ?>
        <div class="project-form" style="display:none;">
            <form method="POST" action="">
                <input type="hidden" id="project_id" name="project_id" value="">
                <label for="title">Nom du projet:</label>
                <input type="text" id="title" name="title" value="">
                <label for="description">Description du projet:</label>
                <textarea id="description" name="description"></textarea>
                <button type="submit">Enregistrer</button>
                <button type="button" onclick="cancelEdit()">Annuler</button>
            </form>
        </div>
    <?php endif; ?>
    <div class="back-button">
        <button onclick="window.location.href='accueil.php'">Retour à l'accueil</button>
    </div>
    <script>
        const projects = <?php echo json_encode($projects); ?>;

        function editProject(projectId) {
            const project = projects.find(p => p.id === projectId);
            document.getElementById('project_id').value = project.id;
            document.getElementById('title').value = project.title;
            document.getElementById('description').value = project.description;
            document.querySelector('.project-form').style.display = 'block';
        }

        function addNewProject() {
            document.getElementById('project_id').value = '';
            document.getElementById('title').value = '';
            document.getElementById('description').value = '';
            document.querySelector('.project-form').style.display = 'block';
        }

        function cancelEdit() {
            document.querySelector('.project-form').style.display = 'none';
        }
    </script>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> CV Portal. All rights reserved.</p>
    </footer>
</body>
</html>