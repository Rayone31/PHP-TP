<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon CV en ligne</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            text-align: center;
        }
        nav {
            margin: 20px;
            text-align: center;
        }
        nav a {
            margin: 10px;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            text-decoration: none;
        }
        nav a:hover {
            background-color: #4CAF50;
        }
        section {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #4CAF50;
        }
    </style>
</head>
<body>

<header>
    <h1>Bienvenue sur mon CV en ligne</h1>
</header>

<nav>
    <a href="about.php">À propos</a>
    <a href="skills.php">Compétences</a>
    <a href="experience.php">Expérience</a>
    <a href="contact.php">Contact</a>
</nav>

<section>
    <h2>Présentation</h2>
    <p>
        Bonjour, je suis [Votre Nom], un développeur web avec [X] années d'expérience dans le développement de sites web et d'applications web. 
        Mon expertise inclut HTML, CSS, JavaScript, PHP et divers frameworks. Je suis passionné par la création de solutions web élégantes, 
        efficaces et fonctionnelles.
    </p>
</section>

<section>
    <h2>Compétences principales</h2>
    <ul>
        <li>HTML5, CSS3, JavaScript</li>
        <li>PHP, MySQL</li>
        <li>Frameworks: Laravel, Symfony</li>
        <li>Outils: Git, Docker, Visual Studio Code</li>
    </ul>
</section>

<section>
    <h2>Expérience professionnelle</h2>
    <ul>
        <li><strong>Développeur Web chez XYZ</strong> (2020 - Présent) : Développement et maintenance de sites web pour des clients divers.</li>
        <li><strong>Stage chez ABC Solutions</strong> (2018 - 2019) : Conception de sites web pour des PME, intégration de designs responsives.</li>
    </ul>
</section>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Mon CV en ligne - Tous droits réservés.</p>
</footer>

</body>
</html>
