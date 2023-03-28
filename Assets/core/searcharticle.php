<?php
session_name('bloggi');
session_start();

require "config.php";
require "Article.php";

use Core\Entity\Article;

// Search Panel Utilisateurs

$search = $_POST["name"];
$filter = "like_article";
$sql2 = "SELECT * FROM article WHERE titre LIKE :search ORDER BY :filter DESC";
$result = $lienDB->prepare($sql2);
$result->bindValue(':search', "%$search%");
$result->bindValue(':filter', "$filter");
$result->execute();

$result2 = $result;
while ($row = $result->fetch()) : ?>

    <div class="resultatrecherche">
        <?php
        if (isset($row["image"])) {
        ?><img src="<?= $row["image"] ?>" alt=""><?php
                                                } ?>
        <h3><?= htmlspecialchars($row['titre']); ?></h3>
        <a href="../../article.php?id=<?= htmlspecialchars($row['id']); ?>">Suite</a>
    </div>

<?php endwhile;