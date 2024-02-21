<?php
include '../db/db.php';

// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom_produit = $_POST['nom_produit'];
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];

    // Chemin où l'image sera enregistrée dans le dossier 'images'
    $image_path = "images/" . basename($_FILES['image']['name']);
    
    try {
        // Requête SQL pour ajouter un nouveau produit
        $sql = "INSERT INTO Produit (nom_produit, image_path, prix, quantite) VALUES (:nom_produit, :image_path, :prix, :quantite)";

        // Utiliser PDO pour préparer et exécuter la requête avec des paramètres nommés
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nom_produit', $nom_produit, PDO::PARAM_STR);
        $stmt->bindParam(':image_path', $image_path, PDO::PARAM_STR);
        $stmt->bindParam(':prix', $prix, PDO::PARAM_STR);
        $stmt->bindParam(':quantite', $quantite, PDO::PARAM_INT);

        // Exécuter la requête
        $stmt->execute();

        // Déplacer le fichier téléchargé vers le répertoire 'images'
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);

        // Rediriger vers la page d'accueil après l'ajout
        header("Location: listedesproduits.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur d'ajout : " . $e->getMessage();
        // Gérer l'erreur d'ajout selon vos besoins
    }
}
?>
