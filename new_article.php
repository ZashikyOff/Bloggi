<?php
$title = "New Article";
require_once "Assets/core/config.php";
require_once "Assets/core/header.php";


session_name("bloggi");
session_start();

require "Assets/core/Account.php";
require "Assets/core/Article.php";

use Core\Entity\Article;
use Core\Entity\Account;

if (!isset($_SESSION["role"]) && !isset($_SESSION["email"])) {
    header('Location: index.php?error=no-account');
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
    <?php
    //On traite le formulaire
    if (!file_exists("Assets/IMG/IMG_article")) {
        mkdir("IMG_article");
    }
    if (!empty($_POST)) {
        //POST n'est pas vide, on vérifie que toutes les données sont présentes
        if (isset($_POST["titre"], $_POST["contenu"]) && !empty($_POST["titre"]) && !empty($_POST["contenu"])) {
            //Le formulaire est complet, on récupére les données en les protegeant (failles XSS)
            $titre = strip_tags($_POST["titre"]);

            //On neutralise toute balise du contenu
            $contenu = htmlspecialchars($_POST["contenu"]);

            $idbymail = Account::FindIdByMail($_SESSION["email"]);

            require_once "Assets/core/config.php";

            //On écrit la requete
            $sql = "INSERT INTO article (titre, contenu, id_auteur, date_creation) VALUES(:titre, :contenu, :id, :date);";

            try {

                //On prépare la requete
                $query = $lienDB->prepare($sql);


                //On injecte les valeurs
                date_default_timezone_set('Europe/Paris');
                $date = date('d-m-y h:i:s');
                $query->bindParam(":date", $date);
                $query->bindValue(":titre", $titre, PDO::PARAM_STR);
                $query->bindValue(":contenu", $contenu, PDO::PARAM_STR);
                $query->bindValue(":id", $idbymail, PDO::PARAM_INT);


                //On exécute la requete
                if ($query->execute()) {
                    $last_id = $lienDB->lastInsertId();

                    $target_dir = "Assets/IMG/IMG_article/";

                    $target_file = $target_dir . basename($last_id) . ".png";

                    move_uploaded_file($_FILES["image_article"]["tmp_name"], $target_file);

                    $sql = "UPDATE article SET image=:chemin WHERE id=:last_id";

                    // Préparer la requête
                    $query = $lienDB->prepare($sql);

                    $query->bindParam(":chemin", $target_file, PDO::PARAM_STR);
                    $query->bindParam(":last_id", $last_id, PDO::PARAM_INT);

                    if ($query->execute()) {
                        // traitement des résultats
                        $results = $query->fetch();
                    }

                    echo "Aucune erreur";
                    // header('Location: new_article.php');
                } else {
                    echo " Erreur !!!!!";
                }
            } catch (PDOException | Exception | Error $execption) {
                echo "<br><br>" . $execption->getMessage();
            }


            //On récupére l'id de l'article
            // $id = $lienDB->lastInsertId();

            // echo "Article ajouté sous le numéro $id";

        } else {
            echo "Le formulaire est incompet";
        }
    }
    //  if(isset($_POST['titre'], $_POST['contenu'])) {
    //     if(!empty($_POST['titre']) AND !empty($_POST['contenu'])) {
    //         $titre = htmlspecialchars($_POST['titre']);
    //         $contenu = htmlspecialchars($_POST['contenu']);

    //         $query = $lienDB->prepare('INSERT INTO article (titre, contenu, date_creation) VALUES (?, ?, NOW()');
    //         $query->prepare();
    //         $query->execute(array($titre, $contenu));

    //        $message = 'Votre article a bien été posté';
    //     } else {
    //         $message = 'Veuillez remplir tous les champs';
    //     }
    // }  
    ?>
    <main class="new_article">
        <h2>New Article</h2>
        <form action="" method="post" class="add_article" enctype="multipart/form-data">

            <label>Titre de l'article </label>
            <input type="text" name="titre" required autocomplete="off">

            <label>Contenu</label>
            <textarea name="contenu" cols="30" rows="10" required></textarea>

            <input type="file" name="image_article" accept="image/jpeg, image/png" required>

            <button type="submit">Publier</button>

        </form>
        <?php if (isset($message)) {
            echo $message;
        } ?>

    </main>
    <footer>

    </footer>
</body>

</html>