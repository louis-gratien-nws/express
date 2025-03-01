<?php
$host = 'localhost'; // Serveur local
$dbname = 'express'; // Nom de ta base de données
$username = 'root'; // Par défaut, c'est "root" sur XAMPP
$password = ''; // Par défaut, pas de mot de passe sur XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
