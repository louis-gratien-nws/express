<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Erreur : Vous devez être connecté pour laisser un avis.");
}

// Vérifier que la requête est bien une soumission de formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les valeurs sont bien envoyées
    if (!isset($_POST['film_id'], $_POST['note'], $_POST['commentaire'])) {
        die("Erreur : Données invalides.");
    }

    $film_id = (int) $_POST['film_id']; // On force l'entier pour éviter les injections SQL
    $note = (int) $_POST['note'];
    $commentaire = trim($_POST['commentaire']);
    $utilisateur_id = (int) $_SESSION['user_id']; // On s'assure que c'est un entier

    // Vérifier si les champs ne sont pas vides
    if (empty($film_id) || empty($note) || empty($commentaire)) {
        die("Erreur : Tous les champs sont obligatoires.");
    }

    // Vérifier que la note est entre 1 et 5
    if ($note < 1 || $note > 5) {
        die("Erreur : La note doit être entre 1 et 5.");
    }

    // Vérifier que le film existe bien
    $stmtCheckFilm = $pdo->prepare("SELECT id FROM movies WHERE id = ?");
    $stmtCheckFilm->execute([$film_id]);

    if ($stmtCheckFilm->rowCount() === 0) {
        die("Erreur : Le film que vous essayez de commenter n'existe pas.");
    }

    // Vérifier que l'utilisateur existe bien
    $stmtCheckUser = $pdo->prepare("SELECT id FROM utilisateurs WHERE id = ?");
    $stmtCheckUser->execute([$utilisateur_id]);

    if ($stmtCheckUser->rowCount() === 0) {
        die("Erreur : L'utilisateur n'existe pas.");
    }

    // Insertion de l'avis dans la base de données
    $stmt = $pdo->prepare("INSERT INTO avis (film_id, utilisateur_id, note, commentaire, date) VALUES (?, ?, ?, ?, NOW())");
    
    try {
        $stmt->execute([$film_id, $utilisateur_id, $note, $commentaire]);
    } catch (PDOException $e) {
        die("Erreur lors de l'insertion de l'avis : " . $e->getMessage());
    }

    // Redirection vers la page du film après insertion réussie
    header("Location: film.php?id=" . $film_id);
    exit();
}
?>
