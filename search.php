<?php
require 'config.php';  // Assure-toi de connecter la base de données

// Récupère le terme de recherche
$query = $_GET['query'] ?? '';

// Si la requête est définie, effectue la recherche
if ($query) {
    $stmt = $pdo->prepare("SELECT * FROM movies WHERE title LIKE :query LIMIT 10");
    $stmt->execute(['query' => '%' . $query . '%']);
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retourne les résultats en JSON
    echo json_encode(['results' => $movies]);
}
?>
