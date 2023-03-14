<?php
$title = "Profile";
require_once "Assets/core/config.php";
require_once "Assets/core/header.php";
session_name("bloggi");
session_start();

if(!isset($_SESSION["role"]) && !isset($_SESSION["email"])){
    header('Location: index.php?error=no-account');
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
    <main>
        <img src="<?= $results["img_profile"]?>" alt="">
        <div class="infos">
            <p>Pseudo : <?= $results["pseudo"]?></p>
            <p>Email : <?= $results["email"]?></p>
            <p>Date d'inscription : <?= $results["date_creation"]?></p>
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