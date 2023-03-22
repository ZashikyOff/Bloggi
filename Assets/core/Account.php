<?php

namespace Core\Entity;

use \PDO;
use \PDOException;
use \Exception;
use \Error;

class Account
{
    /* attributs (propriete properties) */
    private int $id;
    private string $pseudo;
    private string $email;
    private string $ville;
    private string $pays;


    /** Constructeur */
    public function __construct($id = 0, $pseudo = "",$email = "",$ville = "",$pays ="")
    {
        $this->id = $id;
        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->ville = $ville;
        $this->pays = $pays;
    }

    /** Accesseurs */
    // setters magiques
    public function __set($attribut, $valeur)
    {
        $this->$attribut = $valeur;
    }

    // getters magiques
    public function __get($attribut)
    {
        return $this->$attribut;
    }
    public static function FindIdByMail(string $email) {
        $sql = "SELECT id FROM utilisateur WHERE email = :email;";
        $dsn = "mysql:host=localhost;port=3306;dbname=bloggi;charset=utf8";

        try {
            $pdo = new PDO($dsn, "root", "");
            // $pdo-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = $pdo-> prepare($sql);

            // Liaison des paramètres de la requête préparée
            $query->bindParam(":email", $_SESSION["email"], PDO::PARAM_STR);
            
            // Exécution de la requête
            if ($query->execute()) {
                // traitement des résultats
                $results = $query->fetch();
                return $results["id"];
            }

        } catch(PDOException|Exception|Error $e) {
            echo $e-> getMessage();
        }
    }
    public static function FindPP(string $email): string{
        $sql = "SELECT img_profile FROM utilisateur WHERE email = :email;";
        $dsn = "mysql:host=localhost;port=3306;dbname=bloggi;charset=utf8";

        try {
            $pdo = new PDO($dsn, "root", "");
            // $pdo-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = $pdo-> prepare($sql);

            // Liaison des paramètres de la requête préparée
            $query->bindParam(":email", $email, PDO::PARAM_STR);
            
            // Exécution de la requête
            if ($query->execute()) {
                // traitement des résultats
                $results = $query->fetch();
                return $results[0];
            }

        } catch(PDOException|Exception|Error $e) {
            echo $e-> getMessage();
        }
    }
}
