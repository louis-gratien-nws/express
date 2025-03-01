<?php
require 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO utilisateurs (pseudo, email, mot_de_passe) VALUES (?, ?, ?)");
    if ($stmt->execute([$pseudo, $email, $password])) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Erreur lors de l'inscription.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php
session_start();
$isHomePage = basename($_SERVER['PHP_SELF']) == "index.php"; // Vérifie si on est sur index.php
?>

<?php include 'header.php'; ?>


<main class="auth-container">
    <div class="auth-box">
        <h2>Inscription</h2>
        <form action="" method="POST">
            <label>Pseudo :</label>
            <input type="text" name="pseudo" required>
            
            <label>Email :</label>
            <input type="email" name="email" required>
            
            <label>Mot de passe :</label>
            <input type="password" name="password" required>
            
            <button type="submit" class="btn">S'inscrire</button>
        </form>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
        <p>Déjà un compte ? <a href="login.php">Se connecter</a></p>
    </div>
</main>

</body>
</html>
