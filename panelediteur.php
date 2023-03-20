<?php
$title = "Panel Editeur";
require_once "Assets/core/config.php";
require_once "Assets/core/header.php";

require "Assets/core/Article.php";

use Core\Entity\Article;

session_name("bloggi");
session_start();

$sql = "SELECT * FROM article ORDER BY id";

// Préparer la requête
$query = $lienDB->prepare($sql);

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
        if (isset($_SESSION["role"]) && Article::FindRoleAccount($_SESSION["email"]) == "admin") {
            echo "<a href='paneladmin.php?new=yes'>Panel Admin</a>";
        }
        if (!isset($_SESSION["email"])) {
            echo "<a href='login.php'>Login</a>";
        } else {
            echo "<a href='Assets/core/logout.php'>Se Deconnecter</a>";
        }
        ?>
        <i class="fa-solid fa-xmark fa-2xl close_mod"></i>
    </div>
    <header>
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
    <main class="editeur">
        <div class="left">
        <?php
                $x = -1;

                while ($x < (count($results) - 1)) {
                    $x++;
                ?><div class="article">
                        <?php
                        if (isset($results[$x]["image"])) {
                        ?><img src="<?= $results[$x]["image"] ?>" alt=""><?php
                                                                        }
                                                                            ?>
                        <h3><?= $results[$x]["titre"] ?></h3>
                        <hr>
                        <p class="contenupanel"><?= $results[$x]["contenu"] ?>...</p>
                        <p class="likearticle">Likes : <?= $results[$x]["like_article"] ?></p>
                        <p class="author">Auteur : <?= Article::FindAuthor($results[$x]["id_auteur"]); ?></p>
                        <button type="button" id="morecontent" value="plus">Voir plus</button>
                    </div><?php

                        }
                            ?>
        </div>
        <div class="right">
        <?php
                $x = -1;

                while ($x < (count($results) - 1)) {
                    $x++;
                ?><form class="modifyarticle">
                    <input type="text" placeholder="Titre ...">
                    <textarea name="" id="" cols="30" rows="10" placeholder="Contenu .."></textarea>
                    <a href=""><button>Supprimer</button></a>
                    <a href=""><button>Modifier</button></a>
                    </form><?php

                        }
                            ?>

        </div>
    </main>
    <footer>

    </footer>
</body>

</html>
