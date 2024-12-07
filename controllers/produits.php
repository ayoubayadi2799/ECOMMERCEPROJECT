<?php

class produits extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function home()
    {
        $produit = new produit();
        $produits = $produit->getAllproduits();
        $this->render('home', compact('produits'));
    }

    public function ajouter()
    {
        if (isset($_SESSION['Utilisateur'])) {
            if ($_SESSION['Utilisateur']->id_role == '1') {
                if (isset($_POST["ajouter"])) {
                    if ($this->isValid($_POST)) {
                        unset($_POST["ajouter"]);
                        $produit = new produit();
                        $produit->ajouter($_POST);
                        global $oPDO;
                        $id_phone = $oPDO->lastInsertId();
                        $this->importImage($id_phone);
                        header("Location: " . URI . "produits/admin");
                        return;
                    }
                }
                $this->render('ajouter');
            }
            header("Location: " . URI . "produits/home");
            return;
        }
        header("Location: " . URI . "produits/home");
    }

    public function admin()
    {
        if (isset($_SESSION['Utilisateur'])) {
            if ($_SESSION['Utilisateur']->id_role == '1') {
                $produit = new produit();
                $produits = $produit->getAllproduits();
                $this->render('admin', compact('produits'));
                return;
            }
        }
        header("Location: " . URI . "produits/home");
    }

    public function supprimer($id_phone)
    {
        if (!isset($_SESSION['Utilisateur']) || $_SESSION['Utilisateur']->id_role != '1') {
            header("Location: " . URI . "produits/home");
            exit();
        }

        if ($id_phone === null || !is_numeric($id_phone)) {
            echo "ID invalide";
            return; // Arrêter l'exécution si l'ID n'est pas valide
        }

        $produit = new produit();
        $produit->supprimer($id_phone);
        header("Location: " . URI . "produits/admin");
        exit();
    }

    public function lire($id_phone)
    {
    }

    public function importImage($id_phone)
    {
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
            $image_name = $_FILES["image"]["name"];
            $image_tmp = $_FILES["image"]["tmp_name"];
            $image_destination = "assets/" . basename($image_name); // Chemin de destination du fichier sur le serveur

            // Vérifier que le fichier est une image
            $image_type = strtolower(pathinfo($image_destination, PATHINFO_EXTENSION));
            if (!in_array($image_type, array("jpg", "jpeg", "png", "gif"))) {
                echo "Seules les images JPG, JPEG, PNG et GIF sont autorisées.";
                exit();
            }

            // Vérifier si le dossier de destination existe
            if (!file_exists(ROOT . "assets/")) {
                mkdir(ROOT . "assets/");
            }

            // Déplacer l'image téléchargée vers le dossier spécifié
            if (move_uploaded_file($image_tmp, ROOT . $image_destination)) {
                $image = new Image();
                $data = [
                    "id_phone" => $id_phone,
                    "chemin_image" => $image_destination
                ];
                $image->ajouter($data);
            } else {
                echo "Erreur lors du téléversement de l'image.";
            }
        } else {
            echo "Aucun fichier image téléversé ou erreur lors du téléversement.";
        }
    }

    public function modifier($id_phone)
    {
        if (!isset($_SESSION['Utilisateur']) || $_SESSION['Utilisateur']->id_role != '1') {
            header("Location: " . URI . "produits/home");
            exit();
        }

        if ($id_phone === null || !is_numeric($id_phone)) {
            echo "ID invalide";
            return; // Arrêter l'exécution si l'ID n'est pas valide
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modifier'])) {
            if ($this->isValid($_POST)) {
                $data = [
                    'nom' => $_POST['nom'],
                    'prix' => $_POST['prix'],
                    'description' => $_POST['description'],
                    'courte_description' => $_POST['courte_description'],
                    'quantite' => $_POST['quantite'],
                    'id_phone' => $id_phone
                ];

                $produit = new produit();
                $produit->modifier($data);

                header("Location: " . URI . "produits/admin");
                exit;
            } else {
                echo "Veuillez remplir tous les champs correctement.";
            }
        }

        $produit = new produit();
        $produit_details = $produit->getOneById(['id_phone' => $id_phone]);

        if ($produit_details) {
            $this->render('modifier', compact('produit_details'));
        } else {
            echo "Produit non trouvé.";
        }
    }
}
