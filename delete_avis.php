<?php
require 'config.php';
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$film_id = $_POST['film_id'];
$commentaire_id = $_POST['commentaire_id'];

// Vérifier si l'utilisateur est bien l'auteur du commentaire
$stmt = $pdo->prepare("SELECT * FROM avis WHERE id = ? AND utilisateur_id = ?");
$stmt->execute([$commentaire_id, $_SESSION['user_id']]);
$commentaire = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$commentaire) {
    die("Vous n'êtes pas autorisé à supprimer cet avis.");
}

// Supprimer l'avis
$stmt = $pdo->prepare("DELETE FROM avis WHERE id = ?");
$stmt->execute([$commentaire_id]);

// Redirection vers la page du film
header("Location: film.php?id=" . $film_id);
exit();
?>
