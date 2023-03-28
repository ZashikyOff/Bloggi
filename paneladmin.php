<?php
$title = "Panel Admin";
require_once "Assets/core/config.php";
require_once "Assets/core/header.php";

require "Assets/core/Article.php";

use Core\Entity\Article;

session_name("bloggi");
session_start();

if (isset($_GET["new"]) && $_GET["new"] == "yes") {
    if ($_SESSION["role"] == "admin") {
        if (Article::FindRoleAccount($_SESSION["email"]) == "admin") {
            header('Location: paneladmin.php');
        } else {
            header('Location: index.php');
        }
    } else {
        header('Location: index.php');
    }
}

$sql = "SELECT * FROM utilisateur ORDER BY id";

// Préparer la requête
$query = $lienDB->prepare($sql);

// Exécution de la requête
if ($query->execute()) {
    // traitement des résultats
    $results = $query->fetchAll();
}

if(isset($_GET["id"]) && isset($_GET["newrole"])){
    try {
        $sql = "UPDATE utilisateur SET role=:newrole WHERE id=:id";
    
        // Préparer la requête
        $query2 = $lienDB->prepare($sql);
        
        $query2->bindParam(":id", $_GET["id"],PDO::PARAM_INT);
        $query2->bindParam(":newrole", $_GET["newrole"],PDO::PARAM_STR);
    
        $query2->execute();
        echo 'Données mises à jour';
        header('Location: paneladmin.php');
    
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
if(isset($_GET["desactive"])){
    try {
        $sql = "UPDATE utilisateur SET activate=0 WHERE id=:id";
        // var_dump($_GET["desactive"]);

        // Préparer la requête
        $query2 = $lienDB->prepare($sql);
        
        $query2->bindParam(":id", $_GET["desactive"]);
    
        $query2->execute();
        echo 'Données mises à jour';
        header('Location: paneladmin.php');
    
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
if(isset($_GET["activate"])){
    try {
        $sql = "UPDATE utilisateur SET activate=1 WHERE id=:id";
        var_dump($_GET["activate"]);
        // Préparer la requête
        $query2 = $lienDB->prepare($sql);
        
        $query2->bindParam(":id", $_GET["activate"]);
    
        $query2->execute();
        echo 'Données mises à jour';
        header('Location: paneladmin.php');
    
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

?>

<body>
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
    <main class="index">
        <table class="GeneratedTable">
            <thead>
                <tr>
                    <th>Pseudo</th>
                    <th>Email</th>
                    <th>Ville</th>
                    <th>Pays</th>
                    <th>Desactiver</th>
                    <th>Activer</th>
                    <th>Role</th>
                    <th>New Role ?</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $x = 0;
                while ($x <= (count($results)) - 1) { ?>
                    <tr>
                        <td><?= $results[$x]["pseudo"] ?></td>
                        <td><?= $results[$x]["email"] ?></td>
                        <td><?= $results[$x]["ville"] ?></td>
                        <td><?= $results[$x]["pays"] ?></td>
                        <td><?php
                            if ($results[$x]["activate"] == 1) {
                            ?><a href="paneladmin.php?desactive=<?= $results[$x]["id"] ?>"><button>Désactiver</button></a><?php
                                                        }
                                                            ?></td>
                        <td><?php
                            if ($results[$x]["activate"] == 0) {
                            ?><a href="paneladmin.php?activate=<?=$results[$x]["id"]?>"><button>Activer</button></a><?php
                                                    }
                                                        ?></td>
                        <td><?= $results[$x]["role"] ?></td>
                        <td>
                            <form action="" method="get">
                                <select name="newrole" id="">
                                    <option value="">-- Choose --</option>
                                    <option value="utilisateur">Utilisateur</option>
                                    <option value="editeur">Editeur</option>
                                    <option value="admin">Administrateur</option>
                                </select>
                                <input type="hidden" name="id" value="<?= $results[$x]["id"] ?>">
                                <button type="submit">Valider</button>
                            </form>
                        </td>
                    </tr>
                <?php
                    $x++;
                } ?>
            </tbody>
        </table>
    </main>
    <footer>

    </footer>
</body>

</html>