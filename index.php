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
$mostlike = "SELECT * FROM article ORDER BY like_article DESC LIMIT 10";

// Préparer la requête
$query2 = $lienDB->prepare($mostlike);

// Exécution de la requête
if ($query2->execute()) {
    // traitement des résultats
    $resultsmostlike = $query2->fetchAll();
}

?>

<body>
    <div class="modal_container">
        <a href="index.php">Home</a>
        <a href="profile.php">Profile</a>
        <?php
        if (!isset($_SESSION["email"])) {
            echo "<a href='login.php'>Login</a>";
        } else {
        }
        if (isset($_SESSION["email"])) {
            echo "<a href='Assets/core/logout.php'>Se Deconnecter</a>";
        } else {
        }
        ?>
        <a href="">Contact</a>
        <i class="fa-solid fa-xmark fa-2xl close_mod"></i>
    </div>
    <header>
        <a href="new_article.php"><i class="fa-solid fa-plus fa-xl new_article"></i></a>
        <img src="Assets/IMG/logo.png" class="logoblob">
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
                <p>Vous devez vous creer un compte pour pouvoir ecrire un article ou voir votre profile</p>
                <a href="index.php">OK</a>
            </div><?php
                }
                    ?>
        <div class="search">
            <input type="text">
        </div>
        <div class="middle">
            <button id="sliderleft" type="button"><i class="fa-solid fa-caret-left"></i></button>
            <div class="new-release" id="new">
                <?php
                $x = -1;

                while ($x < (count($results) - 1)) {
                    $x++;
                ?><div class="article">
                    <?php 
                    if(isset($results[$x]["image"])){
                        ?><img src="<?= $results[$x]["image"] ?>" alt=""><?php
                    }
                    ?>
                        <h3><?= $results[$x]["titre"] ?></h3>
                        <hr>
                        <p><?= substr($results[$x]["contenu"],0,50) ?>...</p>
                        <p class="likearticle">Likes : <?= $results[$x]["like_article"] ?></p>
                        <p class="author">Auteur : <?= Article::FindAuthor($results[$x]["id_auteur"]); ?></p>
                        <a href="">Suite</a>
                    </div><?php

                        }
                            ?>
            </div>
            <button id="slideright" type="button"><i class="fa-solid fa-caret-right"></i></button>
        </div>
        <div class="middle">
            <button id="sliderleftLike" type="button"><i class="fa-solid fa-caret-left"></i></button>
            <div class="top-topics" id="top">
                <?php
                $x = -1;

                while ($x < (count($resultsmostlike) - 1)) {
                    $x++;
                ?><div class="article">
                        <h3><?= $resultsmostlike[$x]["titre"] ?></h3>
                        <p><?= substr($resultsmostlike[$x]["contenu"],0,50) ?>...</p>
                        <p class="likearticle"><?= $resultsmostlike[$x]["like_article"] ?></p>
                        <p class="author">Auteur : <?= Article::FindAuthor($resultsmostlike[$x]["id_auteur"]); ?></p>
                        <a href="">Suite</a>
                    </div><?php

                        }
                            ?>
            </div>
            <button id="sliderightLike" type="button"><i class="fa-solid fa-caret-right"></i></button>
        </div>
        <img src="" alt="">
    </main>
    <footer>

    </footer>
</body>

</html>