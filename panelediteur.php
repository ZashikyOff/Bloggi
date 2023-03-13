<?php
$title = "Panel Editeur";
require_once "Assets/core/config.php";
require_once "Assets/core/header.php";

require "Assets/core/Article.php";

use Core\Entity\Article;

session_name("bloggi");
session_start();

if(isset($_GET["new"]) && $_GET["new"] == "yes"){
    if (Article::FindRoleAccount($_SESSION["email"]) == "admin" || Article::FindRoleAccount($_SESSION["email"]) == "editeur") {
        if ($_SESSION["role"] == "admin" || $_SESSION["role"] == "editeur") {
            header('Location: panelediteur.php');
        } else {
            header('Location: new_article.php');
        }
    } else {
        header('Location: new_article.php');
    }
}else {
    header('Location: new_article.php');
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
    </main>
    <footer>

    </footer>
</body>

</html>
