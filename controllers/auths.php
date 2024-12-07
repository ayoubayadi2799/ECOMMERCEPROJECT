<?php

// Vérifier si ROOT est déjà définie
if (!defined('ROOT')) {
    define("ROOT", dirname(__DIR__) . "/");
}

require_once(ROOT . "app/model.php"); 
require_once(ROOT . "models/Auth.php"); 

// Créer une instance de Auth
$auth = new Auth();

class Auths extends Controllers {
    public function __construct() {
        parent::__construct();
    }

    public function main(){
        $this->render("main");
    }

    public function inscription()
    {
        if (isset($_SESSION['Utilisateur'])) {
            header("Location: " . URI . "auths/main");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
            if ($this->isValid($_POST)) {
                if ($_POST['mot_de_passe'] === $_POST['confirmation_mot_de_passe']) {
                    $userData = [
                        'nom' => $_POST['nom_utilisateur'],
                        'prenom' => $_POST['prenom_utilisateur'],
                        'email' => $_POST['email'],
                        'telephone' => $_POST['telephone'],
                        'mot_de_passe' => password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT),
                        'id_role' => Auth::CLIENT // Assurez-vous que cette constante est bien définie.
                    ];

                    $auth = new Auth();
                    
                    if ($auth->inscription($userData)) {
                        header("Location: " . URI . "auths/connexion");
                        exit;
                    } else {
                        echo "An error occurred during registration.";
                    }
                } else {
                    echo "Passwords do not match.";
                }
            } else {
                echo "Please fill in all required fields.";
            }
        } 

        $this->render("inscription");
    }

    public function connexion() {
        if (isset($_SESSION['Utilisateur'])) {
            header("Location: " . URI . "auths/home");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['connexion'])) {
            if ($this->isValid($_POST)) {
                $email = $_POST['email'];
                $mot_de_passe = $_POST['mot_de_passe'];

                $auth = new Auth();

                $user = $auth->findByEmail($email);

                if ($user) {
                    if (password_verify($mot_de_passe, $user->mot_de_passe)) {
                        $_SESSION['Utilisateur'] = $user;

                        if ($user->id_role == 1) {
                            header("Location: " . URI . "produits/admin");
                        } else {
                            header("Location: " . URI . "produits/home");
                        }
                        exit;
                    } else {
                        echo "Password invalid";
                    }
                } else {
                    echo "Email or password invalid";
                }
            } else {
                echo "Fields invalid, please check them!";
            }
        }
        $this->render('connexion');
    }

    public function deconnexion()
    {
        unset($_SESSION['Utilisateur']);
        header("Location: " . URI . "auths/main");
    }

    public function home()
    {
        $this->render('home');
    }

    public function gestion() {
        if (!isset($_SESSION['Utilisateur']) || $_SESSION['Utilisateur']->id_role != '1') {
            header("Location: " . URI . "produits/home");
            exit;
        } else {
            $auth = new Auth();
            $id_utilisateur = $_SESSION['Utilisateur']->id_utilisateur;
            $auths = $auth->getAllauths($id_utilisateur);
            $this->render('gestion', compact('auths'));
        }
    }

    public function deletuser($id_utilisateur)
    {
        if (!isset($_SESSION['Utilisateur']) || $_SESSION['Utilisateur']->id_role != '1') {
            header("Location: " . URI . "produits/home");
            exit();
        }

        if ($id_utilisateur === null || !is_numeric($id_utilisateur)) {
            echo "ID invalide";
            return;
        }
       
        $auth = new auth();
        $auth->deletuser($id_utilisateur);
        header("Location: " . URI . "auths/gestion");
        exit();
    }
    public function changerrole($id_utilisateur)
  {
    if ($_SESSION['Utilisateur']->id_role === '1') {
      $role = $_POST['role'];
      $utilisateur = new $utilisateur();
      $utilisateur->changerRole($id_utilisateur, $role);
      header("Location: " . URI . "auths/change_role");
    }
  }


}

?>
