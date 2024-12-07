<?php

class Panier
{
    const PANIERS = "Paniers";

    public function __construct()
    {
        if (!(isset($_SESSION[self::PANIERS]))) {
            $_SESSION[self::PANIERS] = [];
        }
    }

    public function ajouter($id_phone, $quantite)
    {
        $_SESSION[self::PANIERS][$id_phone] = $quantite;
    }

    public function supprimer($id_phone)
    {
        unset($_SESSION[self::PANIERS][$id_phone]);
    }

    public function getAll()
    {
        $produits = [];
        // [1,12]
        foreach ($_SESSION[self::PANIERS] as $id_phone => $quantite) {
            $produit = new produit();
            // [0,[12,film]]
            $produits[] = [$quantite, $produit->getOneById(compact('id_phone'))];
        }
        return $produits;

    }


}