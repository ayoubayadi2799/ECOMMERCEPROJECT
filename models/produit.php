<?php

class produit extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = "phone";
    }

    public function ajouter($data)
    {
        $this->sql = "INSERT INTO " . $this->table . "(
            nom, 
            prix,
            description, 
            courte_description,
            quantite) VALUES (:nom, 
            :prix,
            :description, 
            :courte_description,
            :quantite)";
        return $this->getLines($data, null);
    }

    public function getAllproduits()
    {
        $this->sql = "SELECT f.*, i.chemin_image FROM $this->table f LEFT JOIN Image i ON f.id_phone = i.id_phone";
        return $this->getLines();
    }

    public function supprimer($id_phone)
    {
        $this->sql = "DELETE FROM $this->table WHERE id_phone = :id_phone";
        return $this->getLines(['id_phone' => $id_phone]);  // Assurez-vous de passer un tableau associatif
    }

    public function getOneById($data)
    {
        $this->sql = "SELECT f.*, i.chemin_image FROM $this->table f LEFT JOIN Image i ON f.id_phone = i.id_phone WHERE f.id_phone = :id_phone";
        return $this->getLines($data, true);
    }

    public function modifier($data)
    {
       $this->sql = "UPDATE " . $this->table . " SET nom = :nom, prix = :prix, description = :description, courte_description = :courte_description, quantite = :quantite WHERE id_Phone = :id_phone ;";
        return $this->getLines($data, null);
    }

// UPDATE `phone` SET `nom` = 'air force 2', `description` = 'ghjk 5', `courte_description` = 'hnjmk 5', `quantite` = '333' WHERE `phone`.`id_Phone` = 20;
    /** 'nom' => $_POST['nom'],
                    'prix' => $_POST['prix'],
                    'description' => $_POST['description'],
                    'courte_description' => $_POST['courte_description'],
                    'quantite' => $_POST['quantite'],
                    'id_phone' => $id_phone*/

}
?>