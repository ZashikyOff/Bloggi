<?php
$title = "Acceuil";
require_once "Assets/core/config.php";
require_once "Assets/core/header.php";
require "Assets/core/Article.php";

use Core\Entity\Article;

session_name("bloggi");
session_start();

$sql = "SELECT * FROM article ORDER BY id LIMIT 10";

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
        <a href="login.php">Login</a>
        <a href="">Contact</a>
        <?php
        if (isset($_SESSION["email"])) {
            echo "<a href='Assets/core/logout.php'>Se Deconnecter</a>";
        } else {
        }
        ?>
        <i class="fa-solid fa-xmark fa-2xl close_mod"></i>
    </div>
    <header>
        <a href="new_article.php"><i class="fa-solid fa-plus fa-xl new_article"></i></a>
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
    <main class="index">
        <?php
        if (isset($_GET["error"]) && $_GET["error"] == "no-account") {
        ?><div class="alarm">
                <p>Vous devez vous creer un compte pour pouvoir ecrire un article</p>
                <a href="index.php">OK</a>
            </div><?php
                }
                    ?>
        <div class="search">
            <input type="text">
        </div>
        <div class="new-release" id="new">
            <?php
            $x = -1;

            while ($x < (count($results) - 1)) {
                $x++;
            ?><div class="article">
                    <h3><?= $results[$x]["titre"] ?></h3>
                    <p><?= $results[$x]["contenu"] ?></p>
                    <p><?= Article::FindAuthor($results[$x]["id_auteur"]); ?></p>
                    <p><?= $results[$x]["like_article"] ?></p>
                </div><?php

                    }
                        ?>
        </div>
        <div class="top-topics">

        </div>
    </main>
    <footer>

    </footer>
</body>

</html>