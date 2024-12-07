<?php

class  Auth extends Model
{
    const ADMIN = 1;
    const CLIENT = 2;

    public function __construct()
    {
        parent::__construct();
        $this->table = "Utilisateur";
    }

    public function inscription($data)
{
    $this->sql = "INSERT INTO " . $this->table . " (nom, prenom, email, telephone, id_role, mot_de_passe) VALUES (:nom, :prenom, :email, :telephone, :id_role, :mot_de_passe)";

    // Afficher la requête SQL générée pour vérification
    echo "Requête SQL : " . $this->sql . "<br>";

    return $this->getLines($data, null);
}


public function findByEmail($email)
{
    $this->sql = "SELECT * FROM " . $this->table . " WHERE email = :email";
    return $this->getLines(['email' => $email], true);
}

    public function updateById($data)
    {
        $this->sql = "update from " . $this->table . " set nom = :nom_utilisateur,
         prenom = :prenom_utilisateur,
         email = :email,
         telephone = :telephone,
         mot_de_passe = :mot_de_passe,
         where id_utilisateur = :id_utilisateur
         ";
        return $this->getLines($data, null);
    }

    public function deleteById($data)
    {

        $this->sql = "delete from " . $this->table . " 
        where id_utilisateur = :id_utilisateur";
        return $this->getLines($data, null);


    }
    public function getAllauths()
{
    $this->sql = "SELECT * FROM " . $this->table;
    return $this->getLines(); // Cette méthode doit être capable de gérer les requêtes sans paramètres.
}
public function deletuser($id_utilisateur)
{
    $this->sql = "DELETE FROM $this->table WHERE id_utilisateur = :id_utilisateur";
    return $this->getLines(['id_utilisateur' => $id_utilisateur]);  // Assurez-vous de passer un tableau associatif
}

public function changerRole($id_utilisateur, $role) 
{ $this->sql = "UPDATE Utilisateur SET id_role = (SELECT id_role FROM Role WHERE description = :role) WHERE id_utilisateur = :id_utilisateur"; return $this->getLines(['id_utilisateur' => $id_utilisateur, 'role' => $role], null); } }


?>
