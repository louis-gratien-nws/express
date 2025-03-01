<?php
require 'config.php';
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupérer les informations de l'utilisateur
$stmt = $pdo->prepare("SELECT pseudo, email FROM utilisateurs WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupérer les films en favoris
$stmtFavoris = $pdo->prepare("SELECT m.id, m.title, m.poster_path FROM favoris f JOIN movies m ON f.film_id = m.id WHERE f.utilisateur_id = ?");
$stmtFavoris->execute([$user_id]);
$favoris = $stmtFavoris->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de <?= htmlspecialchars($user['pseudo']); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php
session_start();
$isHomePage = basename($_SERVER['PHP_SELF']) == "index.php"; // Vérifie si on est sur index.php
?>

<?php include 'header.php'; ?>


<main class="profile-container">
    <!-- Infos utilisateur -->
    <section class="profile-info">
        <h2>Vos informations</h2>
        <p><strong>Pseudo :</strong> <?= htmlspecialchars($user['pseudo']); ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($user['email']); ?></p>
    </section>

    <!-- Section des favoris -->
    <section class="profile-favorites">
        <h2>Vos films favoris</h2>
        <div class="movie-carousel">
            <?php if (count($favoris) > 0): ?>
                <?php foreach ($favoris as $movie): ?>
                    <div class="movie-card">
                        <a href="film.php?id=<?= $movie['id']; ?>">
                            <img src="https://image.tmdb.org/t/p/w500<?= htmlspecialchars($movie['poster_path']); ?>" alt="<?= htmlspecialchars($movie['title']); ?>">
                            <h3><?= htmlspecialchars($movie['title']); ?></h3>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center;">Aucun film en favoris.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Bouton de déconnexion -->
    <a href="logout.php" class="logout-btn">Se déconnecter</a>
</main>

</body>
</html>
