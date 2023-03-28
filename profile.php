<?php

$title = "Profile";
require_once "Assets/core/config.php";
require_once "Assets/core/header.php";
require_once "Assets/core/Account.php";
require "Assets/core/Article.php";

use Core\Entity\Account;


use Core\Entity\Article;

session_name("bloggi");
session_start();

if (!isset($_SESSION["role"]) && !isset($_SESSION["email"])) {
    header('Location: index.php?error=no-account');
}

if (!empty($_FILES)) {
    // var_dump($_POST);

    // Pour débugage
    // Identifier les clés associatives du tableau $_FILES
    // var_dump($_FILES);

    // Si le dossier uploads n'existe pas déjà, le créer
    if (!file_exists("Assets/IMG/IMG_profile")) {
        mkdir("IMG_profile");
    }

    // Identifier le dossier des fichiers uploadés
    $target_dir = "Assets/IMG/IMG_profile/";

    // Envoi simple
    if (isset($_FILES["avatar"])) {
        // Récupérer le nom original du fichier uploadé et créer le futur chemin complet
        $target_file = $target_dir . basename($_SESSION["email"] . ".png");

        // Déplacer et renommer le fichier uploadé
        move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);

        $sql = "UPDATE utilisateur SET img_profile=:chemin WHERE email =:email";

        // Préparer la requête
        $query = $lienDB->prepare($sql);

        // Liaison des paramètres de la requête préparée
        $query->bindParam(":email", $_SESSION["email"], PDO::PARAM_STR);
        $query->bindParam(":chemin", $target_file, PDO::PARAM_STR);

        // Exécution de la requête
        if ($query->execute()) {
            // traitement des résultats
            $results = $query->fetch();
        }
    }

    // Envoi multiple
    if (isset($_FILES["fichiers"])) {
        foreach ($_FILES["fichiers"]["tmp_name"] as $index => $tempFile) {
            // Attention à bien garder l'index du fichier traité pour récupérer le nom original ensuite !
            // Récupérer le nom original du fichier uploadé et créer le futur chemin complet
            $target_file = $target_dir . basename($_FILES["fichiers"]["name"][$index]);

            // Déplacer et renommer le fichier uploadé
            move_uploaded_file($tempFile, $target_file);
        }
    }

    // Envoi d'un dossier complet
    if (isset($_FILES["dossier"])) {
        foreach ($_FILES["dossier"]["tmp_name"] as $index => $tempFile) {
            // Attention à bien garder l'index du fichier traité pour récupérer le nom original ensuite !
            // Récupérer le nom original du fichier uploadé et créer le futur chemin complet
            $target_file = $target_dir . basename($_FILES["dossier"]["name"][$index]);

            // Déplacer et renommer le fichier uploadé
            move_uploaded_file($tempFile, $target_file);
        }
    }
}

$sql = "SELECT * FROM utilisateur WHERE email=:email";

// Préparer la requête
$query = $lienDB->prepare($sql);

// Liaison des paramètres de la requête préparée
$query->bindParam(":email", $_SESSION["email"], PDO::PARAM_STR);

// Exécution de la requête
if ($query->execute()) {
    // traitement des résultats
    $results = $query->fetch();
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
        <a href="new_article.php">New Article <span></span></a>
        <?php
        if (isset($_SESSION["role"]) && Article::FindRoleAccount($_SESSION["email"]) == "admin") {
            echo "<a href='paneladmin.php?new=yes'>Panel Admin <span></span></a>";
        }
        if (!isset($_SESSION["email"])) {
            echo "<a href='login.php'>Login <span></span></a>";
        } else {
            echo "<a href='Assets/core/logout.php'>Se Deconnecter <span></span></a>";
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
    <main class="profile">
        <div class="imgprofile">
            <?php
            if (Account::FindPP($_SESSION["email"]) != null) {
            ?><img src="<?= Account::FindPP($_SESSION["email"]) ?>" alt=""><?php
        } else {
            ?><form action="" method="post" enctype="multipart/form-data"><input type="file" name="avatar" id="">
                <button type="submit">Valider</button>
                </form><?php
                }?>
        </div>
        <div class="infos">
            <p>Pseudo : <?= $results["pseudo"] ?></p>
            <p>Email : <?= $results["email"] ?></p>
            <p>Votre Rôle : <?= ucfirst($results["role"]) ?></p>
            <p>Date d'inscription : <?= $results["date_creation"] ?></p>
            <p>Changer son mot de passe ?</p>
            <a href="">Cliquer Ici...</a>
            <a href="Assets/core/logout.php">Se deconnecter</a>
            <a href="?delete-account=yes">Supprimer compte</a>
        </div>
    </main>
    <footer>

    </footer>
</body>

</html>