<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$routes = [
    '/' => '../../Views/Template/index.php',
    '/login' => '../../Views/Template/login.php',
    '/register' => '../../Views/Template/register.php',
    '/accueil' => '../../Views/Template/accueil.php',
];

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$isLoggedIn = isset($_SESSION['user_id']);

if ($isLoggedIn && $requestUri === '/') {
    header("Location: /accueil");
    exit;
}

if (array_key_exists($requestUri, $routes)) {
    require $routes[$requestUri];
} else {
    http_response_code(404);
    echo "Page not found";
}
?>