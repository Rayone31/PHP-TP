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

$stmt = $pdo->prepare('SELECT * FROM CV_public WHERE CV_id = ?');
$stmt->execute([$user['cv_id']]);
$is_public = $stmt->fetch() ? true : false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $title = trim($_POST['title']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $contact = $email . ',' . $phone;
    $profil = trim($_POST['profil']);
    $competence = implode(',', array_map('trim', $_POST['competence']));
    $centre_interet = implode(',', array_map('trim', $_POST['centre_interet']));
    $formation = implode(',', array_map('trim', $_POST['formation']));
    $experience = implode(',', array_map('trim', $_POST['experience']));
    $visibility = trim($_POST['visibility']);

    $stmt = $pdo->prepare('DELETE FROM CV_public WHERE CV_id = ?');
    $stmt->execute([$user['cv_id']]);

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

// Diviser les centres d'intérêt en plusieurs éléments
$centres_interet = explode(',', $user['centre_interet'] ?? '');

// Diviser le contact en email et phone
if (strpos($user['contact'] ?? '', ',') !== false) {
    list($email, $phone) = explode(',', $user['contact']);
} else {
    $email = $user['contact'] ?? '';
    $phone = '';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Views/public/assets/css/cv.css">
    <title>CV de <?php echo htmlspecialchars($user['username'] ?? ''); ?></title>
</head>
<body>
    <div class="cv-container">
        <div class="sidebar">
            <h2 class="title"><?php echo htmlspecialchars($user['title'] ?? ''); ?></h2>
            <p class="username"><?php echo htmlspecialchars($user['username'] ?? ''); ?></p>
            <h2>Contact</h2>
            <p>- Email: <?php echo htmlspecialchars($email ?? ''); ?></p>
            <p>- Phone: <?php echo htmlspecialchars($phone ?? ''); ?></p>
            <h2>Centre d'intérêt</h2>
            <ul>
                <?php foreach ($centres_interet as $interet): ?>
                    <li>- <?php echo htmlspecialchars(trim($interet) ?? ''); ?></li>
                <?php endforeach; ?>
            </ul>
            <h2>Compétences</h2>
            <ul>
                <?php foreach (explode(',', $user['competence'] ?? '') as $competence): ?>
                    <li>- <?php echo htmlspecialchars(trim($competence) ?? ''); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="main-content">
            <div class="sections-container">
                <div id="profil-section" class="section">
                    <h2>Profil</h2>
                    <p><?php echo nl2br(htmlspecialchars($user['profil'] ?? '')); ?></p>
                </div>

                <div id="formation-section" class="section">
                    <h2>Formation</h2>
                    <ul>
                        <?php foreach (explode(',', $user['formation'] ?? '') as $formation): ?>
                            <li>- <?php echo htmlspecialchars(trim($formation) ?? ''); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div id="experience-section" class="section">
                    <h2>Expérience</h2>
                    <ul>
                        <?php foreach (explode(',', $user['experience'] ?? '') as $experience): ?>
                            <li>- <?php echo htmlspecialchars(trim($experience) ?? ''); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="actions">
        <h2>Actions</h2>
        <form method="POST" action="">
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" class="hidden-input" placeholder="Nom">
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($user['title'] ?? ''); ?>" class="hidden-input" placeholder="Titre">
            <div id="contact-fields" class="hidden-input">
                <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" placeholder="Email">
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone ?? ''); ?>" placeholder="Phone">
            </div>
            <textarea id="profil" name="profil" class="hidden-input" placeholder="Profil" rows="6"><?php echo htmlspecialchars($user['profil'] ?? ''); ?></textarea>
            <div id="competence-fields" class="hidden-input">
                <?php foreach (explode(',', $user['competence'] ?? '') as $competence): ?>
                    <div>
                        <input type="text" name="competence[]" value="<?php echo htmlspecialchars(trim($competence) ?? ''); ?>" placeholder="Compétence">
                        <button type="button" onclick="removeField(this)">Supprimer</button>
                    </div>
                <?php endforeach; ?>
                <button type="button" onclick="addField('competence')">Ajouter une compétence</button>
            </div>
            <div id="centre_interet-fields" class="hidden-input">
                <?php foreach (explode(',', $user['centre_interet'] ?? '') as $centre_interet): ?>
                    <div>
                        <input type="text" name="centre_interet[]" value="<?php echo htmlspecialchars(trim($centre_interet) ?? ''); ?>" placeholder="Centre d'intérêt">
                        <button type="button" onclick="removeField(this)">Supprimer</button>
                    </div>
                <?php endforeach; ?>
                <button type="button" onclick="addField('centre_interet')">Ajouter un centre d'intérêt</button>
            </div>
            <div id="formation-fields" class="hidden-input">
                <?php foreach (explode(',', $user['formation'] ?? '') as $formation): ?>
                    <div>
                        <input type="text" name="formation[]" value="<?php echo htmlspecialchars(trim($formation) ?? ''); ?>" placeholder="Formation">
                        <button type="button" onclick="removeField(this)">Supprimer</button>
                    </div>
                <?php endforeach; ?>
                <button type="button" onclick="addField('formation')">Ajouter une formation</button>
            </div>
            <div id="experience-fields" class="hidden-input">
                <?php foreach (explode(',', $user['experience'] ?? '') as $experience): ?>
                    <div>
                        <input type="text" name="experience[]" value="<?php echo htmlspecialchars(trim($experience) ?? ''); ?>" placeholder="Expérience">
                        <button type="button" onclick="removeField(this)">Supprimer</button>
                    </div>
                <?php endforeach; ?>
                <button type="button" onclick="addField('experience')">Ajouter une expérience</button>
            </div>
            <input type="hidden" id="visibility" name="visibility" value="<?php echo $is_public ? 'public' : 'private'; ?>">
            <?php if ($user_id === $current_user_id || $is_admin): ?>
                <button type="button" onclick="editCVFields()">Modifier</button>
                <button type="submit" class="edit-button" style="display:none;" id="saveButton">Enregistrer</button>
                <button type="button" class="hidden-input" id="toggleVisibilityButton" onclick="confirmVisibilityChange()" style="display:none;"><?php echo $is_public ? 'Public' : 'Privé'; ?></button>
            <?php endif; ?>
        </form>
        <button onclick="window.location.href='profile.php?id=<?php echo $user_id; ?>'">Profil de <?php echo htmlspecialchars($user['username'] ?? ''); ?></button>
        <button onclick="window.location.href='Project.php?id=<?php echo $user_id; ?>'">Projets de <?php echo htmlspecialchars($user['username'] ?? ''); ?></button>
        <div class="back-button">
            <button onclick="window.location.href='accueil.php'">Retour à l'accueil</button>
        </div>
    </div>
    <script src="/Views/public/assets/script/js/cv.js"></script>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> CV Portal. All rights reserved.</p>
    </footer>
</body>
</html>