<?php
require 'config.php';
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$film_id = $_POST['film_id'] ?? null;
$action = $_POST['action'] ?? null;

if ($film_id && $action) {
    if ($action === "add") {
        // Ajouter aux favoris
        $stmt = $pdo->prepare("INSERT INTO favoris (utilisateur_id, film_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $film_id]);
    } elseif ($action === "remove") {
        // Retirer des favoris
        $stmt = $pdo->prepare("DELETE FROM favoris WHERE utilisateur_id = ? AND film_id = ?");
        $stmt->execute([$user_id, $film_id]);
    }
}

// Rediriger vers la page du film
header("Location: film.php?id=" . $film_id);
exit();
