<?php
include './db/db.php';
$timestamp = time();
// file_put_contents('dernier_ajout_timestamp.txt', $timestamp);

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $produit = $_POST['produit'];
    $montant = $_POST['montant'];

    // La date actuelle
    $date_vente = date('Y-m-d H:i:s');

    try {
        // Requête SQL pour ajouter un nouvel historique de vente
        $sql = "INSERT INTO historique_ventes (produit, montant, date_vente) VALUES (:produit, :montant, :date_vente)";

        // Utiliser PDO pour préparer et exécuter la requête avec des paramètres nommés
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':produit', $produit);
        $stmt->bindParam(':montant', $montant);
        $stmt->bindParam(':date_vente', $date_vente);

        // Exécuter la requête
        $stmt->execute();

        // Rediriger vers la page d'historique des ventes après l'ajout
        header("Location: home.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur d'ajout : " . $e->getMessage();
        // Gérer l'erreur d'ajout selon vos besoins
    }
}
?>
