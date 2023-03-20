<?php
$title = "New Article";
require_once "Assets/core/config.php";
require_once "Assets/core/header.php";


session_name("bloggi");
session_start();

require "Assets/core/Account.php";

use Core\Entity\Account;

if (!isset($_SESSION["role"]) && !isset($_SESSION["email"])) {
    header('Location: index.php?error=no-account');
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
        <a href="panelediteur.php?new=yes"><i class="fa-solid fa-gear fa-xl panel_article"></i></a>
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
    <?php
    //On traite le formulaire
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

                echo $sql;

                //On injecte les valeurs
                date_default_timezone_set('Europe/Paris');
                $date = date('d-m-y h:i:s');
                $query->bindParam(":date", $date);
                $query->bindValue(":titre", $titre, PDO::PARAM_STR);
                $query->bindValue(":contenu", $contenu, PDO::PARAM_STR);
                $query->bindValue(":id", $idbymail, PDO::PARAM_INT);


                //On exécute la requete
                if ($query->execute()) {
                    echo "Aucune erreur";
                    header('Location: new_article.php');
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
    <main>
        <h2>New Article</h2>
        <form action="" method="post" class="add_article">

            <label>Titre de l'article </label>
            <input type="text" name="titre">

            <label>Contenu</label>
            <textarea name="contenu" cols="30" rows="10"></textarea>

            <input type="file" name="image_article" accept="image/jpeg, image/png">

            <button>Publier</button>

        </form>
        <?php if (isset($message)) {
            echo $message;
        } ?>

    </main>
    <footer>

    </footer>
</body>

</html>