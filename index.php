<?php
$title = "Acceuil";
require_once "Assets/core/config.php";
require_once "Assets/core/header.php";
require "Assets/core/Article.php";

use Core\Entity\Article;

session_name("bloggi");
session_start();

$sql = "SELECT * FROM article ORDER BY id LIMIT 6";

// Préparer la requête
$query = $lienDB->prepare($sql);

// Exécution de la requête
if ($query->execute()) {
    // traitement des résultats
    $results = $query->fetchAll();
}
$mostlike = "SELECT * FROM article ORDER BY like_article DESC LIMIT 6";

// Préparer la requête
$query2 = $lienDB->prepare($mostlike);

// Exécution de la requête
if ($query2->execute()) {
    // traitement des résultats
    $resultsmostlike = $query2->fetchAll();
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
        <a href="index.php">Home<span></span></a>
        <a href="profile.php">Profile<span></span></a>
        <a href="allarticle.php">All Article<span></span></a>
        <a href="new_article.php">New Article<span></span></a>
        <?php
        if (isset($_SESSION["role"]) && Article::FindRoleAccount($_SESSION["email"]) == "admin") {
            echo "<a href='paneladmin.php?new=yes'>Panel Admin<span></span></a>";
        }
        if (!isset($_SESSION["email"])) {
            echo "<a href='login.php'>Login<span></span></a>";
        } else {
            echo "<a href='Assets/core/logout.php'>Se Deconnecter<span></span></a>";
        }
        ?>
        <i class="fa-solid fa-xmark fa-2xl close_mod"></i>
    </div>
    <header>
        <a href="new_article.php"><i class="fa-solid fa-plus fa-xl new_article"></i></a>
        <img src="Assets/IMG/logo.png" class="logoblob">
        <h1>Bloggi</h1>
        <i class="fa-solid fa-bars fa-2xl mod"></i>
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
            <i class="fa-solid fa-magnifying-glass "></i>
            <input id="search" type="search" name="name" hx-post="Assets/core/searcharticle.php" h hx-trigger="keyup changed delay:400ms, search" hx-target=".resultarticle" autocomplete="off">
        </div>
        <div class="resultarticle">

        </div>
        <h2>Nouveauté</h2>
        <div class="middle">
            <!-- <button id="sliderleft" type="button"><i class="fa-solid fa-caret-left"></i></button> -->
            <div class="carousel">
                <div class="new-release" id="new">
                    <?php
                    $x = -1;

                    while ($x < (count($results) - 1)) {
                        $x++;
                    ?><div class="article carousel-item">
                            <?php
                            if (isset($results[$x]["image"])) {
                            ?><img src="<?= $results[$x]["image"] ?>" alt=""><?php
                                                                        }
                                                                            ?>
                            <h3><?= $results[$x]["titre"] ?></h3>
                            <p><?= substr($results[$x]["contenu"], 0, 50) ?>...</p>
                            <!-- <p class="likearticle">J'aime : <?= Article::AllComment($results[$x]["id"]) ?></p> -->
                            <!-- <p class="author">Auteur : <?= Article::FindAuthor($results[$x]["id_auteur"]); ?></p> -->
                            <a href="../../article.php?id=<?= $results[$x]["id"] ?>">Suite</a>
                        </div><?php

                            }
                                ?>
                </div>
            </div>
            <!-- <button id="slideright" type="button"><i class="fa-solid fa-caret-right"></i></button> -->
        </div>
        <h2>Top</h2>
        <div class="middle">
            <button id="sliderleftLike" type="button"><i class="fa-solid fa-caret-left"></i></button>
            <div class="carousel">
            <div class="top-topics" id="top">
                <?php
                $x = -1;

                while ($x < (count($resultsmostlike) - 1)) {
                    $x++;
                ?><div class="article carousel-item">
                        <?php
                        if (isset($resultsmostlike[$x]["image"])) {
                        ?><img src="<?= $resultsmostlike[$x]["image"] ?>" alt=""><?php
                                                                                }
                                                                                    ?>
                        <h3><?= $resultsmostlike[$x]["titre"] ?></h3>
                        <p><?= substr($resultsmostlike[$x]["contenu"], 0, 50) ?>...</p>
                        <!-- <p class="likearticle">J'aime : <?= Article::AllComment($resultsmostlike[$x]["id"]) ?></p> -->
                        <!-- <p class="author">Auteur : <?= Article::FindAuthor($resultsmostlike[$x]["id_auteur"]); ?></p> -->
                        <a href="../../article.php?id=<?= $resultsmostlike[$x]["id"] ?>">Suite</a>
                    </div><?php

                        }
                            ?>
            </div>
            </div>
            <button id="sliderightLike" type="button"><i class="fa-solid fa-caret-right"></i></button>
        </div>
        <img src="" alt="">
    </main>
    <footer>

    </footer>
</body>

</html>