<?php

class Commande extends model
 {
    public function __construct()
    {
        parent::__construct();
        $this->table = "commande";
    }
    // Méthode statique pour créer une nouvelle commande
    public function passer($data)
{
    $this->sql = "INSERT INTO " . $this->table . "(quantite, prix, id_Phone, id_utilisateur) VALUES (:quantite, :prix, :id_phone, :id_utilisateur)";

    // Afficher la requête SQL générée pour vérification
    echo "Requête SQL : " . $this->sql . "<br>";

    return $this->getLines($data, null);
}

}

?>
