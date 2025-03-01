<?php
require 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, pseudo, mot_de_passe FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['pseudo'] = $user['pseudo'];
        header("Location: profil.php");
        exit();
    } else {
        $error = "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="assets/css/style.css">

    <?php
session_start();
$isHomePage = basename($_SERVER['PHP_SELF']) == "index.php"; // Vérifie si on est sur index.php
?>

<?php include 'header.php'; ?>


<main class="auth-container">
    <div class="auth-box">
        <h2>Connexion</h2>
        <form action="" method="POST">
            <label>Email :</label>
            <input type="email" name="email" required>
            
            <label>Mot de passe :</label>
            <input type="password" name="password" required>
            
            <button type="submit" class="btn">Se connecter</button>
        </form>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
        <p>Pas encore inscrit ? <a href="register.php">Créer un compte</a></p>
    </div>
</main>

</body>
</html>
