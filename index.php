<?php
require 'config.php';

// Récupération des films depuis la base de données
try {
    $stmt = $pdo->query("SELECT * FROM movies ORDER BY release_date DESC");
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur SQL : " . $e->getMessage());
}

// Récupération des genres distincts à partir des films
$genres = [];
try {
    $stmt = $pdo->query("SELECT DISTINCT genres FROM movies");
    $genreData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($genreData as $data) {
        $genres[] = explode(',', str_replace(['[', ']', ' '], '', $data['genres']));
    }
    $genres = array_unique(array_merge(...$genres));
} catch (PDOException $e) {
    die("Erreur lors de la récupération des genres : " . $e->getMessage());
}

// Liste des genres TMDB avec leurs IDs, dans l'ordre souhaité
$genreMapping = [
    28 => 'Action', 16 => 'Animation', 18 => 'Drame', 10749 => 'Romance',
    80 => 'Crime', 10752 => 'Guerre', 14 => 'Fantasy', 35 => 'Comédie'
];

// Tri des genres selon l'ordre désiré
$orderedGenres = [28, 16, 18, 10749, 80, 10752, 14, 35];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Express - Films</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
 C
</head>
<body class="index-page">

<?php include 'header.php'; ?>


<main>
    <section class="hero-banner">
    <?php
$featuredMovieId = 569094;  // ID du film spécifique
$stmt = $pdo->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->execute([$featuredMovieId]);
$featuredMovie = $stmt->fetch(PDO::FETCH_ASSOC);
?>

    
    <div class="hero-content">
        <h1><?= htmlspecialchars($featuredMovie['title']); ?></h1>
        <p><?= htmlspecialchars($featuredMovie['overview']); ?></p>
        <a href="film.php?id=<?= $featuredMovie['id']; ?>" class="btn">Voir plus</a>
    </div>
    
    <div class="hero-bg" style="background-image: url('https://image.tmdb.org/t/p/original<?= $featuredMovie['poster_path']; ?>');"></div>
</section>

<?php foreach ($orderedGenres as $genreId): 
    $genreName = $genreMapping[$genreId] ?? 'Inconnu';
    $stmt = $pdo->prepare("SELECT * FROM movies WHERE FIND_IN_SET(?, REPLACE(REPLACE(genres, '[', ''), ']', '')) ORDER BY release_date DESC LIMIT 10");
    $stmt->execute([$genreId]);    
    $moviesByGenre = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="category">
    <h2>Genre: <?= htmlspecialchars($genreName); ?></h2>
    <div class="movie-carousel">
        <?php foreach ($moviesByGenre as $movie): ?>
            <a href="film.php?id=<?= $movie['id']; ?>" class="movie-card">
                <img src="https://image.tmdb.org/t/p/w500<?= htmlspecialchars($movie['poster_path']); ?>" alt="<?= htmlspecialchars($movie['title']); ?>">
                <h3><?= htmlspecialchars($movie['title']); ?></h3>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<?php endforeach; ?>

</main>

<script src="assets/js/theme.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
<script src="assets/js/animations.js"></script>
<script src="assets/js/theme.js"></script>

</body>
</html>
