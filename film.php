<?php
require 'config.php';
session_start();

// Vérifie si un ID de film est présent dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Aucun film sélectionné.");
}

$film_id = $_GET['id'];

// Récupération des détails du film
$stmt = $pdo->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->execute([$film_id]);
$film = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$film) {
    die("Film introuvable.");
}

// Récupération des commentaires liés au film avec les pseudos des utilisateurs
$stmt = $pdo->prepare("SELECT avis.*, utilisateurs.pseudo 
                        FROM avis 
                        JOIN utilisateurs ON avis.utilisateur_id = utilisateurs.id 
                        WHERE avis.film_id = ? 
                        ORDER BY avis.date DESC");
$stmt->execute([$film_id]);
$commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si l'utilisateur est connecté et si le film est déjà en favoris
$estEnFavori = false;
if (isset($_SESSION['user_id'])) {
    $stmtCheckFavoris = $pdo->prepare("SELECT * FROM favoris WHERE utilisateur_id = ? AND film_id = ?");
    $stmtCheckFavoris->execute([$_SESSION['user_id'], $film_id]);
    $estEnFavori = $stmtCheckFavoris->rowCount() > 0;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($film['title']) ?> - Détails du film</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script>
        function toggleEditForm(commentId) {
            let form = document.getElementById("edit-form-" + commentId);
            form.style.display = form.style.display === "none" ? "block" : "none";
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
</head>
<body class="solid-header-page">

<?php include 'header.php'; ?>

<main class="film-container">
    <div class="film-content">
        <div class="film-affiche">
            <img src="https://image.tmdb.org/t/p/w500<?= htmlspecialchars($film['poster_path']); ?>" alt="<?= htmlspecialchars($film['title']); ?>">
        </div>

        <div class="film-details">
            <h1><?= htmlspecialchars($film['title']); ?></h1>
            <p class="film-description"><strong>Résumé :</strong> <?= htmlspecialchars($film['overview']); ?></p>
            <div class="film-infos">
                <p><strong>Sortie le :</strong> <?= htmlspecialchars($film['release_date']); ?></p>
                <p><strong>Note moyenne :</strong> <?= isset($film['note_moyenne']) ? $film['note_moyenne'] . "/5" : "Non noté"; ?></p>
            </div>

            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="favoris-section">
                    <form action="favoris.php" method="POST">
                        <input type="hidden" name="film_id" value="<?= $film_id ?>">
                        <?php if ($estEnFavori): ?>
                            <button type="submit" name="action" value="remove" class="btn btn-remove-favori">Retirer des favoris</button>
                        <?php else: ?>
                            <button type="submit" name="action" value="add" class="btn btn-add-favori">Ajouter aux favoris</button>
                        <?php endif; ?>
                    </form>
                </div>
            <?php endif; ?>

            <div class="avis-section">
                <h2>Laisser un avis</h2>
                <form method="post" action="submit_review.php">
                    <input type="hidden" name="film_id" value="<?= $film_id ?>">
                    <label for="note">Note (1 à 5) :</label>
                    <input type="number" name="note" min="1" max="5" required>
                    <label for="commentaire">Commentaire :</label>
                    <textarea name="commentaire" required></textarea>
                    <button type="submit" class="btn">Envoyer</button>
                </form>
            </div>

            <div class="commentaires">
                <h2>Commentaires</h2>
                <?php if (count($commentaires) > 0): ?>
                    <?php foreach ($commentaires as $commentaire): ?>
                        <div class="commentaire">
                            <p><strong><?= htmlspecialchars($commentaire['pseudo']); ?></strong> (<?= $commentaire['date']; ?>) :</p>
                            <p><?= htmlspecialchars($commentaire['commentaire']); ?></p>

                            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $commentaire['utilisateur_id']): ?>
                                <div class="comment-buttons">
                                    <form method="post" action="delete_avis.php">
                                        <input type="hidden" name="film_id" value="<?= $film_id ?>">
                                        <input type="hidden" name="commentaire_id" value="<?= $commentaire['id']; ?>">
                                        <button type="submit" class="btn btn-delete-avis">Supprimer</button>
                                    </form>
                                    <button class="btn btn-edit-avis" onclick="toggleEditForm(<?= $commentaire['id']; ?>)">Modifier</button>
                                </div>
                                <form method="post" action="update_avis.php" class="edit-avis-form" id="edit-form-<?= $commentaire['id']; ?>" style="display: none; margin-top: 10px;">
                                    <input type="hidden" name="film_id" value="<?= $film_id ?>">
                                    <input type="hidden" name="commentaire_id" value="<?= $commentaire['id']; ?>">
                                    <label for="new_comment">Modifier votre commentaire :</label>
                                    <textarea name="new_comment" required><?= htmlspecialchars($commentaire['commentaire']); ?></textarea>
                                    <button type="submit" class="btn btn-update-avis">Mettre à jour</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun commentaire pour ce film.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<script src="assets/js/theme.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
<script src="assets/js/animations.js"></script>
<script src="assets/js/theme.js"></script>

</body>
</html>