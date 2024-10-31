CV-PHP Platform - Online CV creation and sharing platform
Description
This project is a dynamic online CV web platform that allows users to create their own accounts, post their CVs online and collaborate with other users. It is an application developed in PHP with server and database side management to ensure dynamic interaction. The main objective is to allow users to generate and share their CVs online in a simple and efficient way.

Features
1. User management:
User Registration: New users can create an account 
Login: Registered users can log in with their name and password.
Profile management: Each user has a profile that they can modify, including personal information, skills, and a biography.
2. Creation and management of CVs:
CV creation: Users can create their CV directly on the platform by entering their personal information, skills, experience, training, etc.
Resume Update: Users can edit or update their resume at any time.
3. Collaboration:
CV Sharing: Each CV can be shared with other users
Collaboration: Users can collaborate on projects in groups
4. Security:
Rights management: Users can choose who to share their CVs and projects with (private, public or user-specific).
Data protecgittion: Encrypting passwords and implementing best practices for data security.

_____________________________________________________________________________________________________________________________________________________________________________

CV-PHP Platform - Plateforme de création et de partage de CV en ligne
Description
Ce projet est une plateforme web dynamique de CV en ligne qui permet aux utilisateurs de créer leurs propres comptes, de publier leurs CV en ligne et de collaborer avec d'autres utilisateurs. C'est une application développée en PHP avec une gestion côté serveur et base de données pour assurer une interaction dynamique. L'objectif principal est de permettre aux utilisateurs de générer et de partager leurs CV en ligne de manière simple et efficace.

Fonctionnalités
Gestion des utilisateurs :

Inscription des utilisateurs : Les nouveaux utilisateurs peuvent créer un compte.
Connexion : Les utilisateurs enregistrés peuvent se connecter avec leur name et mot de passe.
Gestion du profil : Chaque utilisateur dispose d'un profil qu'il peut modifier, incluant des informations personnelles, des compétences et une biographie.
Création et gestion des CV :

Création de CV : Les utilisateurs peuvent créer leur CV directement sur la plateforme en saisissant leurs informations personnelles, compétences, expériences, formations, etc.
Mise à jour du CV : Les utilisateurs peuvent modifier ou mettre à jour leur CV à tout moment.
Collaboration :

Partage de CV : Chaque CV peut être partagé avec d'autres utilisateurs.
Collaboration : Les utilisateurs peuvent collaborer sur des projets en groupes.
Sécurité :

Gestion des droits : Les utilisateurs peuvent choisir avec qui partager leurs CV et projets (privé, public ou spécifique à certains utilisateurs).
Protection des données : Chiffrement des mots de passe et mise en œuvre des meilleures pratiques pour la sécurité des données.


Projet lancement
Étape 1
Ouvrir Docker

Étape 2
Cloner le projet
git clone https://github.com/Rayone31/PHP-TP.git

Étape 3
Créer et basculer sur la branche dylan
git checkout -b dylan

Étape 4
Naviguer dans le répertoire docker
cd docker

Étape 5
Démarrer les services Docker
docker-compose up

étape 6 
se connecter a la page 
127.0.0.1

Root:
127.0.0.1:8080

user : root
mdp : root

étape 7 

importer la table setup.sql qui se trouve dans :

Projet\app\Model\setup.sql

Problème non résolue :

-Dossier Controller vide 
-system de route pas présent 
-system de mot de passe oublier avec email
-system de sauvegarde de base de donnée 
-...