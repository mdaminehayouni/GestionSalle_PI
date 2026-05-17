🏫 Centralized University Room Management Platform

Ce dépôt contient l’ensemble des livrables, la documentation technique et le code source de l’application de gestion centralisée des salles universitaires.

📂 Structure du projet

Voici la description détaillée des éléments présents à la racine du projet :

Nom	Type	Description
📁 maquette/	Dossier	Contient les maquettes graphiques et prototypes de l’interface utilisateur.
📁 myApp/	Dossier	💡 Cœur de l’application (Laravel) : contient tout le code source (Modèles, Vues, Contrôleurs, routes…).
📄 Base.sql	Fichier SQL	Script de création et d’initialisation de la base de données MySQL (tables + données de base).
📄 Cahier de Charge.docx	Document	Spécification des besoins fonctionnels et techniques, acteurs du système et objectifs du projet.
📄 diagramme de classe.mdj	StarUML	Modélisation des entités du système et leurs relations (UML de classe).
📄 diagramme sequence cas principaux.mdj	StarUML	Diagrammes de séquence illustrant les interactions principales (réservation, consultation, etc.).
📄 README.md	Markdown	Documentation principale du projet (ce fichier).
🚀 Installation et lancement de l’application (myApp)
1. Prérequis
PHP ≥ 8.x
Composer
MySQL (ou XAMPP / WAMP)
Node.js + NPM
2. Configuration de la base de données
Ouvrir phpMyAdmin (ou équivalent).

Créer une base de données, par exemple :

gestion_salles

Importer le fichier :

Base.sql
3. Installation du projet Laravel

Accéder au dossier du projet :

cd myApp

Installer les dépendances PHP :

composer install

Installer les dépendances front-end :

npm install
npm run dev

Créer le fichier d’environnement :

cp .env.example .env

Configurer la base de données dans .env :

DB_DATABASE=gestion_salles
DB_USERNAME=...
DB_PASSWORD=...

Générer la clé de l’application :

php artisan key:generate
4. Lancer l’application
php artisan serve

Puis accéder à :

http://127.0.0.1:8000
💡 Remarques importantes
Les fichiers .mdj proviennent de StarUML. Pour une meilleure compatibilité GitHub, il est recommandé d’exporter les diagrammes en .png et de les placer dans un dossier documentation/ ou maquette/.
Vérifiez que le fichier .env n’est jamais exposé publiquement dans un dépôt Git.
Le dossier myApp/vendor et node_modules ne doivent pas être versionnés.
