<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CV en ligne</title>
    <link rel="stylesheet" href="..\assets\css\index.css">
</head>
<body>
    <?php
        // Personal information variables
        $name = "Hebrard Dylan";
        $title = "Apprentie Developpeur Web| établisement Ynov Campus de Toulouse";
        $email = "dylanhebrard.dh@gmail.com";
        $phone = "0618406438";
        $profileDescription = "Je suis un développeur Web passionné avec de l'expérience dans la création de sites Web et d'applications dynamiques. Compétent en HTML, CSS, JavaScript, Go, C, Cpp et technologies backend comme Node.js. Au plaisir d'apporter mes compétences à une équipe dynamique.";
    ?>

    <div class="container">
        <!-- Header Section -->
        <header>
            <h1><?php echo $name; ?></h1>
            <p><?php echo $title; ?></p>
            <p>Email: <?php echo $email; ?> | Phone: <?php echo $phone; ?></p>
        </header>

        <!-- Profile Section -->
        <section class="profile">
            <h2>Profile</h2>
            <p><?php echo $profileDescription; ?></p>
        </section>

        <!-- Education Section -->
        <section class="education">
            <h2>Education</h2>
            <p><strong>Bachelor Informatique</strong> | Ynov Campus de Toulouse | 2023 - 2025</p>
        </section>

        <!-- Skills Section -->
        <section class="skills">
            <h2>Skills</h2>
            <ul>
                <li>HTML, CSS, JavaScript</li>
                <li>Node.js, Express.js</li>
                <li>SQL</li>
                <li>Git, GitHub</li>
                <li>c, c++, java</li>
                <li>Go</li>
            </ul>
        </section>

        <!-- Projects Section -->
        <section class="projects">
            <h2>Projects</h2>
            <ul>
                <li><strong>Portfolio Website:</strong> Un site personnel présentant mon travail et mes compétences.</li>
                <li><strong>Task Manager App:</strong> Une application Web full-stack pour gérer les tâches et les délais.</li>
            </ul>
        </section>

        <!-- Footer Section -->
        <footer>
            <p>© 2024 <?php echo $name; ?> | Connect with me on <a href="">LinkedIn</a> or <a href="https://github.com/Rayone31">GitHub</a></p>
        </footer>
    </div>
</body>
</html>
