<?php 
// Connexion à la base de données
$dsn = "mysql:host=localhost;port=3306;dbname=bloggi;charset=utf8";
$dbUser = "root";
$dbPassword = "";
$lienDB = new PDO($dsn, $dbUser, $dbPassword);