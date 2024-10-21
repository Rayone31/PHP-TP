<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Définir les routes disponibles
$routes = [
    '/' => '../../Views/Template/index.php',
    '/login' => '../../Views/Template/login.php',
    '/register' => '../../Views/Template/register.php',
    '/accueil' => '../../Views/Template/accueil.php',
];

// Obtenir l'URL demandée
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user_id']);

// Rediriger en fonction de l'état de connexion
if ($isLoggedIn && $requestUri === '/') {
    header("Location: /accueil");
    exit;
}

// Inclure le fichier correspondant à la route
if (array_key_exists($requestUri, $routes)) {
    require $routes[$requestUri];
} else {
    // Page 404 si la route n'existe pas
    http_response_code(404);
    echo "Page not found";
}
?>