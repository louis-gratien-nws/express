Express 🎥 - Projet de site de critiques de films
Description
Express 🎥 est un site web permettant aux utilisateurs de consulter des fiches de films, laisser des avis, ajouter des films à leurs favoris, et effectuer des recherches par titre de film. Le site offre une interface moderne inspirée de plateformes populaires comme Netflix, avec un design responsive et des animations fluides pour améliorer l'expérience utilisateur.

Fonctionnalités principales
Consultation de films : Visualiser les détails des films avec un affichage de l'affiche, du résumé, de la note et des commentaires.

Avis sur les films : Ajouter, modifier et supprimer des avis pour chaque film.

Favoris : Ajouter des films à une liste de favoris.

Recherche dynamique : Rechercher des films en temps réel grâce à une barre de recherche AJAX.

Authentification : Connexion, inscription, et gestion des profils utilisateurs.

Technologies utilisées
Frontend :

HTML, CSS, JavaScript (avec GSAP pour les animations)

Ajax pour la recherche en temps réel

Backend :

PHP pour la gestion du site et des utilisateurs

MySQL pour la gestion de la base de données

Installation
Cloner le dépôt Git :

bash
Copier
git clone https://github.com/ton_utilisateur/express-site.git
cd express-site
Configurer la base de données :

Crée une base de données MySQL et configure les tables movies, users, avis, et favoris selon la structure définie dans le projet.

Assure-toi d'avoir les bons identifiants dans le fichier config.php pour te connecter à la base de données.

Lancer le projet :

Installe XAMPP, MAMP ou WAMP si tu utilises un serveur local.

Place ton projet dans le dossier htdocs de XAMPP ou un dossier équivalent selon ton environnement.

Accède à http://localhost/express-site pour voir ton site en action.
