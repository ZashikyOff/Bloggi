<?php
$title = "Tout les Articles";
require_once "Assets/core/config.php";
require_once "Assets/core/header.php";
require "Assets/core/Article.php";
require "Assets/core/Account.php";

use Core\Entity\Article;
use Core\Entity\Account;

session_name("bloggi");
session_start();

$sql = "SELECT * FROM article ORDER BY :filter";

// Préparer la requête
$query = $lienDB->prepare($sql);
$query->bindValue(':filter', "id");

// Exécution de la requête
if ($query->execute()) {
    // traitement des résultats
    $results = $query->fetchAll();
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
        <a href="new_article.php"><i class="fa-solid fa-plus fa-xl new_article"></i></a>
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
    <h2>All Article</h2>
    <main class="all-article">
        <?php
        $x = 0;
        while ($x <= (count($results)) - 1) {
            echo "<div class='article'>";
            if (isset($results[$x]["image"])) {
        ?><img src="<?= $results[$x]["image"] ?>" alt=""><?php
                                                        } else {
                                                            ?><img src="Assets/IMG/noimage.png" alt=""><?php
                                                                                                    }
                                                                                                        ?>
            <h3><?= $results[$x]["titre"] ?></h3>
            <p><?= substr($results[$x]["contenu"], 0, 100) . "..." ?></p>
            <a href="../../article.php?id=<?= $results[$x]["id"] ?>">Suite</a>
        <?php

            $x++;
            echo "</div>";
        }
        ?>
    </main>
    <footer>

    </footer>
</body>

</html>