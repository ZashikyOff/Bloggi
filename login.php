<?php
$title = "Login";
require_once "Assets/core/config.php";
require_once "Assets/core/header.php";
session_name("bloggi");
session_start();

if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["captcha"]) && $_POST["captcha"] == $_SESSION["vercode"]) {
  // requête SQL
  $sql = "SELECT * FROM utilisateur WHERE email=:email";
  $password = $_POST["password"];
  $email = $_POST["email"];

  // Préparer la requête
  $query = $lienDB->prepare($sql);

  // Liaison des paramètres de la requête préparée
  $query->bindParam(":email", $email, PDO::PARAM_STR);

  // Exécution de la requête
  if ($query->execute()) {
    // traitement des résultats
    $results = $query->fetch();

    // débogage des résultats
    if ($results) {
      if ($results['activate'] == 1) {
        if (password_verify($password, $results['hash'])) {
          // Connexion réussie
          $_SESSION["email"] = $_POST["email"];
          $_SESSION["role"] = $results["role"];
          header('Location: index.php');
        } else {
          echo 'Mot de passe incorrect';
        }
      } else {
        echo "Votre compte est desactiver";
      }
    } else {
      echo 'Email non trouvé';
    }
  }
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
    <a href="index.php">Home</a>
    <a href="profile.php">Profile</a>
    <a href="login.php">Login</a>
    <a href="">Contact</a>
    <i class="fa-solid fa-xmark fa-2xl close_mod"></i>
  </div>
  <header>
    <h1>Bloggi</h1>
    <i class="fa-solid fa-bars fa-xl mod"></i>
  </header>
  <main>
    <form action="" method="post">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="text" name="captcha" placeholder="Captcha" required>
      <img src="Assets/core/captcha.php">
      <button>Se Connecter</button>
    </form>
    <p>Or <a href="signin.php">Sign in</a></p>
  </main>
  <footer>

  </footer>
</body>

</html>