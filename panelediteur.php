<?php
$title = "Acceuil";
require_once "Assets/core/config.php";
require_once "Assets/core/header.php";
require "Assets/core/Article.php";
require "Assets/core/Account.php";

use Core\Entity\Article;
use Core\Entity\Account;

session_name("bloggi");
session_start();

if (isset($_GET["id"])) {
    $sql = "SELECT * FROM article WHERE id LIKE :id";

    // Préparer la requête
    $query = $lienDB->prepare($sql);
    $id = $_GET["id"];
    $query->bindValue(':id', "$id");

    // Exécution de la requête
    if ($query->execute()) {
        // traitement des résultats
        $results = $query->fetchAll();
    }
}

//On traite le formulaire
if (!file_exists("Assets/IMG/IMG_article")) {
    mkdir("Assets/IMG/IMG_article");
}

if (isset($_POST["titre"])) {
    //Le formulaire est complet, on récupére les données en les protegeant (failles XSS)
    $titre = strip_tags($_POST["titre"]);

    //On écrit la requete
    $sql = "UPDATE article SET titre =:titre WHERE id=:id;";

    try {

        //On prépare la requete
        $query = $lienDB->prepare($sql);


        //On injecte les valeurs
        $query->bindValue(":titre", $titre, PDO::PARAM_STR);
        $query->bindValue(":id", $id, PDO::PARAM_INT);

        //On exécute la requete
        if ($query->execute()) {
            echo "Aucune erreur";
            header('Location: panelediteur.php?id=' . $id);
        } else {
            echo " Erreur !!!!!";
        }
    } catch (PDOException | Exception | Error $execption) {
        echo "<br><br>" . $execption->getMessage();
    }
}

if (isset($_POST["contenu"])) {
    //On neutralise toute balise du contenu
    $contenu = htmlspecialchars($_POST["contenu"]);

    $sql = "UPDATE article SET contenu =:contenu WHERE id=:id;";
    try {
        //On prépare la requete
        $query = $lienDB->prepare($sql);

        //On injecte les valeurs
        $query->bindValue(":contenu", $contenu, PDO::PARAM_STR);
        $query->bindValue(":id", $id, PDO::PARAM_INT);

        //On exécute la requete
        if ($query->execute()) {
            echo "Aucune erreur";
            header('Location: panelediteur.php?id=' . $id);
        } else {
            echo " Erreur !!!!!";
        }
    } catch (PDOException | Exception | Error $execption) {
        echo "<br><br>" . $execption->getMessage();
    }
}

if (isset($_FILES["image_article"])) {
    try {
        var_dump($_FILES["image_article"]);
        $target_dir = "Assets/IMG/IMG_article/";

        $target_file = $target_dir . basename($_GET["id"]) . ".png";
        $sql = "UPDATE article SET image=:chemin WHERE id=:id;";
        //On prépare la requete
        $query = $lienDB->prepare($sql);

        //On injecte les valeurs
        $query->bindValue(":chemin", $target_file, PDO::PARAM_STR);
        $query->bindValue(":id", $_GET["id"], PDO::PARAM_INT);

        //On exécute la requete
        if ($query->execute()) {
            move_uploaded_file($_FILES["image_article"]["tmp_name"], $target_file);
            header('Location: panelediteur.php?id=' . $id);
        } else {
            echo " Erreur !!!!!";
        }
    } catch (PDOException | Exception | Error $execption) {
        echo "<br><br>" . $execption->getMessage();
    }
}
?>

<body>
    <div class="area">
        <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>
    <div class="modal_container">
        <a href="index.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="allarticle.php">All Article</a>
        <a href="new_article.php">New Article</a>
        <?php
        if (!isset($_SESSION["email"])) {
            echo "<a href='login.php'>Login</a>";
        } else {
            echo "<a href='Assets/core/logout.php'>Se Deconnecter</a>";
        }
        if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") {
            echo "<a href='paneladmin.php?new=yes'>Panel Admin</a>";
        }
        ?>
        <i class="fa-solid fa-xmark fa-2xl close_mod"></i>
    </div>
    <header>
        <h1>Bloggi</h1>
        <i class="fa-solid fa-bars fa-xl mod"></i>
        <p class="etat_co"><?php
                            if (isset($_SESSION["email"])) {
                                echo "<i class='fa-solid fa-circle fa-2xs' style='color:#F3DFC1'></i>";
                                echo "Connecter";
                            } else {
                                echo "<i class='fa-solid fa-circle fa-2xs' style='color:#565656'></i>";
                                echo "Non Connecter";
                            }
                            ?></p>
    </header>
    <main class="article editeur">
        <div class="article">
            <?php
            $x = 0;
            while ($x <= (count($results)) - 1) {
                if (isset($results[$x]["image"])) {
            ?><img src="<?= $results[$x]["image"] ?>" alt=""><?php
                                                            }
                                                                ?>
                <h3><?= $results[$x]["titre"] ?></h3>
                <p><?= $results[$x]["contenu"] ?></p>
                <p class="likearticle">J'aime : <?= Article::AllComment($id) ?></p>
                <p class="author">Auteur : <?= Article::FindAuthor($results[$x]["id_auteur"]); ?></p>
            <?php

                $x++;
            }
            ?>
        </div>
        <label>Titre de l'article </label>
        <form action="" method="post" class="add_article">
            <input type="text" name="titre" autocomplete="off" required>
            <button type="submit">Mettre a jour</button>
        </form>

        <label>Contenu</label>
        <form action="" method="post" class="add_article">
            <textarea name="contenu" cols="30" rows="10" required></textarea>
            <button type="submit">Mettre a jour</button>
        </form>

        <form action="" method="post" class="add_article" enctype="multipart/form-data">
            <input type="file" name="image_article" accept="image/jpeg, image/png, image/jpg" required>
            <button type="submit">Mettre a jour</button>
        </form>
    </main>
    <footer>

    </footer>
</body>

</html>