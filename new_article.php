<?php
$title = "New Article";
require_once "Assets/core/config.php";
require_once "Assets/core/header.php";


session_name("bloggi");
session_start();

if(!isset($_SESSION["role"]) && !isset($_SESSION["email"])){
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
    <main class="index">
        <?php 
        var_dump($_SESSION["email"])
        ?>
    </main>
    <footer>

    </footer>
</body>

</html>