<?php
$title = "Acceuil";
require_once "Assets/core/config.php";
require_once "Assets/core/header.php";
require "Assets/core/Article.php";

use Core\Entity\Article;

session_name("bloggi");
session_start();

?>
<body>
    <div class="modal_container">
        <a href="index.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="login.php">Login</a>
        <a href="">Contact</a>
        <i class="fa-solid fa-xmark fa-2xl close_mod"></i>
    </div>
    <header>
        <i class="fa-solid fa-plus fa-xl new_article"></i>
        <h1>Bloggi</h1>
        <i class="fa-solid fa-bars fa-xl mod"></i>
    </header>
    <main>
    </main>
    <footer>

    </footer>
</body>

</html>