<?php
include '../db/db.php';

// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $id_produit = $_POST['id_produit'];
    $nom_produit = $_POST['nom_produit'];
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];

    // Chemin où l'image sera enregistrée dans le dossier 'images'
    $image_path = "images/" . basename($_FILES['image']['name']);

    try {
        // Requête SQL pour mettre à jour un produit
        $sql = "UPDATE Produit SET nom_produit = :nom_produit, image_path = :image_path, prix = :prix, quantite = :quantite WHERE id = :id_produit";

        // Utiliser PDO pour préparer et exécuter la requête avec des paramètres nommés
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_produit', $id_produit, PDO::PARAM_INT);
        $stmt->bindParam(':nom_produit', $nom_produit, PDO::PARAM_STR);
        $stmt->bindParam(':image_path', $image_path, PDO::PARAM_STR);
        $stmt->bindParam(':prix', $prix, PDO::PARAM_STR);
        $stmt->bindParam(':quantite', $quantite, PDO::PARAM_INT);

        // Exécuter la requête
        $stmt->execute();

        // Déplacer le fichier téléchargé vers le répertoire 'images'
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);

        // Rediriger vers la page de liste après la mise à jour
        header("Location: /Produits/listedesproduits.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur de mise à jour : " . $e->getMessage();
        // Gérer l'erreur de mise à jour selon vos besoins
    }
}
?>
