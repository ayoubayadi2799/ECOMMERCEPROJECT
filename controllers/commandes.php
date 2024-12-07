<?php

class Commandes extends Model {
    
    // Méthode pour passer une commande
    public function passerCommande() {
        
        // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION['Utilisateur'])) {
            // Récupérer les données de la session panier
            $panier = $_POST;
            $keys = array_keys($panier);
            $les_produits = [] ;
            foreach($keys as $key) {
                if(strpos($key,'quantite_') === 0) {
                    $values = explode('_', $key);
                    $les_produits[$values[1]]=$_POST[$key];
                }
            }
            // Récupérer l'ID de l'utilisateur depuis la session
            $id_utilisateur = $_SESSION['Utilisateur']->id_utilisateur;
            // Instancier un objet Commande
            $commande = new Commande();
            
            // Insérer chaque produit du panier dans la table de commandes
            foreach ($les_produits as $index => $produit) {
                $quantite = $produit;
                
                // Créer une nouvelle commande dans la base de données
                $commande->passer([
                    'quantite' => $quantite,
                    'prix' => "",
                    'id_phone' => $index,
                    'id_utilisateur' => $id_utilisateur

                    // Vous pouvez ajouter d'autres attributs comme le statut, le mode de paiement, etc.
                ]);
            }
            
            // Vider le panier après avoir passé la commande
            unset($_SESSION['panier']);
            
            // Rediriger vers une page de confirmation ou une autre page
            header("Location: " . URI . "paniers/passerCommande");
            exit();
        } else {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            header("Location: " . URI . "auths/inscription");
            exit();
        }
    }
}

?>
