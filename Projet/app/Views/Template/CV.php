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

$stmt = $pdo->prepare('SELECT * FROM CV WHERE Users_id = ?');
$stmt->execute([$user_id]);
$cv_info = $stmt->fetch();

if (!$cv_info) {
    $stmt = $pdo->prepare('INSERT INTO CV (Users_id, name, title, contact, profil, competence, centre_interet, formation, experience) VALUES (?, "", "", "", "", "", "", "", "")');
    $stmt->execute([$user_id]);
    $stmt = $pdo->prepare('SELECT * FROM CV WHERE Users_id = ?');
    $stmt->execute([$user_id]);
    $cv_info = $stmt->fetch();
}

$stmt = $pdo->prepare('SELECT u.username, c.id as cv_id, c.name, c.title, c.contact, c.profil, c.competence, c.centre_interet, c.formation, c.experience 
                       FROM Users u 
                       JOIN CV c ON u.id = c.Users_id 
                       WHERE u.id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "Utilisateur non trouvé.";
    exit;
}

// Vérifiez si le CV est public
$stmt = $pdo->prepare('SELECT * FROM CV_public WHERE CV_id = ?');
$stmt->execute([$user['cv_id']]);
$is_public = $stmt->fetch() ? true : false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $title = trim($_POST['title']);
    $contact = trim($_POST['contact']);
    $profil = trim($_POST['profil']);
    $competence = trim($_POST['competence']);
    $centre_interet = trim($_POST['centre_interet']);
    $formation = trim($_POST['formation']);
    $experience = trim($_POST['experience']);
    $visibility = trim($_POST['visibility']);

    // Supprimer l'entrée existante de CV_public
    $stmt = $pdo->prepare('DELETE FROM CV_public WHERE CV_id = ?');
    $stmt->execute([$user['cv_id']]);

    // Mettre à jour le CV
    $stmt = $pdo->prepare('UPDATE CV SET name = ?, title = ?, contact = ?, profil = ?, competence = ?, centre_interet = ?, formation = ?, experience = ? WHERE Users_id = ?');
    if ($stmt->execute([$name, $title, $contact, $profil, $competence, $centre_interet, $formation, $experience, $user_id])) {
        if ($visibility === 'public') {
            $stmt = $pdo->prepare('INSERT INTO CV_public (CV_id) VALUES (?)');
            $stmt->execute([$user['cv_id']]);
        }
        header("Location: cv.php?id=$user_id");
        exit;
    } else {
        echo "Erreur lors de la mise à jour du CV.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Views/public/assets/css/cv.css">
    <title>CV de <?php echo htmlspecialchars($user['username']); ?></title>
</head>
<body>
    <div class="cv-container">
        <div class="header">
            <h1>CV de <?php echo htmlspecialchars($user['username']); ?></h1>
            <p><?php echo htmlspecialchars($user['title']); ?></p>
            <p>Contact: <?php echo htmlspecialchars($user['contact']); ?></p>
        </div>

        <div class="sections-container">
            <div id="profil-section" class="section">
                <h2>Profil</h2>
                <p><?php echo nl2br(htmlspecialchars($user['profil'])); ?></p>
            </div>

            <div id="competence-section" class="section">
                <h2>Compétences</h2>
                <ul>
                    <li><?php echo nl2br(htmlspecialchars($user['competence'])); ?></li>
                </ul>
            </div>

            <div id="centre-interet-section" class="section">
                <h2>Centre d'intérêt</h2>
                <ul>
                    <li><?php echo nl2br(htmlspecialchars($user['centre_interet'])); ?></li>
                </ul>
            </div>

            <div id="formation-section" class="section">
                <h2>Formation</h2>
                <ul>
                    <li><?php echo nl2br(htmlspecialchars($user['formation'])); ?></li>
                </ul>
            </div>
        </div>

        <div id="experience-section" class="section">
            <h2>Expérience</h2>
            <ul>
                <li><?php echo nl2br(htmlspecialchars($user['experience'])); ?></li>
            </ul>
        </div>

        <form method="POST" action="">
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" class="hidden-input" placeholder="Nom">
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($user['title']); ?>" class="hidden-input" placeholder="Titre">
            <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($user['contact']); ?>" class="hidden-input" placeholder="Contact">
            <textarea id="profil" name="profil" class="hidden-input" placeholder="Profil"><?php echo htmlspecialchars($user['profil']); ?></textarea>
            <textarea id="competence" name="competence" class="hidden-input" placeholder="Compétences"><?php echo htmlspecialchars($user['competence']); ?></textarea>
            <textarea id="centre_interet" name="centre_interet" class="hidden-input" placeholder="Centre d'intérêt"><?php echo htmlspecialchars($user['centre_interet']); ?></textarea>
            <textarea id="formation" name="formation" class="hidden-input" placeholder="Formation"><?php echo htmlspecialchars($user['formation']); ?></textarea>
            <textarea id="experience" name="experience" class="hidden-input" placeholder="Expérience"><?php echo htmlspecialchars($user['experience']); ?></textarea>
            <input type="hidden" id="visibility" name="visibility" value="<?php echo $is_public ? 'public' : 'private'; ?>">
            <button type="button" onclick="editCVFields()">Modifier</button>
            <button type="submit" class="edit-button" style="display:none;" id="saveButton">Enregistrer</button>
            <button type="button" id="toggleVisibilityButton" onclick="confirmVisibilityChange()"><?php echo $is_public ? 'Public' : 'Privé'; ?></button>
        </form>
    </div>
    <script>
        function editCVFields() {
            document.querySelectorAll('.hidden-input').forEach(input => input.style.display = 'block');
            document.getElementById('saveButton').style.display = 'block';
        }

        function confirmVisibilityChange() {
            const visibilityInput = document.getElementById('visibility');
            const toggleButton = document.getElementById('toggleVisibilityButton');
            if (visibilityInput.value === 'private') {
                if (confirm("Êtes-vous sûr de vouloir rendre ce CV public ?")) {
                    visibilityInput.value = 'public';
                    toggleButton.textContent = 'Public';
                }
            } else {
                if (confirm("Êtes-vous sûr de vouloir rendre ce CV privé ?")) {
                    visibilityInput.value = 'private';
                    toggleButton.textContent = 'Privé';
                }
            }
        }
    </script>
</body>
</html>