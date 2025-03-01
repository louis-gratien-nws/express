<?php
require 'config.php';

try {
    $stmt = $pdo->query("SELECT * FROM movies LIMIT 10");
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>Liste des films :</h2>";
    foreach ($movies as $movie) {
        echo "<p><strong>" . htmlspecialchars($movie['title']) . "</strong> - " . htmlspecialchars($movie['release_date']) . "</p>";
    }
} catch (PDOException $e) {
    echo "Erreur SQL : " . $e->getMessage();
}
?>
