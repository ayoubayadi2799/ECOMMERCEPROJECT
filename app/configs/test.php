<?php
// Inclure le fichier d'initialisation ou directement les fichiers nécessaires
define("ROOT", dirname(__DIR__, 2) . "/");  // Remonte de deux niveaux dans l'arborescence
require_once(ROOT . "app/configs/connexion.php");  // Chemin vers le fichier de connexion
require_once(ROOT . "app/model.php"); 
require_once(ROOT . "models/Auth.php");  // Chemin vers le fichier de modèle

// Créer une instance de Auth
$auth = new Auth();

// Données pour tester l'inscription
$testData = [
    'nom' => 'admin',
    'prenom' => 'admin',
    'email' => 'admin@example.com',
    'telephone' => '12345678',
    'mot_de_passe' => password_hash('12345678', PASSWORD_DEFAULT),
    'id_role' => Auth::ADMIN  // Assurez-vous que la classe Auth définit bien cette constante
];

// Appeler la méthode d'inscription
$result = $auth->inscription($testData);

// Vérifier et afficher le résultat
if ($result) {
    echo "Inscription réussie\n";
} else {
    echo "Échec de l'inscription\n";
}

// Tester une récupération de données
$emailToTest = 'test@example.com';
$user = $auth->findByEmail(['email' => $emailToTest]);  // Assurez-vous que la méthode attend un tableau
if ($user) {
    echo "Récupération réussie : ";
    print_r($user);
} else {
    echo "Aucun utilisateur trouvé avec cet email\n";
}
?>
