<?php

class Paniers extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
       //unset( $_SESSION[Panier::PANIERS] );
        $panier = new Panier();
        $produits = $panier->getAll();

        $this->render("index", compact('produits'));

    }

    public function modifier($id_phone)
    {

        if (is_numeric($id_phone)) {
            $quantite = $_POST['quantite'];
            if (isset($quantite) && is_numeric($quantite)) {
                $panier = new Panier();
                $panier->ajouter($id_phone, $quantite);
                header("Location: " . URI . "paniers/index");
            }
        }

    }


    public function ajouter($id_phone)
    {
       

        if (is_numeric($id_phone)) {
            $panier = new Panier();
            $panier->ajouter($id_phone, 1); 
            header("Location: " . URI . "paniers/index"); // Redirection vers la page du panier
            exit();
        } else {
            // Gérer l'erreur si l'ID n'est pas numérique
            header("Location: " . URI . "produits/home");
            exit();
        }
    }

    public function supprimer($id_phone)
    {
        if (is_numeric($id_phone)) {
            $panier = new Panier();
            $panier->supprimer($id_phone);
            header("Location: " . URI . "paniers/index");
        }
    }


}