<?php
function autoload($class) {
    $chemins = [ROOT . "app/", ROOT . "controllers/", ROOT . "models/"];
    foreach ($chemins as $chemin) {
        if (file_exists($chemin . $class . ".php")) {
            require_once $chemin . $class . ".php";
        }
    }
}

spl_autoload_register("autoload");

?>
