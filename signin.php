<?php
$title = "Sign In";
require_once "Assets/core/config.php";
require_once "Assets/core/header.php";
session_name("bloggi");
session_start();

if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["captcha"]) && $_POST["captcha"] == $_SESSION["vercode"]){

    //Valeurs du formaulaire
    //Email du compte
    $email = htmlspecialchars($_POST["email"]);
    //Password du compte
    $password = htmlspecialchars($_POST["password"]);
    //Password de confimation
    $passwordConfirm = htmlspecialchars($_POST["confirmpassword"]);
    // Ville 
    $ville = htmlspecialchars($_POST["ville"]);
    // Pays pas obligatoire
    $pays = htmlspecialchars($_POST["pays"]);
    // Pseudo du compte
    $pseudo = htmlspecialchars($_POST["pseudo"]);

    //A Condition que les deux password soit pareil
    if ($_POST["password"] == $_POST["confirmpassword"]) {
        $options = [
            'cost' => 12,
        ];
        $hashPass = password_hash($_POST["password"], PASSWORD_BCRYPT, $options);

        $sql = "INSERT INTO utilisateur (email, hash, pseudo, ville, pays, date_creation) VALUES (:email, :hashPass, :pseudo, :ville, :pays, :date)";
        $query = $lienDB->prepare($sql);

        // Liaison des paramètres de la requête préparée
        date_default_timezone_set('Europe/Paris');
        $date = date('d-m-y h:i:s');
        $query->bindParam(":date", $date);
        $query->bindParam(":email", $email);
        $query->bindParam(":hashPass", $hashPass);
        $query->bindParam(":pseudo", $pseudo);
        $query->bindParam(":ville", $ville);
        $query->bindParam(":pays", $pays);

        // Exécution de la requête
        if ($query->execute()) {
            header('Location: login.php');
        } else {
            echo "<p>Une erreur s'est produite</p>";
        }
    }
}

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
        <form action="" method="post">
            <input type="text" name="pseudo" placeholder="Pseudo ..." required>
            <input type="text" name="email" placeholder="Email ..." required>
            <input type="text" name="ville" placeholder="Ville ..." required>
            <input type="text" name="pays" placeholder="Pays ...">
            <input type="password" name="password" placeholder="Password ..." required>
            <input type="password" name="confirmpassword" placeholder="Confirmation Password" required>
            <input type="text" name="captcha" placeholder="Indiquer les nombres" required>
            <img src="Assets/core/captcha.php" alt="">
            <button>S'inscrire</button>
        </form>
        <p>Or <a href="login.php">Login</a></p>
    </main>
    <footer>

    </footer>
</body>

</html>