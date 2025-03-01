<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Vous devez être connecté.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $commentaire_id = $_POST['commentaire_id'];
    $film_id = $_POST['film_id'];
    $new_comment = $_POST['new_comment'];
    $utilisateur_id = $_SESSION['user_id'];

    // Vérifier que l'utilisateur est bien propriétaire de l'avis
    $stmt = $pdo->prepare("UPDATE avis SET commentaire = ? WHERE id = ? AND utilisateur_id = ?");
    $stmt->execute([$new_comment, $commentaire_id, $utilisateur_id]);

    header("Location: film.php?id=" . $film_id);
    exit();
}
?>
