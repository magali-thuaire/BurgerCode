<?php

class Database {

    private  $dbHost;
    private  $dbName;
    private  $dbUser;
    public  $dbUserPass;

    private $connection = null;

    public function __construct($dbHost, $dbName, $dbUser, $dbUserPass) {
        $this->setDBHost($dbHost)->setDBName($dbName)->setDBUser($dbUser)->setDBUserPass($dbUserPass);
    }

    public  function connect() {
        ;
        // Tentative
        try {

            // Connexion au serveur et à la base de données
            $this->connection = new PDO('mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName . ';charset=utf8', $this->dbUser , $this->dbUserPass);
            // Message d'erreur si la table n'existe pas
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Si problème -> attraper les erreurs et l'évènement
            } catch(Exception $e) {
                // Afficher le message de l'erreur
                die("Error :".$e->getMessage());
            }
        return $this->connection;
    }

    public function disconnect() {
        $this->connection = null;
    }

    public function setDBHost($dbHost) {
        $this->dbHost = $dbHost;
        return $this;
    }
    public function setDBName($dbName) {
        $this->dbName = $dbName;
        return $this;
    }
    public function setDBUser($dbUser) {
        $this->dbUser = $dbUser;
        return $this;
    }
    public function setDBUserPass($dbUserPass) {
        $this->dbUserPass = $dbUserPass;
        return $this;
    }


}

?>
