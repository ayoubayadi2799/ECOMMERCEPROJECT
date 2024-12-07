<?php
session_start();

define("URI", "http://localhost/dashboard/ecommerce/");

define("ROOT", str_replace("index.php", "", $_SERVER["SCRIPT_FILENAME"]));

include_once ROOT . "autoload.php";

$params = explode("/", $_GET["p"]);
$nomControllers = ucfirst($params[0]);
$action = isset($params[1]) ? $params[1] : 'index';

if (file_exists(ROOT . "controllers/$nomControllers.php")) {
    $controllers = new $nomControllers();
    if (method_exists($controllers, $action)) {
        array_shift($params);
        array_shift($params);
        call_user_func_array([$controllers, $action], $params);

    } else {
        header("Location: " . URI . "paniers/passerCommande");
    }

} else {
    header("Location: " . URI . "paniers/passerCommande");
}


?>