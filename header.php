<?php
session_start();
$isHomePage = basename($_SERVER['PHP_SELF']) == "index.php"; // Vérifie si on est sur index.php
?>

<header class="<?= $isHomePage ? 'transparent-header' : 'solid-header'; ?>">
    <h1><a href="index.php" class="logo">Express 🎥</a></h1>
    <nav>
        <?php if (isset($_SESSION["user_id"])): ?>
            <a href="profil.php" class="btn-header">Mon Profil</a>
            <a href="logout.php" class="btn-header btn-logout">Déconnexion</a>
        <?php else: ?>
            <a href="login.php" class="btn-header">Connexion</a>
            <a href="register.php" class="btn-header btn-register">Inscription</a>
        <?php endif; ?>
    </nav>
    <div class="search-container">
        <input type="text" id="search-input" placeholder="Rechercher un film..." />
        <div id="search-icon" class="search-icon"><i class="fas fa-search"></i></div>
    </div>
</header>
