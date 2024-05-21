<?php
// Paramètres de connexion à la base de données
$dsn = "mysql:host=localhost;dbname=contat";
$username = "root";
$password = "";

// Tentative de connexion à la base de données avec gestion des erreurs
try {
    // Création de l'instance de la connexion PDO
    $bdd = new PDO($dsn, $username, $password);

    // Configuration des options PDO
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // Affichage d'un message de succès si la connexion est établie
    // echo "Connexion à la base de données réussie.";
} catch (PDOException $e) {
    // En cas d'erreur, affichage du message d'erreur
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
