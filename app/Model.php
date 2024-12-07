<?php
// Vérifier si ROOT est déjà définie
if (!defined('ROOT')) {
    define("ROOT", dirname(__DIR__) . "/");
}

require_once(ROOT . "app/configs/connexion.php");

abstract class Model
{
    protected $sql;
    protected $table;

    public function __construct()
    {

    }

    public function getLines($params = [], $uneSeuleLigne = false)
    {
        global $oPDO;
        $stmt = $oPDO->prepare($this->sql);
        foreach ($params as $keyParam => $valParam) {
            $stmt->bindValue(":" . $keyParam, $valParam);
        }
        $resultat = $stmt->execute();

        // update delete insert
        if ($uneSeuleLigne === null) {
            return $resultat;
        }
        return $uneSeuleLigne ?
            $stmt->fetch(PDO::FETCH_OBJ) :
            $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getAll()
    {
        $this->sql = "SELECT * FROM " . $this->table;
        return $this->getLines();
    }
}
