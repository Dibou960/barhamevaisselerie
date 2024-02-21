<?php
include '../db/db.php';

// Sélectionnez les produits depuis la base de données
$sql = "SELECT * FROM Produit";
$stmt = $conn->query($sql);

// Récupérez les données sous forme de tableau associatif
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ajoutez le chemin relatif pour chaque image
foreach ($produits as &$produit) {
    $produit['image_path_relative'] = "./images/" . basename($produit['image_path']);
}

// Retournez les données au format JSON
echo json_encode($produits);
?>
