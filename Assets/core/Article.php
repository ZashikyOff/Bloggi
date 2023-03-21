<?php

namespace Core\Entity;

use \PDO;
use \PDOException;
use \Exception;
use \Error;

class Article
{
    /* attributs (propriete properties) */
    private int $id;
    private string $titre;
    private int $id_author;
    private string $contenu;

    /** Constructeur */
    public function __construct($id = 0, $titre = "",$id_author = 0,$contenu = "")
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->id_author = $id_author;
        $this->contenu = $contenu;
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
    public static function FindAuthor(int $id_author): string {
        $sql = "SELECT pseudo FROM utilisateur WHERE id = :id;";
        $dsn = "mysql:host=localhost;port=3306;dbname=bloggi;charset=utf8";

        try {
            $pdo = new PDO($dsn, "root", "");
            // $pdo-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = $pdo-> prepare($sql);
            $query-> bindParam("id", $id_author, PDO::PARAM_INT);

            if ($query-> execute()) {
                // $query-> setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, __CLASS__);

                $result = $query-> fetch();

                return $result["pseudo"];
            }

        } catch(PDOException|Exception|Error $e) {
            echo $e-> getMessage();
        }
    }
    public static function FindRoleAccount(string $email): string {
        $sql = "SELECT role FROM utilisateur WHERE email = :email;";
        $dsn = "mysql:host=localhost;port=3306;dbname=bloggi;charset=utf8";

        try {
            $pdo = new PDO($dsn, "root", "");
            // $pdo-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = $pdo-> prepare($sql);
            $query-> bindParam("email", $email);

            if ($query-> execute()) {
                // $query-> setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, __CLASS__);

                $result = $query-> fetch();
                return $result["role"];
            }

        } catch(PDOException|Exception|Error $e) {
            echo $e-> getMessage();
        }
    }
    public static function AllComment(int $id): int {
        $sql = "SELECT * FROM commentaire WHERE id_article = :id;";
        $dsn = "mysql:host=localhost;port=3306;dbname=bloggi;charset=utf8";

        try {
            $pdo = new PDO($dsn, "root", "");
            // $pdo-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = $pdo-> prepare($sql);
            $query-> bindParam("id", $id, PDO::PARAM_INT);

            if ($query-> execute()) {
                // $query-> setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, __CLASS__);

                $result = $query-> fetchAll();
                $x = 0;
                $value = 0;
                while ($x <= (count($result)) - 1) {
                    $value = $value + 1;
                    $x++;
                }
                return $value;
            }

        } catch(PDOException|Exception|Error $e) {
            echo $e-> getMessage();
        }
    }
}
