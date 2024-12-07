<?php

define('DB_SERVEUR', '127.0.0.1'); // Adresse du serveur de base de données
define('DB_NOM', 'Cineshop'); // Nom de la base de données
// Data Source Name : driver + adresse serveur + nom bdd + charset à utiliser
define('DB_DSN', 'mysql:host=' . DB_SERVEUR . ';dbname=' . DB_NOM . ';charset=utf8');
define('DB_LOGIN', 'root'); // Login
define('DB_PASSWORD', ''); // Mot de passe
global $oPDO; // Variable globale pour utilisation dans des méthodes
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Gestion des erreurs par des exceptions de la classe PDOException
    PDO::ATTR_EMULATE_PREPARES => false // Préparation des requêtes non émulée
];

try {
    // Établir une connexion à la base de données
    $oPDO = new PDO(DB_DSN, DB_LOGIN, DB_PASSWORD, $options);
    
    
} catch(PDOException $e) {
    // Afficher un message d'erreur si la connexion échoue
    die("Échec de la connexion à la base de données : " . $e->getMessage());
}
?>
