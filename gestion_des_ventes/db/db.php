<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Paramètres de connexion à la base de données
$servername = "mysql-barhamglobalebusiness.alwaysdata.net";
$username = "346402_bgb";
$password = "776197880Ib";
$dbname = "barhamglobalebusiness_bgb";
date_default_timezone_set('Africa/Dakar');

try {
    // Créer une connexion à la base de données avec PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Configurer PDO pour lever une exception en cas d'erreur
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optionnel : définir le jeu de caractères
    $conn->exec("SET NAMES utf8");

    // Après la connexion à la base de données, définir le fuseau horaire
    $conn->exec("SET time_zone = 'Africa/Dakar'");
} catch (PDOException $e) {
    // Gérer les erreurs de connexion
    die("La connexion à la base de données a échoué : " . $e->getMessage());
}
?>
