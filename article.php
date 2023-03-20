<?php
$title = "Acceuil";
require_once "Assets/core/config.php";
require_once "Assets/core/header.php";
require "Assets/core/Article.php";

use Core\Entity\Article;

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

?>

<body>
<div class="modal_container">
        <a href="index.php">Home</a>
        <a href="profile.php">Profile</a>
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
        <i class="fa-solid fa-plus fa-xl new_article"></i>
        <h1>Bloggi</h1>
        <i class="fa-solid fa-bars fa-xl mod"></i>
        <p class="etat_co"><?php
                            if (isset($_SESSION["email"])) {
                                echo "<i class='fa-solid fa-circle fa-2xs' style='color:green'></i>";
                                echo "Connecter";
                            } else {
                                echo "<i class='fa-solid fa-circle fa-2xs' style='color:red'></i>";
                                echo "Non Connecter";
                            }
                            ?></p>
    </header>
    <main class="article">
        <?php
        $x = 0;
        while ($x <= (count($results)) - 1) {
            if (isset($results[$x]["image"])) {
        ?><img src="<?= $results[$x]["image"] ?>" alt=""><?php
                                                        }
                                                            ?>
            <h3><?= $results[$x]["titre"] ?></h3>
            <hr>
            <p><?= $results[$x]["contenu"] ?></p>
            <p class="likearticle">Likes : <?= $results[$x]["like_article"] ?></p>
            <p class="author">Auteur : <?= Article::FindAuthor($results[$x]["id_auteur"]); ?></p>
        <?php

            $x++;
        }
        ?>
    </main>
    <footer>

    </footer>
</body>

</html>