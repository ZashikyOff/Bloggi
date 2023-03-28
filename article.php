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

$sqlcommentaire = "SELECT * FROM commentaire WHERE id_article LIKE :id";

// Préparer la requête
$query2 = $lienDB->prepare($sqlcommentaire);
$id = $_GET["id"];
$query2->bindValue(':id', $_GET['id']);

// Exécution de la requête
if ($query2->execute()) {
    // traitement des résultats
    $resultscommentaire = $query2->fetchAll();
}

if (isset($_POST["newcommentaire"])) {
    $sqlcommentaire = "INSERT INTO commentaire (message,id_auteur,id_article,date_creation) VALUES (:message, :id_auteur,:id_article,:date)";

    // Préparer la requête
    $query2 = $lienDB->prepare($sqlcommentaire);

    $id = $_GET["id"];

    date_default_timezone_set('Europe/Paris');
    $date = date('d-m-y h:i:s');

    $query2->bindParam(":date", $date);
    $query2->bindValue(':id_auteur', Account::FindIdByMail($_SESSION["email"]));
    $query2->bindValue(':id_article', $_GET['id']);
    $query2->bindValue(':message', nl2br($_POST['newcommentaire']));

    // Exécution de la requête
    if ($query2->execute()) {
        // traitement des résultats
        $resultscommentaire = $query2->fetchAll();
        header("Location: article.php?id=$id");
    }
}

if (isset($_GET["deletecomm"])) {

    $sqldelete = "DELETE FROM commentaire WHERE id=:id";

    // Préparer la requête
    $query2 = $lienDB->prepare($sqldelete);

    $id = $_GET["id"];
    $id_commentaire = $_GET["deletecomm"];

    $query2->bindParam(":id", $id_commentaire, PDO::PARAM_INT);

    // Exécution de la requête
    if ($query2->execute()) {
        // traitement des résultats
        // $resultsdelete = $query2->fetchAll();
        header("Location: article.php?id=$id");
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
        <a href="index.php">Home <span></span></a>
        <a href="profile.php">Profile <span></span></a>
        <a href="allarticle.php">All Article <span></span></a>
        <a href="new_article.php">New Article <span></span></a>
        <?php
        if (!isset($_SESSION["email"])) {
            echo "<a href='login.php'>Login <span></span></a>";
        } else {
            echo "<a href='Assets/core/logout.php'>Se Deconnecter <span></span></a>";
        }
        if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") {
            echo "<a href='paneladmin.php?new=yes'>Panel Admin <span></span></a>";
        }
        ?>
        <i class="fa-solid fa-xmark fa-2xl close_mod"></i>
    </div>
    <header>
        <a href="panelediteur.php?id=<?=$_GET["id"] ?>"><i class="fa-solid fa-gear fa-xl panel_article"></i></a>
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
    <main class="article">
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
        <div class="commentaire">
        <?php 
        if(isset($_SESSION["email"])){
            if(Article::FindRoleAccount($_SESSION["email"]) == "editeur" || Article::FindRoleAccount($_SESSION["email"]) == "admin"){
                ?>
                                
                <form action="" method="post">
                    <textarea cols="30" rows="10" name="newcommentaire" placeholder="Nouveau Commentaire ..."></textarea>
                    <button type="submit">Envoyer</button>
                </form>
                <?php
            }
        }
        ?> 
            <?php
            $x = 0;
            while ($x <= (count($resultscommentaire)) - 1) { ?>
                <div class="commentairebyarticle">
                    <p><?= nl2br($resultscommentaire[$x]["message"]) ?></p>
                    <p class="author">Auteur : <?= Article::FindAuthor($resultscommentaire[$x]["id_auteur"]); ?></p>
                    <?php
                    if (isset($_SESSION["email"])) {
                        if (Article::FindRoleAccount($_SESSION["email"]) == "editeur" || Article::FindRoleAccount($_SESSION["email"]) == "admin") {
                    ?><a href="article.php?id=<?= $_GET["id"] ?>&deletecomm=<?= $resultscommentaire[$x]["id"] ?>"><i class="fa-solid fa-trash-can"></i></a><?php
                                                                                                                                                                }
                                                                                                                                                            }
                                                                                                                                                                    ?>
                </div>
            <?php

                $x++;
            }
            ?>
        </div>
        <?php
        ?>
    </main>
    <footer>

    </footer>
</body>

</html>