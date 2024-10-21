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
$current_user_id = $_SESSION['user_id']; // Assurez-vous que l'ID de l'utilisateur connecté est stocké dans la session
$is_admin = $_SESSION['is_admin']; // Vérifiez si l'utilisateur connecté est un administrateur

$stmt = $pdo->prepare('SELECT * FROM personal_info WHERE Users_id = ?');
$stmt->execute([$user_id]);
$personal_info = $stmt->fetch();

if (!$personal_info) {
    $stmt = $pdo->prepare('INSERT INTO personal_info (Users_id, name, title, email, phone, profile_description) VALUES (?, "", "", "", "", "")');
    $stmt->execute([$user_id]);
    $stmt = $pdo->prepare('SELECT * FROM personal_info WHERE Users_id = ?');
    $stmt->execute([$user_id]);
    $personal_info = $stmt->fetch();
}

$stmt = $pdo->prepare('SELECT u.username, p.name, p.title, p.email, p.phone, p.profile_description 
                       FROM Users u 
                       JOIN personal_info p ON u.id = p.Users_id 
                       WHERE u.id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "Utilisateur non trouvé.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $title = trim($_POST['title']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $profile_description = trim($_POST['profile_description']);

    $stmt = $pdo->prepare('UPDATE personal_info SET name = ?, title = ?, email = ?, phone = ?, profile_description = ? WHERE Users_id = ?');
    $stmt->execute([$name, $title, $email, $phone, $profile_description, $user_id]);

    header("Location: profile.php?id=$user_id");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Views/public/assets/css/profile.css">
    <title>Profil de <?php echo htmlspecialchars($user['username']); ?></title>
</head>
<body>
    <div class="navbar">
        <h1>Profil de <?php echo htmlspecialchars($user['username']); ?></h1>
    </div>
    <div class="profile-content">
        <form method="POST" action="">
            <h2><?php echo htmlspecialchars($user['name']); ?></h2>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" style="display:none;">
            <p><strong>Titre:</strong> <?php echo htmlspecialchars($user['title']); ?></p>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($user['title']); ?>" style="display:none;">
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" style="display:none;">
            <p><strong>Téléphone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" style="display:none;">
            <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($user['profile_description'])); ?></p>
            <textarea id="profile_description" name="profile_description" style="display:none;"><?php echo htmlspecialchars($user['profile_description']); ?></textarea>
            <?php if ($user_id === $current_user_id || $is_admin): ?>
                <button type="button" onclick="editAllFields()">Modifier</button>
                <button type="submit" style="display:none;" id="saveButton">Enregistrer</button>
            <?php endif; ?>
        </form>
    </div>
    <div class="back-button">
        <button onclick="window.location.href='accueil.php'">Retour à l'accueil</button>
    </div>
    <script src="/Views/public/assets/script/js/profile.js"></script>
</body>
</html>