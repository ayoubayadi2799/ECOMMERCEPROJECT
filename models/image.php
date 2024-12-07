<?php

class Image extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->table = "Image";
    }

    /**
     * @param $data
     * @return bool
     */
    public function ajouter($data)
{
    $this->sql = "INSERT INTO $this->table (id_phone, chemin_image) VALUES (:id_phone, :chemin_image)";
    try {
        return $this->getLines($data, null);
    } catch (PDOException $e) {
        // Affiche ou log l'erreur
        echo 'Erreur lors de l\'insertion : ' . $e->getMessage();
        return false;
    }
}


}